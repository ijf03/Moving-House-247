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
        $users = $this->paginate($query);

        $this->set(compact('users', 'isAdmin'));
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

        $siteKey = Configure::read('Recaptcha.siteKey');
        $this->set(compact('siteKey'));

        if ($this->request->is('post')) {
            $captchaResponse = $this->request->getData('g-recaptcha-response');
            if (empty($captchaResponse)) {
                $this->Flash->error('Please complete the CAPTCHA.');
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
                return;
            }
            $result = $this->Authentication->getResult();

            if ($result->isValid()) {
                $user = $result->getData();
                $redirect = $this->Authentication->getLoginRedirect();

                // Admin
                if ((int)$user->user_type === 1) {
                    return $this->redirect($redirect ?: ['controller' => 'Users', 'action' => 'index']);
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
        ])->all();
        if ($this->request->is('post')) {
            $user = $this->Users->patchEntity($user, $this->request->getData());
            if ($this->Users->save($user)) {
                $this->Flash->success(__('The user has been saved.'));

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
