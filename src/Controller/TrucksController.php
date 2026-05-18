<?php
declare(strict_types=1);

namespace App\Controller;

/**
 * Trucks Controller
 *
 * @property \App\Model\Table\TrucksTable $Trucks
 */
class TrucksController extends AppController
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
        $query = $this->Trucks->find();

        $search = trim((string)$this->request->getQuery('search'));
        $capacity = $this->request->getQuery('capacity_m3');
        $status = $this->request->getQuery('status');
        $isActive = $this->request->getQuery('is_active');

        $capacityOptions = $this->Trucks->find('list', [
            'keyField' => 'capacity_m3',
            'valueField' => function ($truck) {
                return $truck->capacity_m3 . ' m³';
            },
        ])
            ->where(['Trucks.capacity_m3 IS NOT' => null])
            ->distinct(['Trucks.capacity_m3'])
            ->orderBy(['Trucks.capacity_m3' => 'ASC'])
            ->toArray();

        if ($search !== '') {
            $like = '%' . $search . '%';
            $query->where(function ($exp) use ($like) {
                return $exp->or([
                    'Trucks.rego LIKE' => $like,
                    'Trucks.status LIKE' => $like,
                    'Trucks.current_location LIKE' => $like,
                ]);
            });
        }

        if ($capacity !== null && $capacity !== '') {
            $query->where(['Trucks.capacity_m3' => $capacity]);
        }

        if (!empty($status)) {
            $query->where(['Trucks.status' => $status]);
        }

        if ($isActive !== null && $isActive !== '') {
            $query->where(['Trucks.is_active' => (int)$isActive]);
        }

        $trucks = $this->paginate($query);

        $this->set(compact('trucks', 'search', 'capacity', 'status', 'isActive', 'capacityOptions'));
    }

    /**
     * View method
     *
     * @param string|null $id Truck id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $truck = $this->Trucks->get($id, contain: []);
        $this->set(compact('truck'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $depotOptions = $this->getDepotOptions();
        $truck = $this->Trucks->newEmptyEntity();
        if ($this->request->is('post')) {
            $truck = $this->Trucks->patchEntity($truck, $this->request->getData());
            if ($this->Trucks->save($truck)) {
                $this->Flash->success(__('The truck has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The truck could not be saved. Please, try again.'));
        }
        $this->set(compact('truck', 'depotOptions'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Truck id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $depotOptions = $this->getDepotOptions();
        $truck = $this->Trucks->get($id, contain: []);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $truck = $this->Trucks->patchEntity($truck, $this->request->getData());
            if ($this->Trucks->save($truck)) {
                $this->Flash->success(__('The truck has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The truck could not be saved. Please, try again.'));
        }
        $this->set(compact('truck', 'depotOptions'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Truck id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $truck = $this->Trucks->get($id);

        $jobResourcesTable = $this->fetchTable('JobResources');

        $assignedCount = $jobResourcesTable->find()
            ->where([
                'truck_id' => $truck->truck_id,
            ])
            ->count();

        if ($assignedCount > 0) {
            $this->Flash->error(__('This truck cannot be deleted because it is assigned to a job.'));
            return $this->redirect(['action' => 'index']);
        }

        if ($this->Trucks->delete($truck)) {
            $this->Flash->success(__('The truck has been deleted.'));
        } else {
            $this->Flash->error(__('The truck could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
    private function getDepotOptions(): array
    {
        return [
            'Clayton Depot' => 'Clayton Depot',
            'Springvale Depot' => 'Springvale Depot',
            'Dandenong Depot' => 'Dandenong Depot',
            'Moorabbin Depot' => 'Moorabbin Depot',
            'Melbourne Depot' => 'Melbourne Depot',
            'Other' => 'Other',
        ];
    }
}
