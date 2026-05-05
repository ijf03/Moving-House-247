<?php
declare(strict_types=1);

namespace App\Controller;

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
        $user = $this->Authentication->getIdentity();
        $userId = $user->user_id;
        $roleQuery = $this->Users->find()
            ->where(['user_id' => $userId])
            ->contain(['UserTypes'])
            ->first();
        $isAdmin = $roleQuery->user_type_name == 'Admin';
        $query = $this->Staff->find();
        $staff = $this->paginate($query);

        $this->set(compact('staff','isAdmin'));
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
        $staffEntity = $this->Staff->get($id, contain: []);
        $this->set(compact('staffEntity'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $staffEntity = $this->Staff->newEmptyEntity();
        if ($this->request->is('post')) {
            $staffEntity = $this->Staff->patchEntity($staffEntity, $this->request->getData());
            if ($this->Staff->save($staffEntity)) {
                $this->Flash->success(__('The staff has been saved.'));

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
        $staffEntity = $this->Staff->get($id, contain: []);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $staffEntity = $this->Staff->patchEntity($staffEntity, $this->request->getData());
            if ($this->Staff->save($staffEntity)) {
                $this->Flash->success(__('The staff has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The staff could not be saved. Please, try again.'));
        }
        $this->set(compact('staffEntity'));
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
        $staff = $this->Staff->get($id);
        if ($this->Staff->delete($staff)) {
            $this->Flash->success(__($staff->full_name . ' has been deleted.'));
            if ($target === $userId) {
                return $this->redirect(['controller' => 'Users', 'action' => 'logout']);
            }
        } else {
            $this->Flash->error(__('The staff could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
