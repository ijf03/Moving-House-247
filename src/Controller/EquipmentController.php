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

        $search = trim((string)$this->request->getQuery('search'));
        $category = $this->request->getQuery('category');
        $isActive = $this->request->getQuery('is_active');

        $categoryOptions = $this->Equipment->find('list', [
            'keyField' => 'category',
            'valueField' => 'category',
        ])
            ->distinct(['category'])
            ->orderBy(['category' => 'ASC'])
            ->toArray();

        if ($search !== '') {
            $like = '%' . $search . '%';
            $query->where(function ($exp) use ($like) {
                return $exp->or([
                    'Equipment.name LIKE' => $like,
                    'Equipment.category LIKE' => $like,
                    'Equipment.storage_location LIKE' => $like,
                ]);
            });
        }

        if (!empty($category)) {
            $query->where(['Equipment.category' => $category]);
        }

        if ($isActive !== null && $isActive !== '') {
            $query->where(['Equipment.is_active' => (int)$isActive]);
        }

        $equipment = $this->paginate($query);

        $this->set(compact('equipment', 'search', 'category', 'isActive', 'categoryOptions'));
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
        $equipmentEntity = $this->Equipment->newEmptyEntity();
        if ($this->request->is('post')) {
            $equipmentEntity = $this->Equipment->patchEntity($equipmentEntity, $this->request->getData());
            if ($this->Equipment->save($equipmentEntity)) {
                $this->Flash->success(__('The equipment has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The equipment could not be saved. Please, try again.'));
        }
        $this->set(compact('equipmentEntity'));
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
        $equipmentEntity = $this->Equipment->get($id, contain: []);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $equipmentEntity = $this->Equipment->patchEntity($equipmentEntity, $this->request->getData());
            if ($this->Equipment->save($equipmentEntity)) {
                $this->Flash->success(__('The equipment has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The equipment could not be saved. Please, try again.'));
        }
        $this->set(compact('equipmentEntity'));
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
}
