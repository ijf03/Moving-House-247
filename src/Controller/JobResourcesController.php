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
        $query = $this->JobResources->find()
            ->contain([
                'Jobs' => [
                    'JobTypes',
                    'Customers',
                ],
                'Trucks',
                'Equipment',
                'StorageUnits',
                'InventoryItems',
            ]);

        $search = trim((string)$this->request->getQuery('search'));
        $resourceType = $this->request->getQuery('resource_type');

        if ($search !== '') {
            $like = '%' . $search . '%';
            $query->where(function ($exp) use ($like) {
                return $exp->or([
                    'Jobs.description LIKE' => $like,
                    'Jobs.pickup_address LIKE' => $like,
                    'Jobs.dropoff_address LIKE' => $like,
                    'Customers.first_name LIKE' => $like,
                    'Customers.last_name LIKE' => $like,
                    'Customers.email LIKE' => $like,
                    'JobTypes.job_type_name LIKE' => $like,
                    'Trucks.rego LIKE' => $like,
                    'Equipment.name LIKE' => $like,
                    'StorageUnits.unit_code LIKE' => $like,
                    'InventoryItems.name LIKE' => $like,
                ]);
            });
        }

        if ($resourceType === 'truck') {
            $query->where(['JobResources.truck_id IS NOT' => null]);
        } elseif ($resourceType === 'equipment') {
            $query->where(['JobResources.equipment_id IS NOT' => null]);
        } elseif ($resourceType === 'storage_unit') {
            $query->where(['JobResources.storage_unit_id IS NOT' => null]);
        } elseif ($resourceType === 'inventory') {
            $query->where(['JobResources.inventory_id IS NOT' => null]);
        }

        if (!$this->request->getQuery('sort')) {
            $query->orderBy([
                'JobResources.job_id' => 'ASC',
                'JobResources.job_resource_id' => 'ASC',
            ]);
        }

        $jobResources = $this->paginate($query);

        $this->set(compact('jobResources', 'search', 'resourceType'));
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
        if (!$id) {
            $this->Flash->error(__('Missing job ID.'));
            return $this->redirect(['action' => 'index']);
        }

        $jobsTable = $this->fetchTable('Jobs');

        $job = $jobsTable->get($id, contain: [
            'Customers',
            'JobTypes',
        ]);

        $jobResources = $this->JobResources->find()
            ->contain([
                'Trucks',
                'Equipment',
                'StorageUnits',
                'InventoryItems',
            ])
            ->where([
                'JobResources.job_id' => $id,
            ])
            ->orderBy([
                'JobResources.job_resource_id' => 'ASC',
            ])
            ->all();

        $this->set(compact('job', 'jobResources'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add($jobId = null)
    {
        if (!$jobId) {
            $this->Flash->error(__('Please select a job before adding a resource.'));
            return $this->redirect(['action' => 'index']);
        }

        $jobResource = $this->JobResources->newEmptyEntity();

        if ($this->request->is('post')) {
            $data = $this->request->getData();
            $data['job_id'] = $jobId;

            $selectedResources = array_filter([
                $data['truck_id'] ?? null,
                $data['equipment_id'] ?? null,
                $data['storage_unit_id'] ?? null,
                $data['inventory_id'] ?? null,
            ], function ($value) {
                return $value !== null && $value !== '';
            });

            if (count($selectedResources) !== 1) {
                $this->Flash->error(__('Please select exactly one resource type.'));
                return $this->redirect(['action' => 'add', $jobId]);
            }

            $jobResource = $this->JobResources->patchEntity($jobResource, $data);

            if ($this->JobResources->save($jobResource)) {
                $this->Flash->success(__('The job resource has been saved.'));
                return $this->redirect(['action' => 'view', $jobId]);
            }

            $this->Flash->error(__('The job resource could not be saved. Please, try again.'));
        }

        $jobsTable = $this->fetchTable('Jobs');
        $job = $jobsTable->get($jobId, contain: [
            'Customers',
            'JobTypes',
        ]);

        $trucks = $this->fetchTable('Trucks')->find('list', [
            'keyField' => 'truck_id',
            'valueField' => 'rego',
        ])
            ->where(['is_active' => 1])
            ->toArray();

        $equipment = $this->fetchTable('Equipment')->find('list', [
            'keyField' => 'equipment_id',
            'valueField' => 'name',
        ])
            ->where(['is_active' => 1])
            ->toArray();

        $storageUnits = $this->fetchTable('StorageUnits')->find('list', [
            'keyField' => 'storage_unit_id',
            'valueField' => 'unit_code',
        ])
            ->where(['is_active' => 1])
            ->toArray();

        $inventoryItems = $this->fetchTable('InventoryItems')->find('list', [
            'keyField' => 'inventory_item_id',
            'valueField' => 'name',
        ])
            ->where(['is_active' => 1])
            ->toArray();

        $this->set(compact(
            'jobResource',
            'job',
            'jobId',
            'trucks',
            'equipment',
            'storageUnits',
            'inventoryItems'
        ));
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
