<?php
declare(strict_types=1);

namespace App\Controller;

use Cake\Core\Configure;

class BookingsController extends AppController
{
    public function index()
    {
        $identity = $this->request->getAttribute('identity');

        if (!$identity || $identity->get('user_type') != 1) {
            $this->Flash->error(__('You are not authorized to access this page.'));

            return $this->redirect(['controller' => 'Pages', 'action' => 'display', 'home']);
        }

        $query = $this->Bookings->find()->contain(['Customers', 'JobTypes']);

        $search = trim((string)$this->request->getQuery('search'));
        $status = $this->request->getQuery('status');
        $jobTypeId = $this->request->getQuery('job_type_id');

        $job_types = $this->Bookings->JobTypes->find('list', [
            'keyField' => 'job_type_id',
            'valueField' => 'job_type_name',
        ])->all();

        if ($search !== '') {
            $like = '%' . $search . '%';
            $query->where(function ($exp) use ($like) {
                return $exp->or([
                    'Bookings.pickup_address LIKE' => $like,
                    'Bookings.dropoff_address LIKE' => $like,
                    'Bookings.status LIKE' => $like,
                    'Customers.first_name LIKE' => $like,
                    'Customers.last_name LIKE' => $like,
                    'Customers.email LIKE' => $like,
                    'Customers.phone LIKE' => $like,
                    'JobTypes.job_type_name LIKE' => $like,
                ]);
            });
        }

        if (!empty($status)) {
            $query->where(['Bookings.status' => $status]);
        }

        if (!empty($jobTypeId)) {
            $query->where(['Bookings.job_type_id' => $jobTypeId]);
        }

        $bookings = $this->paginate($query);
        $this->set(compact('bookings', 'job_types', 'search', 'status', 'jobTypeId'));
    }

    public function view($id = null)
    {
        $identity = $this->request->getAttribute('identity');
        $isAdmin = $this->isAdmin();

        if (!$identity) {
            $this->Flash->error(__('You must be logged in.'));

            return $this->redirect(['controller' => 'Users', 'action' => 'login']);
        }

        $booking = $this->Bookings->get($id, contain: ['Customers', 'JobTypes']);

        if (!$this->isAdmin()) {
            $customersTable = $this->fetchTable('Customers');

            $customer = $customersTable->find()
                ->where(['email' => $identity->get('email')])
                ->first();

            if (!$customer || $booking->customer_id !== $customer->customer_id) {
                $this->Flash->error(__('You are not authorized to view this booking.'));

                return $this->redirect(['action' => 'myBookings']);
            }
        }

        $relatedJob = null;

        if ($this->isAdmin() && $booking->status === 'Processing') {
            $jobsTable = $this->fetchTable('Jobs');

            $relatedJob = $jobsTable->find()
                ->where([
                    'customer_id' => $booking->customer_id,
                    'job_type_id' => $booking->job_type_id,
                    'description' => 'Booking accepted from request #' . $booking->booking_id,
                ])
                ->first();
        }

        $this->set(compact('booking', 'relatedJob', 'isAdmin'));
    }

    public function chooseType()
    {
        $bookingTypes = $this->bookingTypeConfig();
        $this->set(compact('bookingTypes'));
    }

    public function add()
    {
        $booking = $this->Bookings->newEmptyEntity();
        $bookingTypes = $this->bookingTypeConfig();

        $selectedJobTypeId = (int)($this->request->getQuery('job_type_id') ?: $this->request->getData('job_type_id'));

        if (!isset($bookingTypes[$selectedJobTypeId])) {
            $this->Flash->error(__('Please select a booking type first.'));

            return $this->redirect(['action' => 'chooseType']);
        }

        $selectedJobType = $bookingTypes[$selectedJobTypeId];
        $requiresDropoff = (bool)$selectedJobType['requires_dropoff'];

        if ($this->request->is('post')) {
            $identity = $this->request->getAttribute('identity');

            if (!$identity) {
                $this->Flash->error(__('You must be logged in to make a booking.'));

                return $this->redirect(['controller' => 'Users', 'action' => 'login']);
            }

            $data = $this->request->getData();

            $usersTable = $this->fetchTable('Users');
            $customersTable = $this->fetchTable('Customers');

            $user = $usersTable->get($identity->get('user_id'));

            $customer = $customersTable->find()
                ->where(['email' => $user->email])
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
                    $geoapifyApiKey = Configure::read('Geoapify.apiKey');
                    $this->set(compact('booking', 'bookingTypes', 'selectedJobTypeId', 'selectedJobType', 'requiresDropoff', 'geoapifyApiKey'));

                    return;
                }
            }

            $errors = [];

            if (trim((string)($data['pickup_street_address'] ?? '')) === '') {
                $errors[] = __('Pickup street address is required.');
            }
            if (trim((string)($data['pickup_suburb'] ?? '')) === '') {
                $errors[] = __('Pickup suburb is required.');
            }
            if (trim((string)($data['pickup_postcode'] ?? '')) === '') {
                $errors[] = __('Pickup postcode is required.');
            }
            if (empty($data['job_date'])) {
                $errors[] = __('Job date is required.');
            }
            if (empty($data['job_time'])) {
                $errors[] = __('Job time is required.');
            }

