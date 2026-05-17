<?php
declare(strict_types=1);

namespace App\Controller;

/**
 * Equipment Controller
 *
 * @property \App\Model\Table\EquipmentTable $Equipment
 */
class EquipmentController extends AppController
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
            $isAdmin = $roleQuery->user_type_name == 'Admin';
            if (!$isAdmin) {
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
        $query = $this->Equipment->find();
        $equipment = $this->paginate($query);

        $this->set(compact('equipment'));
    }

    /**
     * View method
     *
     * @param string|null $id Equipment id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $equipmentEntity = $this->Equipment->get($id, contain: []);
        $this->set(compact('equipmentEntity'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $categoryOptions = $this->getCategoryOptions();
        $equipmentEntity = $this->Equipment->newEmptyEntity();
        if ($this->request->is('post')) {
            $equipmentEntity = $this->Equipment->patchEntity($equipmentEntity, $this->request->getData());
            if ($this->Equipment->save($equipmentEntity)) {
                $this->Flash->success(__('The equipment has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The equipment could not be saved. Please, try again.'));
        }
        $this->set(compact('equipmentEntity', 'categoryOptions'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Equipment id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $categoryOptions = $this->getCategoryOptions();
        $equipmentEntity = $this->Equipment->get($id, contain: []);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $equipmentEntity = $this->Equipment->patchEntity($equipmentEntity, $this->request->getData());
            if ($this->Equipment->save($equipmentEntity)) {
                $this->Flash->success(__('The equipment has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The equipment could not be saved. Please, try again.'));
        }
        $this->set(compact('equipmentEntity', 'categoryOptions'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Equipment id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $equipmentEntity = $this->Equipment->get($id);
        if ($this->Equipment->delete($equipmentEntity)) {
            $this->Flash->success(__('The equipment has been deleted.'));
        } else {
            $this->Flash->error(__('The equipment could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }

    private function getCategoryOptions(): array
    {
        return [
            'Trolley' => 'Trolley',
            'Protective' => 'Protective',
            'Securing' => 'Securing',
            'Packing' => 'Packing',
            'Lifting' => 'Lifting',
            'Cleaning' => 'Cleaning',
            'Other' => 'Other',
        ];
    }
}
