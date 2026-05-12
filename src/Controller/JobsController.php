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
            $this->Flash->error(__('You must be logged in to view jobs.'));
            return $this->redirect(['controller' => 'Users', 'action' => 'login']);
        }

        $role = (int)$identity->get('user_type');

        $job = $this->Jobs->get($id, contain: [
            'JobTypes',
            'Customers',
            'JobTrucks.Trucks',
            'StaffJob',
        ]);

        $staffJobsTable = $this->fetchTable('StaffJob');

        $staffJob = null;

        if ($role === 2) {
            $staffJob = $staffJobsTable->find()
                ->where([
                    'job_id' => $id,
                    'staff_id' => $identity->get('user_id'),
                    'status' => 'Confirmed',
                ])
                ->first();

            if (!$staffJob) {
                $this->Flash->error(__('You are not authorized to view this job.'));
                return $this->redirect(['action' => 'myJobs']);
            }
        }

        $jobReports = $staffJobsTable->find()
            ->where([
                'job_id' => $id,
                'status' => 'Confirmed',
                'report_outcome IS NOT' => null,
            ])
            ->all();

        $this->set(compact('job', 'staffJob', 'jobReports'));
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

        $staffJobsTable = $this->fetchTable('StaffJob');

        $hiddenJobIds = $staffJobsTable->find()
            ->select(['job_id'])
            ->where(['staff_id' => $identity->get('user_id')])
            ->all()
            ->extract('job_id')
            ->toList();

        $query = $this->Jobs->find()
            ->where(['Jobs.status' => 'Processing'])
            ->orderBy(['Jobs.job_date' => 'ASC']);

        if (!empty($hiddenJobIds)) {
            $query->where(['Jobs.job_id NOT IN' => $hiddenJobIds]);
        }

        $jobs = $query->all();

        $staffJobsTable = $this->fetchTable('StaffJob');

        foreach ($jobs as $job) {
            $job->confirmed_count = $staffJobsTable->find()
                ->where([
                    'job_id' => $job->job_id,
                    'status' => 'Confirmed',
                ])
                ->count();
        }

        $this->set(compact('jobs'));
    }

    public function takeJob($jobId = null)
    {
        $identity = $this->request->getAttribute('identity');

        if (!$identity || (int)$identity->get('user_type') !== 2) {
            $this->Flash->error(__('Only staff can take jobs.'));
            return $this->redirect(['controller' => 'Pages', 'action' => 'display', 'home']);
        }

        $this->request->allowMethod(['post']);

        $staffJobsTable = $this->fetchTable('StaffJob');
        $job = $this->Jobs->get($jobId);

        if ($job->status !== 'Processing') {
            $this->Flash->error(__('This job is not available.'));
            return $this->redirect(['action' => 'available']);
        }

        $existing = $staffJobsTable->find()
            ->where([
                'job_id' => $jobId,
                'staff_id' => $identity->get('user_id'),
            ])
            ->first();

        if ($existing) {
            $this->Flash->error(__('You have already taken this job.'));
            return $this->redirect(['action' => 'available']);
        }

        $staffJob = $staffJobsTable->newEntity([
            'job_id' => $jobId,
            'staff_id' => $identity->get('user_id'),
            'status' => 'Confirmed',
        ]);

        if ($staffJobsTable->save($staffJob)) {
            $confirmedStaffCount = $staffJobsTable->find()
                ->where([
                    'job_id' => $jobId,
                    'status' => 'Confirmed',
                ])
                ->count();

            if ($confirmedStaffCount >= $job->staff_required) {
                $job->status = 'Ready';
                $this->Jobs->save($job);
            }

            $this->Flash->success(__('You have taken this job.'));
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

        $staffJobsTable = $this->fetchTable('StaffJob');

        $staffJobs = $staffJobsTable->find()
            ->contain(['Jobs'])
            ->where([
                'StaffJob.staff_id' => $identity->get('user_id'),
                'StaffJob.status' => 'Confirmed',
            ])
            ->all();
        foreach ($staffJobs as $staffJob) {
            $staffJob->confirmed_count = $staffJobsTable->find()
                ->where([
                    'job_id' => $staffJob->job_id,
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

        $staffJobsTable = $this->fetchTable('StaffJob');

        $existing = $staffJobsTable->find()
            ->where([
                'job_id' => $jobId,
                'staff_id' => $identity->get('user_id'),
            ])
            ->first();

        if ($existing) {
            $this->Flash->error(__('You have already responded to this job.'));
            return $this->redirect(['action' => 'available']);
        }

        $staffJob = $staffJobsTable->newEntity([
            'job_id' => $jobId,
            'staff_id' => $identity->get('user_id'),
            'status' => 'Rejected',
        ]);

        if ($staffJobsTable->save($staffJob)) {
            $this->Flash->success(__('Job hidden from your list.'));
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

            $job->staff_required = $data['staff_required'];
            $job->truck_required = $data['truck_required'];
            $job->status = 'Processing';
            $job->allocated_at = date('Y-m-d H:i:s');

            if ($this->Jobs->save($job)) {
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

        $job = $this->Jobs->get($jobId, contain: ['JobTypes', 'Customers']);

        if ($job->status !== 'Ready') {
            $this->Flash->error(__('You can only report on jobs that are ready.'));
            return $this->redirect(['action' => 'view', $jobId]);
        }

        $staffJobsTable = $this->fetchTable('StaffJob');

        $staffJob = $staffJobsTable->find()
            ->where([
                'job_id' => $jobId,
                'staff_id' => $identity->get('user_id'),
                'status' => 'Confirmed',
            ])
            ->first();

        if (!$staffJob) {
            $this->Flash->error(__('You are not authorized to report on this job.'));
            return $this->redirect(['action' => 'myJobs']);
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
                'job_id' => $jobId,
                'status' => 'Confirmed',
                'report_outcome IS NOT' => null,
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
}
