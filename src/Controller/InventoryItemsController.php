<?php
declare(strict_types=1);

namespace App\Controller;

/**
 * InventoryItems Controller
 *
 * @property \App\Model\Table\InventoryItemsTable $InventoryItems
 */
class InventoryItemsController extends AppController
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
        $query = $this->InventoryItems->find();

        $search = trim((string)$this->request->getQuery('search'));
        $category = $this->request->getQuery('category');
        $unit = $this->request->getQuery('unit');
        $isActive = $this->request->getQuery('is_active');

        $categoryOptions = $this->InventoryItems->find('list', [
            'keyField' => 'category',
            'valueField' => 'category',
        ])
            ->distinct(['category'])
            ->orderBy(['category' => 'ASC'])
            ->toArray();

        $unitOptions = $this->InventoryItems->find('list', [
            'keyField' => 'unit',
            'valueField' => 'unit',
        ])
            ->distinct(['unit'])
            ->orderBy(['unit' => 'ASC'])
            ->toArray();

        if ($search !== '') {
            $like = '%' . $search . '%';
            $query->where(function ($exp) use ($like) {
                return $exp->or([
                    'InventoryItems.name LIKE' => $like,
                    'InventoryItems.category LIKE' => $like,
                    'InventoryItems.unit LIKE' => $like,
                    'InventoryItems.storage_location LIKE' => $like,
                ]);
            });
        }

        if (!empty($category)) {
            $query->where(['InventoryItems.category' => $category]);
        }

        if (!empty($unit)) {
            $query->where(['InventoryItems.unit' => $unit]);
        }

        if ($isActive !== null && $isActive !== '') {
            $query->where(['InventoryItems.is_active' => (int)$isActive]);
        }

        $inventoryItems = $this->paginate($query);

        $this->set(compact('inventoryItems', 'search', 'category', 'unit', 'isActive', 'categoryOptions', 'unitOptions'));
    }

    /**
     * View method
     *
     * @param string|null $id Inventory Item id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $inventoryItem = $this->InventoryItems->get($id, contain: []);
        $this->set(compact('inventoryItem'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $inventoryItem = $this->InventoryItems->newEmptyEntity();
        if ($this->request->is('post')) {
            $inventoryItem = $this->InventoryItems->patchEntity($inventoryItem, $this->request->getData());
            if ($this->InventoryItems->save($inventoryItem)) {
                $this->Flash->success(__('The inventory item has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The inventory item could not be saved. Please, try again.'));
        }
        $this->set(compact('inventoryItem'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Inventory Item id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $inventoryItem = $this->InventoryItems->get($id, contain: []);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $inventoryItem = $this->InventoryItems->patchEntity($inventoryItem, $this->request->getData());
            if ($this->InventoryItems->save($inventoryItem)) {
                $this->Flash->success(__('The inventory item has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The inventory item could not be saved. Please, try again.'));
        }
        $this->set(compact('inventoryItem'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Inventory Item id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $inventoryItem = $this->InventoryItems->get($id);
        if ($this->InventoryItems->delete($inventoryItem)) {
            $this->Flash->success(__('The inventory item has been deleted.'));
        } else {
            $this->Flash->error(__('The inventory item could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
