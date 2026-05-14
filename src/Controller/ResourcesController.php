<?php
declare(strict_types=1);

namespace App\Controller;

/**
 * Resources Controller
 *
 * Central dashboard for operational resources:
 * - trucks
 * - storage units
 * - equipment
 * - inventory items
 * - recent booking resource assignments
 */
class ResourcesController extends AppController
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
    public function index()
    {
        $identity = $this->request->getAttribute('identity');

        if (!$identity || (int)$identity->get('user_type') !== 1) {
            $this->Flash->error(__('You are not authorized to access this page.'));
            return $this->redirect(['controller' => 'Pages', 'action' => 'display', 'home']);
        }

        $trucksTable = $this->fetchTable('Trucks');
        $storageUnitsTable = $this->fetchTable('StorageUnits');
        $equipmentTable = $this->fetchTable('Equipment');
        $inventoryItemsTable = $this->fetchTable('InventoryItems');
        $jobResourcesTable = $this->fetchTable('JobResources');

        $truckCount = $trucksTable->find()->count();

        $storageUnitCount = $storageUnitsTable->find()->count();

        $equipmentCount = $equipmentTable->find()->count();

        $inventoryItemCount = $inventoryItemsTable->find()->count();

        $allInventoryItems = $inventoryItemsTable->find()->all();
        $lowStockCount = 0;
        foreach ($allInventoryItems as $item) {
            if ((int)$item->quantity_on_hand <= (int)$item->reorder_threshold) {
                $lowStockCount++;
            }
        }

        $activeAssignmentCount = $jobResourcesTable->find()->count();

        $trucks = $trucksTable->find()
            ->where(['is_active' => 1])
            ->orderBy(['truck_id' => 'ASC'])
            ->limit(5)
            ->all();

        $storageUnits = $storageUnitsTable->find()
            ->where(['is_active' => 1])
            ->orderBy(['storage_unit_id' => 'ASC'])
            ->limit(5)
            ->all();

        $equipment = $equipmentTable->find()
            ->where(['is_active' => 1])
            ->orderBy(['equipment_id' => 'ASC'])
            ->limit(5)
            ->all();

        $inventoryItems = $inventoryItemsTable->find()
            ->where(['is_active' => 1])
            ->orderBy(['inventory_item_id' => 'ASC'])
            ->limit(5)
            ->all();

        $recentJobResources = $jobResourcesTable->find()
            ->contain([
                'Jobs' => [
                    'Customers',
                    'JobTypes',
                ],
            ])
            ->orderBy([
                'JobResources.job_id' => 'DESC',
                'JobResources.job_resource_id' => 'ASC',
            ])
            ->all();

        $groupedAssignments = [];

        foreach ($recentJobResources as $jobResource) {
            $jobId = $jobResource->job_id;

            if (!isset($groupedAssignments[$jobId])) {
                $groupedAssignments[$jobId] = [
                    'job_id' => $jobId,
                    'job' => $jobResource->job ?? null,
                    'truck_count' => 0,
                    'equipment_count' => 0,
                    'storage_unit_count' => 0,
                    'inventory_count' => 0,
                ];
            }

            if (!empty($jobResource->truck_id)) {
                $groupedAssignments[$jobId]['truck_count']++;
            }

            if (!empty($jobResource->equipment_id)) {
                $groupedAssignments[$jobId]['equipment_count']++;
            }

            if (!empty($jobResource->storage_unit_id)) {
                $groupedAssignments[$jobId]['storage_unit_count']++;
            }

            if (!empty($jobResource->inventory_id)) {
                $groupedAssignments[$jobId]['inventory_count']++;
            }
        }

        $recentAssignments = array_slice(array_values($groupedAssignments), 0, 3);

        $this->set(compact(
            'truckCount',
            'storageUnitCount',
            'equipmentCount',
            'inventoryItemCount',
            'lowStockCount',
            'activeAssignmentCount',
            'trucks',
            'storageUnits',
            'equipment',
            'inventoryItems',
            'recentAssignments'
        ));
    }
}
