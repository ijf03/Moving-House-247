<?php
declare(strict_types=1);

namespace App\Controller;

class BookingsController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $identity = $this->request->getAttribute('identity');

        if (!$identity || $identity->get('user_type') != 1) {
            $this->Flash->error(__('You are not authorized to access this page.'));
            return $this->redirect(['controller' => 'Pages', 'action' => 'display', 'home']);
        }

        $query = $this->Bookings->find()->contain(['Customers', 'JobTypes']);

        $status = $this->request->getQuery('status');
        $jobTypeId = $this->request->getQuery('job_type_id');
        $sort = $this->request->getQuery('sort');
        $direction = $this->request->getQuery('direction');

        if (!empty($status)) {
            $query->where(['Bookings.status' => $status]);
        }

        if (!empty($jobTypeId)) {
            $query->where(['Bookings.job_type_id' => $jobTypeId]);
        }

        if (!empty($sort) && in_array($sort, ['job_date'])) {
            $direction = strtolower((string)$direction) === 'desc' ? 'DESC' : 'ASC';
            $query->order(["Bookings.$sort" => $direction]);
        }

        $bookings = $this->paginate($query);
        $this->set(compact('bookings', 'status', 'jobTypeId', 'sort', 'direction'));
    }

    /**
     * View method
     *
     * @param string|null $id Booking id.
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function view($id = null)
    {
        $booking = $this->Bookings->get($id, contain: ['Customers', 'JobTypes']);
        $this->set(compact('booking'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $booking = $this->Bookings->newEmptyEntity();

        if ($this->request->is('post')) {
            $data = $this->request->getData();

            $identity = $this->request->getAttribute('identity');

            if (!$identity) {
                $this->Flash->error(__('You must be logged in to make a booking.'));
                return $this->redirect(['controller' => 'Users', 'action' => 'login']);
            }

            $usersTable = $this->fetchTable('Users');
            $customersTable = $this->fetchTable('Customers');

            $user = $usersTable->get($identity->get('user_id'));

            $customer = $customersTable->find()
                ->where([
                    'email' => $user->email,
                ])
                ->first();

            if (!$customer) {
                $customer = $customersTable->newEntity([
                    'first_name' => $user->first_name,
                    'last_name' => $user->last_name,
                    'email' => $user->email,
                    'phone' => $user->phone,
                ]);


                if (!$customersTable->save($customer)) {
                    $this->Flash->error(__('The customer profile could not be created.'));
                    $this->set(compact('booking'));
                    return;
                }

                $customer = $customersTable->find()
                    ->where([
                        'email' => $user->email,
                    ])
                    ->first();
            }

            $bookingData = [
                'customer_id' => $customer->customer_id,
                'job_type_id' => $data['job_type_id'],
                'pickup_address' => $data['pickup_address'],
                'dropoff_address' => $data['dropoff_address'],
                'job_date' => $data['job_date'],
                'job_time' => $data['job_time'],
                'message' => $data['message']?? null,
                'status' => 'Pending',
            ];

            $booking = $this->Bookings->patchEntity($booking, $bookingData);

            if ($this->Bookings->save($booking)) {
                $this->Flash->success(__('The booking has been submitted.'));
                return $this->redirect(['controller' => 'Pages', 'action' => 'display', 'home']);
            }

            $this->Flash->error(__('The booking could not be saved.'));
        }

        $customers = $this->Bookings->Customers->find('list', [
            'keyField' => 'customer_id',
            'valueField' => 'first_name',
        ])->toArray();

        $jobTypes = $this->Bookings->JobTypes->find('list', [
            'keyField' => 'job_type_id',
            'valueField' => 'job_type_name',
        ])->toArray();

        $this->set(compact('booking', 'customers','jobTypes'));
    }

    /**
     * Accept method
     *
     * @param string|null $id Booking id.
     * @return \Cake\Http\Response|null Redirects to index.
     */
    public function accept($id = null)
    {
        $identity = $this->request->getAttribute('identity');

        if (!$identity || $identity->get('user_type') != 1) {
            $this->Flash->error(__('You are not authorized to perform this action.'));
            return $this->redirect(['controller' => 'Pages', 'action' => 'display', 'home']);
        }

        $booking = $this->Bookings->get($id);

        if ($booking->status !== 'Pending') {
            $this->Flash->error(__('Only pending bookings can be accepted.'));
            return $this->redirect(['action' => 'index']);
        }

        $jobsTable = $this->fetchTable('Jobs');

        $job = $jobsTable->newEntity([
            'job_type_id' => $booking->job_type_id,
            'description' => 'Booking accepted from request #' . $booking->booking_id,
            'pickup_address' => $booking->pickup_address,
            'dropoff_address' => $booking->dropoff_address,
            'job_date' => $booking->job_date->format('Y-m-d'),
            'job_time' => $booking->job_time->format('H:i'),
            'customer_id' => $booking->customer_id,
        ]);

        if ($jobsTable->save($job)) {
            $booking->status = 'Processing';
            $booking->accepted_notified = 0;
            $this->Bookings->save($booking);

            $this->Flash->success(__('The booking has been accepted and converted to a job.'));
            return $this->redirect(['action' => 'index']);
        }

        $this->Flash->error(__('The booking could not be converted to a job.'));
        return $this->redirect(['action' => 'index']);
    }

    /**
     * Reject method
     *
     * @param string|null $id Booking id.
     * @return \Cake\Http\Response|null Redirects to index.
     */
    public function reject($id = null)
    {
        $identity = $this->request->getAttribute('identity');

        if (!$identity || $identity->get('user_type') != 1) {
            $this->Flash->error(__('You are not authorized to perform this action.'));
            return $this->redirect(['controller' => 'Pages', 'action' => 'display', 'home']);
        }

        $booking = $this->Bookings->get($id);

        if ($booking->status !== 'Pending') {
            $this->Flash->error(__('Only pending bookings can be rejected.'));
            return $this->redirect(['action' => 'index']);
        }

        $booking->status = 'Rejected';

        if ($this->Bookings->save($booking)) {
            $this->Flash->success(__('The booking has been rejected.'));
        } else {
            $this->Flash->error(__('The booking could not be rejected.'));
        }

        return $this->redirect(['action' => 'index']);
    }

    public function myBookings()
    {
        $identity = $this->request->getAttribute('identity');

        if (!$identity) {
            $this->Flash->error(__('You must be logged in to view your bookings.'));
            return $this->redirect(['controller' => 'Users', 'action' => 'login']);
        }

        if ((int)$identity->get('user_type') !== 3) {
            $this->Flash->error(__('Only customers can access this page.'));
            return $this->redirect(['controller' => 'Pages', 'action' => 'display', 'home']);
        }

        $customersTable = $this->fetchTable('Customers');

        $customer = $customersTable->find()
            ->where(['email' => $identity-> get('email')])
            ->first();

        if (!$customer) {
            $this->Flash->error(__('No customer profile was found.'));
            return $this->redirect(['controller' => 'Pages', 'action' => 'display', 'home']);
        }

        $query = $this->Bookings->find()
            ->contain(['JobTypes'])
            ->where([
                'Bookings.customer_id' => $customer->customer_id,
                'Bookings.status IN' => ['Processing', 'Done'],
            ])
            ->orderBy(['Bookings.job_date' => 'ASC']);

        $bookings = $this->paginate($query);

        $popupBooking = $this->Bookings->find()
            ->where([
                'customer_id' => $customer->customer_id,
                'status' => 'Processing',
                'accepted_notified' => 0,
            ])
            ->first();

        if ($popupBooking) {
            $popupBooking->accepted_notified = 1;
            $this->Bookings->save($popupBooking);
        }

        $this->set(compact('bookings', 'popupBooking'));
    }
}