            if ($requiresDropoff) {
                if (trim((string)($data['dropoff_street_address'] ?? '')) === '') {
                    $errors[] = __('Dropoff street address is required.');
                }
                if (trim((string)($data['dropoff_suburb'] ?? '')) === '') {
                    $errors[] = __('Dropoff suburb is required.');
                }
                if (trim((string)($data['dropoff_postcode'] ?? '')) === '') {
                    $errors[] = __('Dropoff postcode is required.');
                }
            }

            if (!empty($errors)) {
                foreach ($errors as $error) {
                    $this->Flash->error($error);
                }

                $geoapifyApiKey = Configure::read('Geoapify.apiKey');
                $this->set(compact('booking', 'bookingTypes', 'selectedJobTypeId', 'selectedJobType', 'requiresDropoff', 'geoapifyApiKey'));

                return;
            }

            $pickupAddress = $this->buildAddress(
                (string)($data['pickup_street_address'] ?? ''),
                (string)($data['pickup_suburb'] ?? ''),
                (string)($data['pickup_postcode'] ?? ''),
            );

            $dropoffAddress = null;
            if ($requiresDropoff) {
                $dropoffAddress = $this->buildAddress(
                    (string)($data['dropoff_street_address'] ?? ''),
                    (string)($data['dropoff_suburb'] ?? ''),
                    (string)($data['dropoff_postcode'] ?? ''),
                );
            }

            $bookingData = [
                'customer_id' => $customer->customer_id,
                'job_type_id' => $selectedJobTypeId,
                'pickup_address' => $pickupAddress,
                'dropoff_address' => $dropoffAddress,
                'job_date' => $data['job_date'],
                'job_time' => $data['job_time'],
                'message' => $data['message'] ?? null,
                'status' => 'Pending',
            ];

            $booking = $this->Bookings->patchEntity($booking, $bookingData);

            if ($this->Bookings->save($booking)) {
                $this->Flash->success(__('The booking has been submitted.'));

                return $this->redirect(['controller' => 'Pages', 'action' => 'display', 'home']);
            }

            $this->Flash->error(__('The booking could not be saved. Please try again.'));
        }

        $geoapifyApiKey = Configure::read('Geoapify.apiKey');

        $this->set(compact(
            'booking',
            'bookingTypes',
            'selectedJobTypeId',
            'selectedJobType',
            'requiresDropoff',
            'geoapifyApiKey',
        ));
    }

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
            'booking_id' => $booking->booking_id,
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

        $errors = $job->getErrors();

        if (!empty($errors)) {
            foreach ($errors as $field => $fieldErrors) {
                foreach ($fieldErrors as $message) {
                    $this->Flash->error(ucfirst(str_replace('_', ' ', (string)$field)) . ': ' . $message);
                }
            }
        } else {
            $this->Flash->error(__('The booking could not be converted to a job.'));
        }

        return $this->redirect(['action' => 'index']);
    }

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
        $booking->rejected_notified = 0;

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
            return $this->redirect(['controller' => 'Users', 'action' => 'login']);
        }

        $customersTable = $this->fetchTable('Customers');

        $customer = $customersTable->find()
            ->where(['email' => $identity->get('email')])
            ->first();

        if (!$customer) {
            $this->Flash->error(__('Customer profile not found.'));

            return $this->redirect(['controller' => 'Pages', 'action' => 'display', 'home']);
        }

        $bookings = $this->Bookings->find()
            ->contain(['JobTypes'])
            ->where([
                'customer_id' => $customer->customer_id,
                'status IN' => ['Pending','Processing', 'Ready', 'Done', 'Cancelled'],
            ])
            ->all();

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

        $popupRejected = $this->Bookings->find()
            ->where([
                'customer_id' => $customer->customer_id,
                'status' => 'Rejected',
                'rejected_notified' => 0,
            ])
            ->first();

        if ($popupRejected) {
            $popupRejected->rejected_notified = 1;
            $this->Bookings->save($popupRejected);
        }

        $this->set(compact('bookings', 'popupBooking', 'popupRejected'));
    }

    private function isAdmin(): bool
    {
        $identity = $this->request->getAttribute('identity');
        $userTable = $this->fetchTable('Users');
        $user = $userTable->get($identity->get('user_id'), contain:['UserTypes']);

        return $identity && $user->user_type_name == "Admin";
    }

    private function bookingTypeConfig(): array
    {
        return [
            1 => [
                'name' => 'Removal',
                'description' => 'Book a removal service.',
                'requires_dropoff' => false,
                'pickup_label' => 'Pickup Address',
                'dropoff_label' => 'Dropoff Address',
            ],
            2 => [
                'name' => 'Storage',
                'description' => 'Book a storage pickup request.',
                'requires_dropoff' => false,
                'pickup_label' => 'Pickup Address',
                'dropoff_label' => 'Storage Destination',
            ],
            3 => [
                'name' => 'Transfer',
                'description' => 'Book a transfer between two locations.',
                'requires_dropoff' => true,
                'pickup_label' => 'Pickup Address',
                'dropoff_label' => 'Dropoff Address',
            ],
        ];
    }

    private function buildAddress(string $street, string $suburb, string $postcode): string
    {
        return implode(', ', array_filter([
            trim($street),
            trim($suburb),
            trim($postcode),
        ]));
    }
}
