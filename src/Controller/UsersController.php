<?php
declare(strict_types=1);

namespace App\Controller;

use Cake\I18n\FrozenTime;
use Cake\Mailer\Mailer;
use Cake\Core\Configure;
use Cake\I18n\DateTime;

/**
 * Users Controller
 *
 * @property \App\Model\Table\UsersTable $Users
 */
class UsersController extends AppController
{
    //Exclude pages from authentication
    public function beforeFilter(\Cake\Event\EventInterface $event): void
    {
        parent::beforeFilter($event);
        // Configure the login action to not require authentication, preventing
        // the infinite redirect loop issue
        $this->Authentication->allowUnauthenticated(['login','forgetpassword','resetpassword', 'register']);
    }

    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */

    public function index()
    {
        $user = $this->Authentication->getIdentity();
        $userId = $user->user_id;

        $roleQuery = $this->Users->find()
            ->where(['user_id' => $userId])
            ->contain(['UserTypes'])
            ->first();

        $isAdmin = $roleQuery->user_type_name == 'Admin';

        $query = $this->Users->find()
            ->contain(['UserTypes']);

        $search = trim((string)$this->request->getQuery('search'));
        $userTypeId = $this->request->getQuery('user_type');

        $userTypes = $this->Users->UserTypes->find('list', [
            'keyField' => 'user_type_id',
            'valueField' => 'name',
        ])->all();

        if (!$isAdmin) {
            $query->where(['Users.user_id' => $userId]);
        }

        if ($search !== '') {
            $like = '%' . $search . '%';
            $query->where(function ($exp) use ($like) {
                return $exp->or([
                    'Users.email LIKE' => $like,
                    'Users.phone LIKE' => $like,
                    'Users.first_name LIKE' => $like,
                    'Users.last_name LIKE' => $like,
                    'UserTypes.name LIKE' => $like,
                ]);
            });
        }

        if (!empty($userTypeId)) {
            $query->where(['Users.user_type' => $userTypeId]);
        }

        $users = $this->paginate($query);

        $this->set(compact('users', 'isAdmin', 'search', 'userTypeId', 'userTypes'));
    }

