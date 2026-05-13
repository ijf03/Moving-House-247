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
        $availableTruckCount = $trucksTable->find()
            ->where(['status' => 'available', 'is_active' => 1])
            ->count();

        $storageUnitCount = $storageUnitsTable->find()->count();
        $availableStorageUnitCount = $storageUnitsTable->find()
            ->where(['status' => 'available', 'is_active' => 1])
            ->count();

        $equipmentCount = $equipmentTable->find()->count();
        $availableEquipmentCount = $equipmentTable->find()
            ->where(['status' => 'available', 'is_active' => 1])
            ->count();

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

        $recentAssignments = $jobResourcesTable->find()
            ->contain([
                'Jobs' => ['Customers', 'JobTypes']
            ])
            ->limit(10)
            ->all()
            ->toList();

        $truckIds = [];
        $storageUnitIds = [];
        $equipmentIds = [];
        $inventoryItemIds = [];

        foreach ($recentAssignments as $assignment) {
            $resourceType = (string)$assignment->resource_type;
            $resourceId = (int)$assignment->resource_id;

            switch ($resourceType) {
                case 'truck':
                    $truckIds[] = $resourceId;
                    break;
                case 'storage_unit':
                    $storageUnitIds[] = $resourceId;
                    break;
                case 'equipment':
                    $equipmentIds[] = $resourceId;
                    break;
                case 'inventory_item':
                    $inventoryItemIds[] = $resourceId;
                    break;
            }
        }

        $truckMap = [];
        if (!empty($truckIds)) {
            $truckRows = $trucksTable->find()
                ->where(['truck_id IN' => array_unique($truckIds)])
                ->all();

            foreach ($truckRows as $truck) {
                $truckMap[(int)$truck->truck_id] = $truck->name . ' (' . $truck->rego . ')';
            }
        }

        $storageUnitMap = [];
        if (!empty($storageUnitIds)) {
            $storageRows = $storageUnitsTable->find()
                ->where(['storage_unit_id IN' => array_unique($storageUnitIds)])
                ->all();

            foreach ($storageRows as $unit) {
                $storageUnitMap[(int)$unit->storage_unit_id] = $unit->unit_code . ' - ' . $unit->facility_name;
            }
        }

        $equipmentMap = [];
        if (!empty($equipmentIds)) {
            $equipmentRows = $equipmentTable->find()
                ->where(['equipment_id IN' => array_unique($equipmentIds)])
                ->all();

            foreach ($equipmentRows as $item) {
                $equipmentMap[(int)$item->equipment_id] = $item->name;
            }
        }

        $inventoryItemMap = [];
        if (!empty($inventoryItemIds)) {
            $inventoryRows = $inventoryItemsTable->find()
                ->where(['inventory_item_id IN' => array_unique($inventoryItemIds)])
                ->all();

            foreach ($inventoryRows as $item) {
                $inventoryItemMap[(int)$item->inventory_item_id] = $item->name;
            }
        }

        foreach ($recentAssignments as $assignment) {
            $assignment->resource_label = 'Unknown resource';

            switch ((string)$assignment->resource_type) {
                case 'truck':
                    $assignment->resource_label = $truckMap[(int)$assignment->resource_id] ?? 'Unknown truck';
                    break;
                case 'storage_unit':
                    $assignment->resource_label = $storageUnitMap[(int)$assignment->resource_id] ?? 'Unknown storage unit';
                    break;
                case 'equipment':
                    $assignment->resource_label = $equipmentMap[(int)$assignment->resource_id] ?? 'Unknown equipment';
                    break;
                case 'inventory_item':
                    $assignment->resource_label = $inventoryItemMap[(int)$assignment->resource_id] ?? 'Unknown inventory item';
                    break;
            }
        }

        $this->set(compact(
            'truckCount',
            'availableTruckCount',
            'storageUnitCount',
            'availableStorageUnitCount',
            'equipmentCount',
            'availableEquipmentCount',
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
