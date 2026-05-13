<?php
declare(strict_types=1);

namespace App\Controller;

use Cake\Mailer\Mailer;
use Cake\Core\Configure;
use Cake\I18n\DateTime;


/**
 * Staff Controller
 *
 * @property \App\Model\Table\StaffTable $Staff
 */
class StaffController extends AppController
{
    public function beforeFilter(\Cake\Event\EventInterface $event)
    {
        parent::beforeFilter($event);
        if ($this->Authentication->getIdentity()) {
            $user = $this->Authentication->getIdentity();
            $userId = $user->user_id;
            $users = $this->fetchTable('Users');
            $roleQuery = $users->find()
                ->where(['user_id' => $userId])
                ->contain(['UserTypes'])
                ->first();
            $isCustomer = $roleQuery->user_type_name == 'Customer';
            if ($isCustomer) {
                return $this->redirect('/');
            }
        }
    }

    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $usersTable = $this->fetchTable('Users');
        $user = $this->Authentication->getIdentity();
        $userId = $user->user_id;
        $userEmail = $user->email;
        $roleQuery = $usersTable->find()
            ->where(['user_id' => $userId])
            ->contain(['UserTypes'])
            ->first();
        $isAdmin = $roleQuery->user_type_name == 'Admin';
        $query = $this->Staff->find();
        $staff = $this->paginate($query);

