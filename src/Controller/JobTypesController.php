<?php
declare(strict_types=1);

namespace App\Controller;

/**
 * JobTypes Controller
 *
 * @property \App\Model\Table\JobTypesTable $JobTypes
 */
class JobTypesController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $query = $this->JobTypes->find();
        $jobTypes = $this->paginate($query);

        $this->set(compact('jobTypes'));
    }

    /**
     * View method
     *
     * @param string|null $id Job Type id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $jobType = $this->JobTypes->get($id, contain: []);
        $this->set(compact('jobType'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $jobType = $this->JobTypes->newEmptyEntity();
        if ($this->request->is('post')) {
            $jobType = $this->JobTypes->patchEntity($jobType, $this->request->getData());
            if ($this->JobTypes->save($jobType)) {
                $this->Flash->success(__('The job type has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The job type could not be saved. Please, try again.'));
        }
        $this->set(compact('jobType'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Job Type id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $jobType = $this->JobTypes->get($id, contain: []);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $jobType = $this->JobTypes->patchEntity($jobType, $this->request->getData());
            if ($this->JobTypes->save($jobType)) {
                $this->Flash->success(__('The job type has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The job type could not be saved. Please, try again.'));
        }
        $this->set(compact('jobType'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Job Type id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $jobType = $this->JobTypes->get($id);
        if ($this->JobTypes->delete($jobType)) {
            $this->Flash->success(__('The job type has been deleted.'));
        } else {
            $this->Flash->error(__('The job type could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
