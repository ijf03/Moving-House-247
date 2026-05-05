<?php
declare(strict_types=1);

namespace App\Controller;

/**
 * StorageUnits Controller
 *
 * @property \App\Model\Table\StorageUnitsTable $StorageUnits
 */
class StorageUnitsController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $query = $this->StorageUnits->find();
        $storageUnits = $this->paginate($query);

        $this->set(compact('storageUnits'));
    }

    /**
     * View method
     *
     * @param string|null $id Storage Unit id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $storageUnit = $this->StorageUnits->get($id, contain: []);
        $this->set(compact('storageUnit'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $storageUnit = $this->StorageUnits->newEmptyEntity();
        if ($this->request->is('post')) {
            $storageUnit = $this->StorageUnits->patchEntity($storageUnit, $this->request->getData());
            if ($this->StorageUnits->save($storageUnit)) {
                $this->Flash->success(__('The storage unit has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The storage unit could not be saved. Please, try again.'));
        }
        $this->set(compact('storageUnit'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Storage Unit id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $storageUnit = $this->StorageUnits->get($id, contain: []);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $storageUnit = $this->StorageUnits->patchEntity($storageUnit, $this->request->getData());
            if ($this->StorageUnits->save($storageUnit)) {
                $this->Flash->success(__('The storage unit has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The storage unit could not be saved. Please, try again.'));
        }
        $this->set(compact('storageUnit'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Storage Unit id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $storageUnit = $this->StorageUnits->get($id);
        if ($this->StorageUnits->delete($storageUnit)) {
            $this->Flash->success(__('The storage unit has been deleted.'));
        } else {
            $this->Flash->error(__('The storage unit could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