        $this->set(compact('staff','isAdmin', 'userEmail'));
    }

    /**
     * View method
     *
     * @param string|null $id Staff id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $target = (int)$this->request->getParam('pass')[0];
        $usersTable = $this->fetchTable('Users');
        $userId = $this->request->getAttribute('identity')->get('user_id');
        $roleQuery = $usersTable->find()
            ->where(['user_id' => $userId])
            ->contain(['UserTypes'])
            ->first();
        $isAdmin = $roleQuery->user_type_name == 'Admin';
        if ($target !== $userId and !$isAdmin){
            $this->Flash->error(__('Please access your own profile'));
            return $this->redirect(['action' => 'index']);
        }
        $staffEntity = $this->Staff->get($id, contain: []);
        $this->set(compact('staffEntity'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    private function randomPassword(int $bits) : string
{
    $charset = ['QWERYIOPASDFGHJKLZXCVBNM',
    'qwertyuiopasdfghjklzxcvbnm',
    '1234567890',
    '!@#$%^&*=_+~-'];
    $allChars = implode('',$charset);
    $password = '';
    foreach ($charset as $set)
    {
        $password .= $set[random_int(0,strlen($set)-1)];
    }
    while (strlen($password) < $bits)
    {
        $char = $allChars[random_int(0,strlen($allChars)-1)];
        $password .= $char;
    }
    return str_shuffle($password);
}
    public function add()
    {
        $usersTable = $this->fetchTable('Users');
        $userId = $this->request->getAttribute('identity')->get('user_id');
        $roleQuery = $usersTable->find()
            ->where(['user_id' => $userId])
            ->contain(['UserTypes'])
            ->first();
        $isAdmin = $roleQuery->user_type_name == 'Admin';
        if(!$isAdmin){
            $this->Flash->error('You are not allowed to register staff');
            return $this->redirect(['action'=>'index']);
        }
        $staffEntity = $this->Staff->newEmptyEntity();
        if ($this->request->is('post')) {
            $staffEntity = $this->Staff->patchEntity($staffEntity, $this->request->getData());
            if ($this->Staff->save($staffEntity)) {
                $this->Flash->success(__('The staff has been saved.'));
                $usersTable = $this->fetchTable('Users');
                $userTypesTable = $this->fetchTable('UserTypes');
                $email_check = $usersTable->find()
                    ->where(['email' => $staffEntity->email])
                    ->first();
                if(!$email_check)
                {
                    $randomPwd = $this->randomPassword(10);
                    $staffType = $userTypesTable->find()
                        ->where(['name' => 'Staff'])
                        ->first();
                    $user = $usersTable->newEntity([
                        'email' => $staffEntity->email,
                        'first_name' => $staffEntity->first_name,
                        'last_name' => $staffEntity->last_name,
                        'phone' => $staffEntity->phone,
                        'password' => $randomPwd,
                        'user_type' => $staffType->user_type_id,
                        'confirm_password' => $randomPwd,
                    ]);
                    if (!$usersTable->save($user)) {
                        $this->Flash->error(__('The user could not be saved. Please, try again.'));
                        return;
                    }
                    $mailer = new Mailer('default');
                    $mailer
                        ->setTo($user->email)
                        ->setSubject('Staff Account')
                        ->deliver('Welcome to MovingHouse24/7! \nYour credentials are: \n    '
                    .$user->email.'\n    '.$randomPwd.'\nPlease go to '. Configure::read('App.fullBaseUrl')
                            . ' to start taking jobs. You are strongly recommended to change your password after first login.');
                }

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The staff could not be saved. Please, try again.'));
        }
        $this->set(compact('staffEntity'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Staff id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $target = $this->Staff->get($id, contain: []);
        $staff = $this->Staff->get($id, contain: []);
        $usersTable = $this->fetchTable('Users');
        $user = $usersTable->find()
            ->where(['email' => $target->email])
            ->first();
        $userId = $this->request->getAttribute('identity')->get('user_id');
        $roleQuery = $usersTable->find()
            ->where(['user_id' => $userId])
            ->contain(['UserTypes'])
            ->first();
        $isAdmin = $roleQuery->user_type_name == 'Admin';
        if ($user->user_id !== $userId && !$isAdmin){
            $this->Flash->error(__('You are not allowed to edit this user'));
            return $this->redirect(['action' => 'index']);
        }
        if ($this->request->is(['patch', 'post', 'put'])) {
            $staff = $this->Staff->patchEntity($staff, $this->request->getData());
            if ($this->Staff->save($staff)) {
                $user = $usersTable->patchEntity($user, ['email' => $staff->email,
                    'phone' => $staff->phone,
                    'first_name' => $staff->first_name,
                    'last_name' => $staff->last_name,]);
                if(!$this->Staff->save($user)){
                    $this->Flash->error(__('User detail cannot be saved'));
                    return;
                }
                $this->Flash->success(__('The staff has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The staff could not be saved. Please, try again.'));
        }
        $this->set(compact('staff','isAdmin'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Staff id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $target = $this->Staff->get($id, contain: []);
        $usersTable = $this->fetchTable('Users');
        $user = $usersTable->find()
            ->where(['email' => $target->email])
            ->first();
        $userId = $this->request->getAttribute('identity')->get('user_id');
        $roleQuery = $usersTable->find()
            ->where(['user_id' => $userId])
            ->contain(['UserTypes'])
            ->first();
        $isAdmin = $roleQuery->user_type_name == 'Admin';
        if ($user->user_id !== $userId && !$isAdmin){
            $this->Flash->error(__('You are not allowed to delete this user'));
            return $this->redirect(['action' => 'index']);
        }
        $this->request->allowMethod(['post', 'delete']);
        $staff = $this->Staff->get($id);
        if ($this->Staff->delete($staff)) {
            $this->Flash->success(__($staff->full_name . ' has been deleted.'));
            if(!$user){
                $this->Flash->error('User not found');
                return;
            }
            if(!$usersTable->delete($user)){
                $this->Flash->error(__('The user could not be deleted. Please, try again.'));
            }
            if ($target === $userId) {
                return $this->redirect(['controller' => 'Users', 'action' => 'logout']);
            }
        } else {
            $this->Flash->error(__('The staff could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }

    public function availability($id = null)
    {
        $staff = $this->Staff->get($id);
        $usersTable = $this->fetchTable('Users');
        $userId = $this->request->getAttribute('identity')->get('user_id');
        $roleQuery = $usersTable->find()
            ->where(['user_id' => $userId])
            ->contain(['UserTypes'])
            ->first();
        $isAdmin = $roleQuery->user_type_name == 'Admin';
        if ($staff->email != $this->Authentication->getIdentity()->email && !$isAdmin) {
            $this->Flash->error(__('You are not allowed to access this page'));
        }
        $availabilityTable = $this->fetchTable('Availability');
        $availabilityList = $availabilityTable->find()
            ->where(['staff_id' => $staff->staff_id])
            ->toArray();
        $events = [];
        foreach ($availabilityList as $availability) {
            $events += [count($events) + 1 => ['id' => $availability->availability_id,
                'start' => $availability->start_datetime->format('Y-m-d H:i:s'),
                'end' => $availability->end_datetime->format('Y-m-d H:i:s'),
            ]
            ];
        }
        $this->request->allowMethod(['post', 'get']);
        if ($this->request->is(['post'])) {
            $updated_events = json_decode($this->request->getData('availability_json'), true);
            $availabilityTable = $this->fetchTable('Availability');
            foreach ($updated_events as $updated_event) {
                $updated_event['allDay'] = null;
                $updated_event['backgroundColor'] = null;
                $updated_event['staff_id'] = $id;
                $updated_event['start_datetime'] = new DateTime($updated_event['start_datetime']);
                $updated_event['end_datetime'] = new DateTime($updated_event['end_datetime']);
                $entry = $availabilityTable->get($updated_event['id']);
                if ($entry->staff_id != $staff->staff_id) {
                    $this->Flash->error(__('Access denied'));
                    return $this->redirect(['action' => 'index']);
                }
                if ($entry) {
                    $entry = $availabilityTable->patchEntity($entry, $updated_event);
                    if (!$availabilityTable->save($entry)) {
                        $this->Flash->error(__('The availability could not be saved. Please, try again.'));
                        return;
                    }
                } else {
                    $newEvent = $availabilityTable->newEntity($updated_event);
                    $newEvent['staff_id'] = $id;
                    if (!$availabilityTable->save($newEvent)) {
                        $this->Flash->error(__('The availability could not be saved. Please, try again.'));
                        return;
                    }
                }
            }
            $this->Flash->success(__('The availability has been saved.'));
        }
        $this->set(compact('staff', 'events', 'availabilityList'));
    }
}
