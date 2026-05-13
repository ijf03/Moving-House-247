<?php
declare(strict_types=1);

namespace App\Controller;

/**
 * Jobs Controller
 *
 * @property \App\Model\Table\JobsTable $Jobs
 */
class JobsController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $identity = $this->request->getAttribute('identity');
        if (!$identity || (int)$identity->get('user_type') !== 1) {
            $this->Flash->error(__('Only admins can access this page.'));
            return $this->redirect(['controller' => 'Pages', 'action' => 'display', 'home']);
        }
        $this->checkExpiredJobs();
        $query = $this->Jobs->find()
            ->contain(['JobTypes', 'Customers'])
            ->orderByAsc(
                $this->Jobs->query()->newExpr("
                CASE
                    WHEN Jobs.status = 'Pending' THEN 1
                    WHEN Jobs.status = 'Processing' THEN 2
                    WHEN Jobs.status = 'Ready' THEN 3
                    WHEN Jobs.status = 'Cancelled' THEN 4
                    WHEN Jobs.status = 'Completed' THEN 5
                    ELSE 6
                END
            ")
            )
            ->orderBy(['Jobs.job_date' => 'ASC']);

        $jobs = $this->paginate($query);
        $staffJobsTable = $this->fetchTable('StaffJob');

        foreach ($jobs as $job) {
            $job->driver_count = $staffJobsTable->find()
                ->where([
                    'job_id' => $job->job_id,
                    'status' => 'Confirmed',
                    'role' => 'Driver',
                ])
                ->count();

            $job->porter_count = $staffJobsTable->find()
                ->where([
                    'job_id' => $job->job_id,
                    'status' => 'Confirmed',
                    'role' => 'Porter',
                ])
                ->count();

            $job->confirmed_count = $staffJobsTable->find()
                ->where([
                    'job_id' => $job->job_id,
                    'status' => 'Confirmed',
                ])
                ->count();
        }

        $this->set(compact('jobs'));
    }

    /**
     * View method
     *
     * @param string|null $id Job id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $identity = $this->request->getAttribute('identity');

        if (!$identity) {
            $this->Flash->error(__('You must be logged in.'));
            return $this->redirect(['controller' => 'Users', 'action' => 'login']);
        }

        $role = (int)$identity->get('user_type');

        $job = $this->Jobs->get($id, contain: [
            'JobTypes',
            'Customers',
            'JobTrucks.Trucks',
        ]);

        $staffJobsTable = $this->fetchTable('StaffJob');
        $staffTable = $this->fetchTable('Staff');

        $staffJob = null;
        $isDriver = false;

        if ($role === 2) {
            $currentStaff = $staffTable->find()
                ->where(['email' => $identity->get('email')])
                ->first();

            if ($currentStaff) {
                $isDriver = (int)$currentStaff->isDriver === 1;

                $staffJob = $staffJobsTable->find()
                    ->where([
                        'job_id' => $id,
                        'staff_id' => $currentStaff->staff_id,
                    ])
                    ->first();
            }
        }
        $job->driver_count = $staffJobsTable->find()
            ->where([
                'job_id' => $id,
                'status' => 'Confirmed',
                'role' => 'Driver',
            ])
            ->count();

        $job->porter_count = $staffJobsTable->find()
            ->where([
                'job_id' => $id,
                'status' => 'Confirmed',
                'role' => 'Porter',
            ])
            ->count();

        $jobReports = $staffJobsTable->find()
            ->contain(['Staff'])
            ->where([
                'StaffJob.job_id' => $id,
                'StaffJob.status' => 'Confirmed',
                'StaffJob.report_outcome IS NOT' => null,
            ])
            ->all();
        $assignedStaff = $staffJobsTable->find()
            ->contain(['Staff'])
            ->where([
                'StaffJob.job_id' => $id,
                'StaffJob.status' => 'Confirmed',
            ])
            ->orderByAsc('StaffJob.role')
            ->all();

        $this->set(compact('job', 'staffJob', 'isDriver', 'jobReports', 'assignedStaff'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $job = $this->Jobs->newEmptyEntity();
        if ($this->request->is('post')) {
            $job = $this->Jobs->patchEntity($job, $this->request->getData());
            if ($this->Jobs->save($job)) {
                $this->Flash->success(__('The job has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The job could not be saved. Please, try again.'));
        }
        $jobTypes = $this->Jobs->JobTypes->find('list', limit: 200)->all();
        $customers = $this->Jobs->Customers->find('list', limit: 200)->all();
        $this->set(compact('job', 'jobTypes', 'customers'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Job id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $job = $this->Jobs->get($id, contain: []);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $job = $this->Jobs->patchEntity($job, $this->request->getData());
            if ($this->Jobs->save($job)) {
                $this->Flash->success(__('The job has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The job could not be saved. Please, try again.'));
        }
        $jobTypes = $this->Jobs->JobTypes->find('list', limit: 200)->all();
        $customers = $this->Jobs->Customers->find('list', limit: 200)->all();
        $this->set(compact('job', 'jobTypes', 'customers'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Job id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $job = $this->Jobs->get($id);
        if ($this->Jobs->delete($job)) {
            $this->Flash->success(__('The job has been deleted.'));
        } else {
            $this->Flash->error(__('The job could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
    public function available()
    {
        $identity = $this->request->getAttribute('identity');

        if (!$identity || (int)$identity->get('user_type') !== 2) {
            $this->Flash->error(__('Only staff can view available jobs.'));
            return $this->redirect(['controller' => 'Pages', 'action' => 'display', 'home']);
        }

        $staffTable = $this->fetchTable('Staff');
        $staffJobsTable = $this->fetchTable('StaffJob');
        $availabilityTable = $this->fetchTable('Availability');

        $currentStaff = $staffTable->find()
            ->where(['email' => $identity->get('email')])
            ->first();

        if (!$currentStaff) {
            $this->Flash->error(__('Staff profile not found.'));
            return $this->redirect(['controller' => 'Pages', 'action' => 'display', 'home']);
        }

        $isDriver = (int)$currentStaff->isDriver === 1;

        $availabilityList = $availabilityTable->find()
            ->where(['staff_id' => $currentStaff->staff_id])
            ->all();

        $hiddenJobIds = $staffJobsTable->find()
            ->select(['job_id'])
            ->where(['staff_id' => $currentStaff->staff_id])
            ->all()
            ->extract('job_id')
            ->toList();

        $query = $this->Jobs->find()
            ->where(['Jobs.status' => 'Processing'])
            ->orderBy(['Jobs.job_date' => 'ASC']);

        if (!empty($hiddenJobIds)) {
            $query->where(['Jobs.job_id NOT IN' => $hiddenJobIds]);
        }

        $allJobs = $query->all();
        $visibleJobs = [];

        foreach ($allJobs as $job) {
            $jobDateTime = strtotime(
                $job->job_date->format('Y-m-d') . ' ' .
                $job->job_time->format('H:i:s')
            );

            $fitsAvailability = false;

            foreach ($availabilityList as $availability) {
                $start = strtotime($availability->start_datetime->format('Y-m-d H:i:s'));
                $end = strtotime($availability->end_datetime->format('Y-m-d H:i:s'));

                if ($jobDateTime >= $start && $jobDateTime <= $end) {
                    $fitsAvailability = true;
                    break;
                }
            }

            if (!$fitsAvailability) {
                continue;
            }

            $driverCount = $staffJobsTable->find()
                ->where([
                    'job_id' => $job->job_id,
                    'status' => 'Confirmed',
                    'role' => 'Driver',
                ])
                ->count();

            $porterCount = $staffJobsTable->find()
                ->where([
                    'job_id' => $job->job_id,
                    'status' => 'Confirmed',
                    'role' => 'Porter',
                ])
                ->count();

            $job->driver_count = $driverCount;
            $job->porter_count = $porterCount;

            if ($isDriver) {
                if (
                    $driverCount < (int)$job->driver_required ||
                    $porterCount < (int)$job->porter_required
                ) {
                    $visibleJobs[] = $job;
                }
            } else {
                if ($porterCount < (int)$job->porter_required) {
                    $visibleJobs[] = $job;
                }
            }
        }

        $jobs = new \Cake\Collection\Collection($visibleJobs);
        $this->set(compact('jobs'));
    }

    public function takeJob($jobId = null, $role = null)
    {
        $identity = $this->request->getAttribute('identity');

        if (!$identity || (int)$identity->get('user_type') !== 2) {
            $this->Flash->error(__('Only staff can take jobs.'));
            return $this->redirect(['controller' => 'Pages', 'action' => 'display', 'home']);
        }

        $this->request->allowMethod(['post']);

        if (!in_array($role, ['Driver', 'Porter'], true)) {
            $this->Flash->error(__('Invalid role selected.'));
            return $this->redirect(['action' => 'available']);
        }

        $staffTable = $this->fetchTable('Staff');
        $staffJobsTable = $this->fetchTable('StaffJob');

        $currentStaff = $staffTable->find()
            ->where(['email' => $identity->get('email')])
            ->first();

        if (!$currentStaff) {
            $this->Flash->error(__('Staff profile not found.'));
            return $this->redirect(['action' => 'available']);
        }

        $isDriver = (int)$currentStaff->isDriver === 1;

        if (!$isDriver && $role === 'Driver') {
            $this->Flash->error(__('Porters cannot accept driver roles.'));
            return $this->redirect(['action' => 'available']);
        }

        $job = $this->Jobs->get($jobId);

        if ($job->status !== 'Processing') {
            $this->Flash->error(__('This job is not available.'));
            return $this->redirect(['action' => 'available']);
        }

        $existing = $staffJobsTable->find()
            ->where([
                'job_id' => $jobId,
                'staff_id' => $currentStaff->staff_id,
            ])
            ->first();

        if ($existing) {
            $this->Flash->error(__('You have already responded to this job.'));
            return $this->redirect(['action' => 'available']);
        }

        $driverCount = $staffJobsTable->find()
            ->where([
                'job_id' => $jobId,
                'status' => 'Confirmed',
                'role' => 'Driver',
            ])
            ->count();

        $porterCount = $staffJobsTable->find()
            ->where([
                'job_id' => $jobId,
                'status' => 'Confirmed',
                'role' => 'Porter',
            ])
            ->count();

        if ($role === 'Driver' && $driverCount >= (int)$job->driver_required) {
            $this->Flash->error(__('Driver positions are full.'));
            return $this->redirect(['action' => 'available']);
        }

        if ($role === 'Porter' && $porterCount >= (int)$job->porter_required) {
            $this->Flash->error(__('Porter positions are full.'));
            return $this->redirect(['action' => 'available']);
        }

        $staffJob = $staffJobsTable->newEntity([
            'job_id' => $jobId,
            'staff_id' => $currentStaff->staff_id,
            'status' => 'Confirmed',
            'role' => $role,
        ]);

        if ($staffJobsTable->save($staffJob)) {
            if ($role === 'Driver') {
                $driverCount++;
            } else {
                $porterCount++;
            }

            if (
                $driverCount >= (int)$job->driver_required &&
                $porterCount >= (int)$job->porter_required
            ) {
                $job->status = 'Ready';
                $this->Jobs->save($job);
            }

            $this->Flash->success(__('You have taken this job as {0}.', $role));
            return $this->redirect(['action' => 'available']);
        }

        $this->Flash->error(__('The job could not be taken.'));
        return $this->redirect(['action' => 'available']);
    }

    public function myJobs()
    {
        $identity = $this->request->getAttribute('identity');

        if (!$identity || (int)$identity->get('user_type') !== 2) {
            $this->Flash->error(__('Only staff can view their jobs.'));
            return $this->redirect(['controller' => 'Pages', 'action' => 'display', 'home']);
        }

        $staffTable = $this->fetchTable('Staff');
        $staffJobsTable = $this->fetchTable('StaffJob');

        $currentStaff = $staffTable->find()
            ->where(['email' => $identity->get('email')])
            ->first();

        if (!$currentStaff) {
            $this->Flash->error(__('Staff profile not found.'));
            return $this->redirect(['controller' => 'Pages', 'action' => 'display', 'home']);
        }

        $staffJobs = $staffJobsTable->find()
            ->contain(['Jobs'])
            ->where([
                'StaffJob.staff_id' => $currentStaff->staff_id,
                'StaffJob.status' => 'Confirmed',
            ])
            ->all();

        foreach ($staffJobs as $staffJob) {
            $staffJob->driver_count = $staffJobsTable->find()
                ->where([
                    'job_id' => $staffJob->job_id,
                    'status' => 'Confirmed',
                    'role' => 'Driver',
                ])
                ->count();

            $staffJob->porter_count = $staffJobsTable->find()
                ->where([
                    'job_id' => $staffJob->job_id,
                    'status' => 'Confirmed',
                    'role' => 'Porter',
                ])
                ->count();
        }

        $this->set(compact('staffJobs'));
    }

    public function notInterested($jobId = null)
    {
        $identity = $this->request->getAttribute('identity');

        if (!$identity || (int)$identity->get('user_type') !== 2) {
            $this->Flash->error(__('Only staff can reject jobs.'));
            return $this->redirect(['controller' => 'Pages', 'action' => 'display', 'home']);
        }

        $this->request->allowMethod(['post']);

        $staffTable = $this->fetchTable('Staff');
        $staffJobsTable = $this->fetchTable('StaffJob');

        $currentStaff = $staffTable->find()
            ->where(['email' => $identity->get('email')])
            ->first();

        if (!$currentStaff) {
            $this->Flash->error(__('Staff profile not found.'));
            return $this->redirect(['action' => 'available']);
        }

        $existing = $staffJobsTable->find()
            ->where([
                'job_id' => $jobId,
                'staff_id' => $currentStaff->staff_id,
            ])
            ->first();

        if ($existing) {
            $this->Flash->error(__('You have already responded to this job.'));
            return $this->redirect(['action' => 'available']);
        }

        $staffJob = $staffJobsTable->newEntity([
            'job_id' => $jobId,
            'staff_id' => $currentStaff->staff_id,
            'status' => 'Rejected',
        ]);

        if ($staffJobsTable->save($staffJob)) {
            $this->Flash->success(__('Job is rejected.'));
        } else {
            $this->Flash->error(__('Could not hide this job.'));
        }

        return $this->redirect(['action' => 'available']);
    }

    public function allocate($jobId = null)
    {
        $identity = $this->request->getAttribute('identity');

        if (!$identity || (int)$identity->get('user_type') !== 1) {
            $this->Flash->error(__('Only admins can allocate jobs.'));
            return $this->redirect(['controller' => 'Pages', 'action' => 'display', 'home']);
        }

        if (!$jobId) {
            $this->Flash->error(__('Missing job ID.'));
            return $this->redirect(['action' => 'index']);
        }

        $job = $this->Jobs->get($jobId);

        $trucksTable = $this->fetchTable('Trucks');

        $truckList = $trucksTable->find('list', [
            'keyField' => 'truck_id',
            'valueField' => 'rego',
        ])
            ->where(['status' => 'available'])
            ->toArray();

        if ($this->request->is(['post', 'put', 'patch'])) {
            $data = $this->request->getData();
            $truckIds = $data['truck_ids'] ?? [];

            if (empty($truckIds)) {
                $this->Flash->error(__('Please select at least one truck.'));
                $this->set(compact('job', 'truckList'));
                return;
            }

            if (count($truckIds) !== count(array_unique($truckIds))) {
                $this->Flash->error(__('Please select different trucks.'));
                $this->set(compact('job', 'truckList'));
                return;
            }

            $job->driver_required = (int)$data['driver_required'];
            $job->porter_required = (int)$data['porter_required'];
            $job->staff_required = (int)$data['driver_required'] + (int)$data['porter_required'];
            $job->truck_required = (int)$data['truck_required'];
            $job->status = 'Processing';
            $job->allocated_at = date('Y-m-d H:i:s');

            if ($this->Jobs->save($job)) {
                $jobTrucksTable = $this->fetchTable('JobTrucks');

                $jobTrucksTable->deleteAll(['job_id' => $job->job_id]);

                foreach ($truckIds as $truckId) {
                    $jobTruck = $jobTrucksTable->newEntity([
                        'job_id' => $job->job_id,
                        'truck_id' => $truckId,
                    ]);

                    $jobTrucksTable->save($jobTruck);
                }

                $this->Flash->success(__('Job allocated successfully.'));
                return $this->redirect(['action' => 'index']);
            }

            $this->Flash->error(__('Allocation failed.'));
        }

        $this->set(compact('job', 'truckList'));
    }

    public function report($jobId = null)
    {
        $identity = $this->request->getAttribute('identity');

        if (!$identity || (int)$identity->get('user_type') !== 2) {
            $this->Flash->error(__('Only staff can submit job reports.'));
            return $this->redirect(['controller' => 'Pages', 'action' => 'display', 'home']);
        }

        if (!$jobId) {
            $this->Flash->error(__('Missing job ID.'));
            return $this->redirect(['action' => 'myJobs']);
        }

        $staffTable = $this->fetchTable('Staff');
        $staffJobsTable = $this->fetchTable('StaffJob');

        $currentStaff = $staffTable->find()
            ->where(['email' => $identity->get('email')])
            ->first();

        if (!$currentStaff) {
            $this->Flash->error(__('Staff profile not found.'));
            return $this->redirect(['action' => 'myJobs']);
        }

        $job = $this->Jobs->get($jobId, contain: ['JobTypes', 'Customers']);

        if ($job->status !== 'Ready') {
            $this->Flash->error(__('You can only report on jobs that are ready.'));
            return $this->redirect(['action' => 'view', $jobId]);
        }

        $staffJob = $staffJobsTable->find()
            ->where([
                'StaffJob.job_id' => $jobId,
                'StaffJob.staff_id' => $currentStaff->staff_id,
                'StaffJob.status' => 'Confirmed',
            ])
            ->first();

        if (!$staffJob) {
            $this->Flash->error(__('You are not authorized to report on this job.'));
            return $this->redirect(['action' => 'myJobs']);
        }

        // Prevent the same staff member from submitting twice.
        if (!empty($staffJob->report_outcome)) {
            $this->Flash->error(__('You have already submitted a report for this job.'));
            return $this->redirect(['action' => 'view', $jobId]);
        }

        if ($this->request->is(['post', 'put', 'patch'])) {
            $data = $this->request->getData();

            $reportOutcome = $data['report_outcome'] ?? null;
            $reportNotes = trim((string)($data['report_notes'] ?? ''));

            if (!in_array($reportOutcome, ['Completed', 'Incomplete'], true)) {
                $this->Flash->error(__('Please select whether the job was completed or incomplete.'));
                $this->set(compact('job', 'staffJob'));
                return;
            }

            $staffJob->report_outcome = $reportOutcome;
            $staffJob->report_notes = $reportNotes;
            $staffJob->report_submitted_at = date('Y-m-d H:i:s');

            if ($staffJobsTable->save($staffJob)) {
                $this->Flash->success(__('Your job report has been submitted.'));
                return $this->redirect(['action' => 'view', $jobId]);
            }

            $this->Flash->error(__('The report could not be saved. Please try again.'));
        }

        $this->set(compact('job', 'staffJob'));
    }

    public function markCompleted($jobId = null)
    {
        $identity = $this->request->getAttribute('identity');

        if (!$identity || (int)$identity->get('user_type') !== 1) {
            $this->Flash->error(__('Only admins can complete jobs.'));
            return $this->redirect(['controller' => 'Pages', 'action' => 'display', 'home']);
        }

        $this->request->allowMethod(['post']);

        if (!$jobId) {
            $this->Flash->error(__('Missing job ID.'));
            return $this->redirect(['action' => 'index']);
        }

        $job = $this->Jobs->get($jobId);

        if ($job->status !== 'Ready') {
            $this->Flash->error(__('Only ready jobs can be marked as completed.'));
            return $this->redirect(['action' => 'view', $jobId]);
        }

        $staffJobsTable = $this->fetchTable('StaffJob');

        $hasReport = $staffJobsTable->find()
            ->where([
                'StaffJob.job_id' => $jobId,
                'StaffJob.status' => 'Confirmed',
                'StaffJob.report_outcome IS NOT' => null,
            ])
            ->count();

        if ($hasReport === 0) {
            $this->Flash->error(__('A staff report must be submitted before the job can be completed.'));
            return $this->redirect(['action' => 'view', $jobId]);
        }

        $job->status = 'Completed';

        if ($this->Jobs->save($job)) {
            $this->Flash->success(__('The job has been marked as completed.'));
        } else {
            $this->Flash->error(__('The job could not be marked as completed.'));
        }

        return $this->redirect(['action' => 'view', $jobId]);
    }

    private function checkExpiredJobs(): void
    {
        $staffJobsTable = $this->fetchTable('StaffJob');

        $expiredJobs = $this->Jobs->find()
            ->contain(['Customers'])
            ->where([
                'status' => 'Processing',
                'allocated_at <=' => date('Y-m-d H:i:s', strtotime('-7 days')),
            ])
            ->all();

        foreach ($expiredJobs as $job) {

            $driverCount = $staffJobsTable->find()
                ->where([
                    'job_id' => $job->job_id,
                    'status' => 'Confirmed',
                    'role' => 'Driver',
                ])
                ->count();

            $porterCount = $staffJobsTable->find()
                ->where([
                    'job_id' => $job->job_id,
                    'status' => 'Confirmed',
                    'role' => 'Porter',
                ])
                ->count();

            if (
                $driverCount < (int)$job->driver_required ||
                $porterCount < (int)$job->porter_required
            ) {
                $job->status = 'Cancelled';
                $job->cancelled_at = date('Y-m-d H:i:s');

                if ($this->Jobs->save($job)) {

                    $customer = $job->customer ?? null;

                    $customerName = trim(
                        ($customer->first_name ?? '') . ' ' .
                        ($customer->last_name ?? '')
                    );

                    if ($customerName === '') {
                        $customerName = 'N/A';
                    }

                    $customerEmail = $customer->email ?? 'N/A';
                    $customerPhone = $customer->phone ?? 'N/A';

                    $emailBody =
                        "Job #{$job->job_id} cancelled.\n\n" .
                        "Reason:\n" .
                        "Not enough staff accepted within 7 days.\n\n" .

                        "Customer Information:\n" .
                        "Name: {$customerName}\n" .
                        "Email: {$customerEmail}\n" .
                        "Phone: {$customerPhone}\n\n" .

                        "Job Details:\n" .
                        "Pickup: {$job->pickup_address}\n" .
                        "Dropoff: {$job->dropoff_address}\n" .
                        "Date: {$job->job_date}\n" .
                        "Time: {$job->job_time}\n\n" .

                        "Staff Requirement:\n" .
                        "Drivers: {$driverCount} / {$job->driver_required}\n" .
                        "Porters: {$porterCount} / {$job->porter_required}\n\n" .

                        "Please contact the customer.";

                    $mailer = new \Cake\Mailer\Mailer('default');

                    $result = $mailer
                        ->setTo('admin@test.com')
                        ->setSubject('Job Auto Cancelled')
                        ->deliver($emailBody);

                }
            }
        }
    }
}
