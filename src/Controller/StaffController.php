<?php
declare(strict_types=1);

namespace App\Controller;

use Cake\Mailer\Mailer;
use Cake\Core\Configure;

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
        $target = (int)$this->request->getParam('pass')[0];
        $staffEntity = $this->Staff->get($id, contain: []);
        $userId = $this->request->getAttribute('identity')->get('user_id');
        $usersTable = $this->fetchTable('Users');
        $roleQuery = $usersTable->find()
            ->where(['user_id' => $userId])
            ->contain(['UserTypes'])
            ->first();
        $user = $usersTable->find()
            ->where(['email'=>$staffEntity->email])
            ->first();
        $isAdmin = $roleQuery->user_type_name == 'Admin';
        if ($target !== $userId and !$isAdmin){
            $this->Flash->error(__('Please access your own profile'));
            return $this->redirect(['action' => 'index']);
        }
        if ($this->request->is(['patch', 'post', 'put'])) {
            $staffEntity = $this->Staff->patchEntity($staffEntity, $this->request->getData());
            if ($this->Staff->save($staffEntity)) {
                $user = $usersTable->patchEntity($user, ['email' => $staffEntity->email,
                    'phone' => $staffEntity->phone,
                    'first_name' => $staffEntity->first_name,
                    'last_name' => $staffEntity->last_name,]);
                if(!$this->Staff->save($user)){
                    $this->Flash->error(__('User detail cannot be saved'));
                    return;
                }
                $this->Flash->success(__('The staff has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The staff could not be saved. Please, try again.'));
        }
        $this->set(compact('staffEntity','isAdmin'));
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
        $targetStaffID = (int)$this->request->getParam('pass')[0];
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
        if ($target !== $userId && !$isAdmin){
            $this->Flash->error(__('You are not allowed to delete this user'));
            return $this->redirect(['action' => 'index']);
        }
        $this->request->allowMethod(['post', 'delete']);
        $staff = $this->Staff->get($id);
        if ($this->Staff->delete($staff)) {
            $this->Flash->success(__($staff->full_name . ' has been deleted.'));
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
}