    /**
     * View method
     *
     * @param string|null $id User id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $target = (int)$this->request->getParam('pass')[0];
        $userId = $this->request->getAttribute('identity')->get('user_id');
        $roleQuery = $this->Users->find()
            ->where(['user_id' => $userId])
            ->contain(['UserTypes'])
            ->first();
        $isAdmin = $roleQuery->user_type_name == 'Admin';
        if ($target !== $userId and !$isAdmin){
            $this->Flash->error(__('Please access your own profile'));
            return $this->redirect(['action' => 'index']);
        }
        $user = $this->Users->get($id, contain: ['UserTypes']);
        $this->set(compact('user', 'isAdmin'));
    }
    public function login()
    {
        $this->request->allowMethod(['get', 'post']);
        if ($this->request->is('get')) {
            if($this->Authentication->getIdentity())
            {
                return $this->redirect('/');
            }
        }

        $siteKey = Configure::read('Recaptcha.siteKey');
        $this->set(compact('siteKey'));

        if ($this->request->is('post')) {
            $captchaResponse = $this->request->getData('g-recaptcha-response');

            $secretKey = Configure::read('Recaptcha.secretKey');

            $verifyResponse = file_get_contents(
                'https://www.google.com/recaptcha/api/siteverify?secret=' .
                urlencode($secretKey) .
                '&response=' .
                urlencode($captchaResponse)
            );

            $responseData = json_decode($verifyResponse, true);

            if (!isset($responseData['success']) || $responseData['success'] !== true) {
                $this->Authentication->logout();
                $this->Flash->error('CAPTCHA verification failed. Please try again.');
                return;
            }

            $result = $this->Authentication->getResult();

            if ($result->isValid()) {
                $user = $result->getData();
                $redirect = $this->Authentication->getLoginRedirect();
                $user = $this->Users->get($user['user_id'],contain: ['UserTypes']);

                if ($user->user_type_name === "Admin") {
                    return $this->redirect($redirect ?: ['controller' => 'Admin', 'action' => 'index']);
                }elseif ($user->user_type_name === "Staff") {
                    return $this->redirect($redirect ?: ['controller' => 'Jobs', 'action' => 'available']);
                }

                return $this->redirect($redirect ?: '/');
            }

            $this->Flash->error('Invalid email or password');
        }
    }

    public function logout()
    {
        // Allow GET for simplicity
        $this->request->allowMethod(['get']);

        // If user is logged in, clear identity
        $result = $this->Authentication->getResult();
        if ($result->isValid()) {
            $this->Authentication->logout();
        }

        // Redirect back to login page
        return $this->redirect('/');
    }



    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $userId = $this->request->getAttribute('identity')->get('user_id');
        $roleQuery = $this->Users->find()
            ->where(['user_id' => $userId])
            ->contain(['UserTypes'])
            ->first();
        $isAdmin = $roleQuery->user_type_name == 'Admin';
        if (!$isAdmin){
            $this->Flash->error(__('You are not allow to create users'));
            return $this->redirect(['action' => 'index']);
        }
        $user = $this->Users->newEmptyEntity();
        $userTypes = $this->Users->UserTypes->find('list', [
            'keyField' => 'user_type_id',
            'valueField' => 'name'
        ])->all()->toArray();
        if ($this->request->is('post')) {
            $data = $this->request->getData();
            $data['isDriver'] = null;
            $data['license_number'] = null;
            $user = $this->Users->patchEntity($user, $data);
            if ($this->Users->save($user)) {
                $roleQuery = $this->Users->find()
                    ->where(['user_id' => $user->user_id])
                    ->contain(['UserTypes'])
                    ->first();
                $this->Flash->success(__('The user has been saved.'));
                if ($roleQuery->user_type_name == 'Staff')
                {
                    $staffTable = $this->fetchTable('Staff');
                    $staffData = $this->request->getData();
                    if ($staffData['isDriver'] == '1') {
                        if (strlen((string)$staffData['license_number']) != 9 || strlen((string)((int)$staffData['license_number'])) != 9) {
                            $this->Flash->error('Invalid License Number');
                            $this->Users->delete($user);
                            $this->set(compact('user','userTypes'));
                            return;
                        }
                        $staffData['license_number'] = hash('sha256', $staffData['license_number']);
                    }
                    else{
                        $staffData['license_number'] = null;
                    }
                    $staff = $staffTable->newEntity([
                        'first_name' => $staffData['first_name'],
                        'last_name' => $staffData['last_name'],
                        'email' => $staffData['email'],
                        'phone' => $staffData['phone'],
                        'isDriver' => $staffData['isDriver'],
                        'license_number' => $staffData['license_number'],
                    ]);
                    if (!$staffTable->save($staff)) {
                        $this->Flash->error('Staff account cannot be created, corresponding user account is deleted. Please try again');
                        $this->Users->delete($user);
                        $this->set(compact('user','userTypes'));
                        return;
                    }
                    $this->Flash->success('Staff account created');
                }
                elseif ($roleQuery->user_type_name == 'Customer')
                {
                    $customersTable = $this->fetchTable('Customers');

                    $customer = $customersTable->newEntity([
                        'first_name' => $user->first_name,
                        'last_name' => $user->last_name,
                        'email' => $user->email,
                        'phone' => $user->phone,
                    ]);

                    if (!$customersTable->save($customer)) {
                        $this->Flash->error('User account created, but customer profile could not be created.');
                        $this->Users->delete($user);
                        $this->set(compact('user','userTypes'));
                        return;
                    }
                }
                $this->set(compact('user','userTypes'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The user could not be saved. Please, try again.'));
        }
        $this->set(compact('user','userTypes'));
    }

    /**
     * Edit method
     *
     * @param string|null $id User id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $target = (int)$this->request->getParam('pass')[0];
        $userId = $this->request->getAttribute('identity')->get('user_id');
        $roleQuery = $this->Users->find()
            ->where(['user_id' => $userId])
            ->contain(['UserTypes'])
            ->first();
        $isAdmin = $roleQuery->user_type_name == 'Admin';
        $userTypes = $isAdmin ? $this->Users->UserTypes->find('list', [
            'keyField' => 'user_type_id',
            'valueField' => 'name'
        ])->all() : null;
        if ($target !== $userId && !$isAdmin){
            $this->Flash->error(__('Please access your own profile'));
            return $this->redirect(['action' => 'index']);
        }
        $user = $this->Users->get($id, contain: ['UserTypes']);
        if ($user->user_type_name == 'Staff')
        {
            $staffTable = $this->fetchTable('Staff');
            $staff = $staffTable->find()
                ->where(['email'=>$user->email])
                ->first();
        }
        if ($this->request->is(['patch', 'post', 'put'])) {
            $data = $this->request->getData();
            if (!$isAdmin) {
                $data['user_type'] = $this->request->getAttribute('identity')->get('user_type');
            }
            if (!$data['password']) {
                unset($data['password']);
                unset($data['confirm_password']);
            }
            $user = $this->Users->patchEntity($user, $data);
            if ($this->Users->save($user)) {
                $this->Flash->success(__($user->full_name . ' has been saved.'));
                if ($user->user_type_name == 'Staff')
                {
                    $staff = $staffTable->patchEntity($staff,[
                        'first_name' => $user->first_name,
                        'last_name' => $user->last_name,
                        'email' => $user->email,
                        'phone' => $user->phone,
                    ]);
                    if (!$staffTable->save($staff))
                    {
                        $this->Flash->error('Cannot edit staff details, Please try again.');
                        return;
                    }
                }

                return $this->redirect(['action' => 'index']);
            }
            else {
                $this->Flash->error(__('The user could not be saved. Please, try again.'));
            }
        }
        $this->set(compact('user','userTypes'));
    }

    /**
     * Delete method
     *
     * @param string|null $id User id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $target = (int)$this->request->getParam('pass')[0];
        $userId = $this->request->getAttribute('identity')->get('user_id');
        $roleQuery = $this->Users->find()
            ->where(['user_id' => $userId])
            ->contain(['UserTypes'])
            ->first();
        $isAdmin = $roleQuery->user_type_name == 'Admin';
        if ($target !== $userId && !$isAdmin){
            $this->Flash->error(__('You are not allowed to delete this user'));
            return $this->redirect(['action' => 'index']);
        }
        $this->request->allowMethod(['post', 'delete']);
        $user = $this->Users->get($id);
        $userType = $this->Users->get($id, contain: ['UserTypes']);
        if ($userType->user_type_name == 'Staff')
        {
            $staffTable = $this->fetchTable('Staff');
            $staffRef = $staffTable->find()
                ->where(['email'=>$user->email])
                ->first();
            if(!$staffRef)
            {
                $this->Flash->error(__('Staff profile not found'));
                return;
            }
            $staff = $staffTable->get($staffRef->staff_id);
            if (!$staffTable->delete($staff)) {
                $this->Flash->error('Staff account could not be deleted, please try again.');
                return;
            }
        }
        if ($this->Users->delete($user)) {
            $this->Flash->success(__($user->full_name . ' has been deleted.'));
            if ($target === $userId) {
                return $this->redirect(['controller' => 'Users', 'action' => 'logout']);
            }
        } else {
            $this->Flash->error(__($user->full_name . ' could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }

    public function forgetpassword()
    {
        $siteKey = Configure::read('Recaptcha.siteKey');
        $this->set(compact('siteKey'));

        $this->request->allowMethod(['get', 'post']);
        if ($this->request->is('post')) {
            $data = $this->request->getData();
            $captchaResponse = $data['g-recaptcha-response'] ?? '';
            if (empty($captchaResponse)) {
                $this->Flash->error(__('Please complete the reCAPTCHA.'));
                return;
            }
            $secretKey = Configure::read('Recaptcha.secretKey');

            $verifyResponse = file_get_contents(
                'https://www.google.com/recaptcha/api/siteverify?secret='
                . urlencode($secretKey)
                . '&response=' . urlencode($captchaResponse)
                . '&remoteip=' . urlencode($this->request->clientIp() ?? '')
            );

            $captchaSuccess = json_decode($verifyResponse, true);

            if (empty($captchaSuccess['success'])) {
                $this->Flash->error(__('reCAPTCHA verification failed. Please try again.'));
                return;
            }

            $user = $this->Users->find()
                ->where(['email' => $this->request->getData('email')])
                ->first();

            if ($user) {
                $reset_id = bin2hex(random_bytes(10));
                $reset_id_check = $this->Users->find()
                    ->where(['reset_id' => $reset_id])
                    ->first();
                while($reset_id_check){
                    $reset_id = bin2hex(random_bytes(10));
                    $reset_id_check = $this->Users->find()
                        ->where(['reset_id' => $reset_id])
                        ->first();
                    if($reset_id_check){
                        $time_limit = new FrozenTime($reset_id_check->time_limit);
                        if ($time_limit->isPast()){
                            $reset_id_check->reset_id = null;
                            $reset_id_check->time_limit = null;
                            $this->Users->save($reset_id_check);
                        }
                    }
                }
                $mailer = new Mailer('default');
                $mailer
                    ->setTo($user->email)
                    ->setSubject('Password Reset')
                    ->deliver('Link to reset your password: ' . Configure::read('App.fullBaseUrl') . '/users/resetpassword/' . $reset_id);
                $user->reset_id = $reset_id;
                $user->time_limit = DateTime::now()->modify('+30 minutes');
                $this->Users->save($user);
                $this->Flash->error('Email with password reset link sent to ' . $user->email);
                return $this->redirect(['action' => 'login']);
            } else {
                $this->Flash->error('Email is not registered');
            }
        }
    }

    public function resetpassword($reset_id = null)
    {
        $this->request->allowMethod(['get', 'post','put']);
        $user = $this->Users->find()
            ->where(['reset_id' => $reset_id])
            ->first();
        $time_limit = new FrozenTime($user->time_limit);
        if ($time_limit->isPast()){
            $this->Flash->error('The link has expired.');
            return $this->redirect(['action' => 'forgetpassword']);
        }
        if ($this->request->is(['post', 'put'])) {
            $data = $this->request->getData();
            $user = $this->Users->patchEntity($user, $data);
            $user->reset_id = null;
            $user->time_limit = null;
            if (!$this->Users->save($user)){
                $this->set('user', $user);
                return;
            }
            return $this->redirect(['action' => 'login']);
        }
    }

    public function register()
    {
        $user = $this->Users->newEmptyEntity();
        $siteKey = Configure::read('Recaptcha.siteKey');

        if ($this->request->is('post')) {
            $data = $this->request->getData();
            $data['user_type'] = 3;

            $captchaResponse = $this->request->getData('g-recaptcha-response');

            if (empty($captchaResponse)) {
                $this->Flash->error('Please complete the CAPTCHA.');
                $user = $this->Users->patchEntity($user, $data);
                $this->set(compact('user', 'siteKey'));
                return;
            }

            $secretKey = Configure::read('Recaptcha.secretKey');

            $verifyResponse = file_get_contents(
                'https://www.google.com/recaptcha/api/siteverify?secret=' .
                urlencode($secretKey) .
                '&response=' .
                urlencode($captchaResponse)
            );

            $responseData = json_decode($verifyResponse, true);

            if (!isset($responseData['success']) || $responseData['success'] !== true) {
                $this->Flash->error('CAPTCHA verification failed. Please try again.');
                $user = $this->Users->patchEntity($user, $data);
                $this->set(compact('user', 'siteKey'));
                return;
            }

            $user = $this->Users->patchEntity($user, $data);

            if ($this->Users->save($user)) {
                $customersTable = $this->fetchTable('Customers');

                $customer = $customersTable->newEntity([
                    'first_name' => $user->first_name,
                    'last_name' => $user->last_name,
                    'email' => $user->email,
                    'phone' => $user->phone,
                ]);

                if (!$customersTable->save($customer)) {
                    $this->Flash->error('User account created, but customer profile could not be created.');
                    $this->Users->delete($user);
                    return;
                }

                $this->Flash->success('Registration successful. Please log in.');
                return $this->redirect(['action' => 'login']);
            }

            $this->Flash->error('Registration failed. Please try again.');
        }

        $this->set(compact('user', 'siteKey'));
    }

}
