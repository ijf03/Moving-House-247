<?php
declare(strict_types=1);

namespace App\Controller;

/**
 * InvoiceItemPresets Controller
 *
 * @property \App\Model\Table\InvoiceItemPresetsTable $InvoiceItemPresets
 */
class InvoiceItemPresetsController extends AppController
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
        $query = $this->InvoiceItemPresets->find();
        $invoiceItemPresets = $this->paginate($query);

        $this->set(compact('invoiceItemPresets'));
    }

    /**
     * View method
     *
     * @param string|null $id Invoice Item Preset id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $invoiceItemPreset = $this->InvoiceItemPresets->get($id, contain: []);
        $this->set(compact('invoiceItemPreset'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $invoiceItemPreset = $this->InvoiceItemPresets->newEmptyEntity();
        if ($this->request->is('post')) {
            $invoiceItemPreset = $this->InvoiceItemPresets->patchEntity($invoiceItemPreset, $this->request->getData());
            if ($this->InvoiceItemPresets->save($invoiceItemPreset)) {
                $this->Flash->success(__('The invoice item preset has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The invoice item preset could not be saved. Please, try again.'));
        }
        $this->set(compact('invoiceItemPreset'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Invoice Item Preset id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $invoiceItemPreset = $this->InvoiceItemPresets->get($id, contain: []);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $invoiceItemPreset = $this->InvoiceItemPresets->patchEntity($invoiceItemPreset, $this->request->getData());
            if ($this->InvoiceItemPresets->save($invoiceItemPreset)) {
                $this->Flash->success(__('The invoice item preset has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The invoice item preset could not be saved. Please, try again.'));
        }
        $this->set(compact('invoiceItemPreset'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Invoice Item Preset id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $invoiceItemPreset = $this->InvoiceItemPresets->get($id);
        if ($this->InvoiceItemPresets->delete($invoiceItemPreset)) {
            $this->Flash->success(__('The invoice item preset has been deleted.'));
        } else {
            $this->Flash->error(__('The invoice item preset could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
