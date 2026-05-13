<?php
declare(strict_types=1);

namespace App\Controller;

/**
 * JobResources Controller
 *
 * @property \App\Model\Table\JobResourcesTable $JobResources
 */
class JobResourcesController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $query = $this->JobResources->find()
            ->contain(['Jobs']);
        $jobResources = $this->paginate($query);

        $this->set(compact('jobResources'));
    }

    /**
     * View method
     *
     * @param string|null $id Booking Resource id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $jobResource = $this->JobResources->get($id, contain: ['Jobs']);
        $this->set(compact('jobResource'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $jobResource = $this->JobResources->newEmptyEntity();
        if ($this->request->is('post')) {
            $jobResource = $this->JobResources->patchEntity($jobResource, $this->request->getData());
            if ($this->JobResources->save($jobResource)) {
                $this->Flash->success(__('The job resource has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The job resource could not be saved. Please, try again.'));
        }
        $jobs = $this->JobResources->Jobs->find('list', limit: 200)->all();
        $this->set(compact('jobResource', 'jobs'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Booking Resource id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $jobResource = $this->JobResources->get($id, contain: []);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $jobResource = $this->JobResources->patchEntity($jobResource, $this->request->getData());
            if ($this->JobResources->save($jobResource)) {
                $this->Flash->success(__('The job resource has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The job resource could not be saved. Please, try again.'));
        }
        $jobs = $this->JobResources->Jobs->find('list', limit: 200)->all();
        $this->set(compact('jobResource', 'jobs'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Booking Resource id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $jobResource = $this->JobResources->get($id);
        if ($this->JobResources->delete($jobResource)) {
            $this->Flash->success(__('The job resource has been deleted.'));
        } else {
            $this->Flash->error(__('The job resource could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
