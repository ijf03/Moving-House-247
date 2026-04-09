<?php
declare(strict_types=1);

namespace App\Controller;

use Cake\Mailer\Mailer;

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
        $this->Authentication->allowUnauthenticated(['login','resetpassword', 'register']);
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

        if ($this->request->is('post')) {
            $result = $this->Authentication->getResult();

            if ($result->isValid()) {
                $user = $result->getData();

                if ((int)$user->user_type === 1) {
                    return $this->redirect(['controller' => 'Users', 'action' => 'index']);
                }

                return $this->redirect('/');
            }

            if (!$result->isValid()) {
                $this->Flash->error('Invalid email or password');
            }
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
        if ($target !== $userId and !$isAdmin){
            $this->Flash->error(__('Please access your own profile'));
            return $this->redirect(['action' => 'index']);
        }
        $user = $this->Users->get($id, contain: ['UserTypes']);
        $original_type = $user->user_type;
        if ($this->request->is(['patch', 'post', 'put'])) {
            $data = $this->request->getData();
            $data['user_type'] = $original_type;
            $user = $this->Users->patchEntity($user, $this->request->getData());
            if ($this->Users->save($user)) {
                $this->Flash->success(__('The user has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            else {
                $this->Flash->error(__('The user could not be saved. Please, try again.'));
            }
        }
        $this->set(compact('user'));
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
        if ($target !== $userId and !$isAdmin){
            $this->Flash->error(__('You are not allowed to delete this user'));
            return $this->redirect(['action' => 'index']);
        }
        $this->request->allowMethod(['post', 'delete']);
        $user = $this->Users->get($id);
        if ($this->Users->delete($user)) {
            $this->Flash->success(__('The user has been deleted.'));
            if ($target === $userId) {
                return $this->redirect(['controller' => 'Users', 'action' => 'logout']);
            }
        } else {
            $this->Flash->error(__('The user could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }

    public function resetpassword(){
        $this->request->allowMethod(['get', 'post']);
        if ($this->request->is('post')) {
            $data = $this->request->getData();
            $captchaResponse = $data['g-recaptcha-response'] ?? '';
            if (empty($captchaResponse)) {
                $this->Flash->error(__('Please complete the reCAPTCHA.'));
                return;
            }
            $secretKey = "6Lds85QsAAAAAEgTCP--6NvRs-HwEGUoj2C3qXJH";

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
                $newPwd = bin2hex(random_bytes(10));
                $mailer = new Mailer('default');
                $mailer->setFrom(['noreply@test.com'])
                    ->setTo($user->email)
                    ->setSubject('Password Reset')
                    ->deliver('Your new password: ' . $newPwd);
                $user->password = $newPwd;
                $this->Users->save($user);
                $this->log('Email sent, new password: ' . $newPwd);
                $this->Flash->error('Email with new password sent to ' . $user->email);
                return $this->redirect(['action' => 'login']);
            } else {
                $this->Flash->error('Email is not registered');
            }
        }
    }

    public function register()
    {
        $user = $this->Users->newEmptyEntity();

        if ($this->request->is('post')) {
            $data = $this->request->getData();

            $data['user_type'] = 2;

            if (
                empty($data['password']) ||
                empty($data['confirm_password']) ||
                $data['password'] !== $data['confirm_password']
            ) {
                $this->Flash->error('Passwords do not match.');
                $user = $this->Users->patchEntity($user, $data);
                $this->set(compact('user'));
                return;
            }

            $captchaResponse = $this->request->getData('g-recaptcha-response');

            if (empty($captchaResponse)) {
                $this->Flash->error('Please complete the CAPTCHA.');
                $user = $this->Users->patchEntity($user, $data);
                $this->set(compact('user'));
                return;
            }

            $secretKey = '6Lds85QsAAAAAEgTCP--6NvRs-HwEGUoj2C3qXJH';

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
                $this->set(compact('user'));
                return;
            }

            $user = $this->Users->patchEntity($user, $data);

            if ($this->Users->save($user)) {
                $this->Flash->success('Registration successful. Please log in.');
                return $this->redirect(['action' => 'login']);
            }

            $this->Flash->error('Registration failed. Please try again.');
        }

        $this->set(compact('user'));
    }

}
