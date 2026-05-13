<?php
/**
 * @var \App\View\AppView $this
 * @var int $truckCount
 * @var int $availableTruckCount
 * @var int $storageUnitCount
 * @var int $availableStorageUnitCount
 * @var int $equipmentCount
 * @var int $availableEquipmentCount
 * @var int $inventoryItemCount
 * @var int $lowStockCount
 * @var int $activeAssignmentCount
 * @var \Cake\Collection\CollectionInterface $trucks
 * @var \Cake\Collection\CollectionInterface $storageUnits
 * @var \Cake\Collection\CollectionInterface $equipment
 * @var \Cake\Collection\CollectionInterface $inventoryItems
 * @var array $recentAssignments
 */
?>
<div class="mh-page-soft">
    <section class="admin-hero">
        <div class="container">
            <div class="admin-hero-shell">
                <div class="admin-hero-content">
                    <span class="admin-eyebrow"><?= __('Admin') ?></span>
                    <h1><?= __('Resource Management') ?></h1>
                    <p class="admin-hero-text">
                        <?= __('Manage trucks, storage units, equipment, inventory, and current job resource assignments.') ?>
                    </p>
                </div>
            </div>
        </div>
    </section>

    <section class="admin-section">
        <div class="container">
            <div class="row g-4">

                <div class="col-md-6 col-xl-3">
                    <div class="admin-table-card h-100">
                        <div class="admin-table-header">
                            <h2><?= __('Trucks') ?></h2>
                        </div>
                        <div class="p-3">
                            <p><strong><?= __('Total:') ?></strong> <?= h($truckCount) ?></p>
                            <p><strong><?= __('Available:') ?></strong> <?= h($availableTruckCount) ?></p>
                            <div class="d-flex gap-2 flex-wrap">
                                <?= $this->Html->link(__('View Trucks'), ['controller' => 'Trucks', 'action' => 'index'], ['class' => 'btn btn-outline-primary btn-sm']) ?>
                                <?= $this->Html->link(__('Add Truck'), ['controller' => 'Trucks', 'action' => 'add'], ['class' => 'btn btn-primary btn-sm']) ?>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-6 col-xl-3">
                    <div class="admin-table-card h-100">
                        <div class="admin-table-header">
                            <h2><?= __('Storage Units') ?></h2>
                        </div>
                        <div class="p-3">
                            <p><strong><?= __('Total:') ?></strong> <?= h($storageUnitCount) ?></p>
                            <p><strong><?= __('Available:') ?></strong> <?= h($availableStorageUnitCount) ?></p>
                            <div class="d-flex gap-2 flex-wrap">
                                <?= $this->Html->link(__('View Storage'), ['controller' => 'StorageUnits', 'action' => 'index'], ['class' => 'btn btn-outline-primary btn-sm']) ?>
                                <?= $this->Html->link(__('Add Storage Unit'), ['controller' => 'StorageUnits', 'action' => 'add'], ['class' => 'btn btn-primary btn-sm']) ?>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-6 col-xl-3">
                    <div class="admin-table-card h-100">
                        <div class="admin-table-header">
                            <h2><?= __('Equipment') ?></h2>
                        </div>
                        <div class="p-3">
                            <p><strong><?= __('Total:') ?></strong> <?= h($equipmentCount) ?></p>
                            <p><strong><?= __('Available:') ?></strong> <?= h($availableEquipmentCount) ?></p>
                            <div class="d-flex gap-2 flex-wrap">
                                <?= $this->Html->link(__('View Equipment'), ['controller' => 'Equipment', 'action' => 'index'], ['class' => 'btn btn-outline-primary btn-sm']) ?>
                                <?= $this->Html->link(__('Add Equipment'), ['controller' => 'Equipment', 'action' => 'add'], ['class' => 'btn btn-primary btn-sm']) ?>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-6 col-xl-3">
                    <div class="admin-table-card h-100">
                        <div class="admin-table-header">
                            <h2><?= __('Inventory') ?></h2>
                        </div>
                        <div class="p-3">
                            <p><strong><?= __('Items:') ?></strong> <?= h($inventoryItemCount) ?></p>
                            <p><strong><?= __('Low Stock:') ?></strong> <?= h($lowStockCount) ?></p>
                            <div class="d-flex gap-2 flex-wrap">
                                <?= $this->Html->link(__('View Inventory'), ['controller' => 'InventoryItems', 'action' => 'index'], ['class' => 'btn btn-outline-primary btn-sm']) ?>
                                <?= $this->Html->link(__('Add Inventory Item'), ['controller' => 'InventoryItems', 'action' => 'add'], ['class' => 'btn btn-primary btn-sm']) ?>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-12">
                    <div class="admin-table-card">
                        <div class="admin-table-header d-flex justify-content-between align-items-center">
                            <h2><?= __('Quick Overview') ?></h2>
                            <?= $this->Html->link(
                                __('View Assignments'),
                                ['controller' => 'JobResources', 'action' => 'index'],
                                ['class' => 'btn btn-outline-primary btn-sm']
                            ) ?>
                        </div>
                        <div class="p-3">
                            <div class="row g-3">
                                <div class="col-md-4">
                                    <div class="border rounded p-3 h-100">
                                        <strong><?= __('Available Trucks') ?></strong>
                                        <div><?= h($availableTruckCount) ?></div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="border rounded p-3 h-100">
                                        <strong><?= __('Available Storage Units') ?></strong>
                                        <div><?= h($availableStorageUnitCount) ?></div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="border rounded p-3 h-100">
                                        <strong><?= __('Active Assignments') ?></strong>
                                        <div><?= h($activeAssignmentCount) ?></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-12">
                    <div class="admin-table-card">
                        <div class="admin-table-header d-flex justify-content-between align-items-center">
                            <h2><?= __('Trucks Preview') ?></h2>
                            <?= $this->Html->link(__('View All'), ['controller' => 'Trucks', 'action' => 'index'], ['class' => 'btn btn-outline-primary btn-sm']) ?>
                        </div>
                        <div class="table-responsive">
                            <table class="table admin-table mb-0">
                                <thead>
                                <tr>
                                    <th><?= __('Name') ?></th>
                                    <th><?= __('Rego') ?></th>
                                    <th><?= __('Size') ?></th>
                                    <th><?= __('Status') ?></th>
                                    <th><?= __('Location') ?></th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php if ($trucks->isEmpty()): ?>
                                    <tr>
                                        <td colspan="5"><?= __('No trucks found.') ?></td>
                                    </tr>
                                <?php else: ?>
                                    <?php foreach ($trucks as $truck): ?>
                                        <tr>
                                            <td><?= h($truck->name) ?></td>
                                            <td><?= h($truck->rego) ?></td>
                                            <td><?= h($truck->truck_size) ?></td>
                                            <td><?= h(ucfirst((string)$truck->status)) ?></td>
                                            <td><?= h($truck->current_location) ?></td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <div class="col-12">
                    <div class="admin-table-card">
                        <div class="admin-table-header d-flex justify-content-between align-items-center">
                            <h2><?= __('Storage Units Preview') ?></h2>
                            <?= $this->Html->link(__('View All'), ['controller' => 'StorageUnits', 'action' => 'index'], ['class' => 'btn btn-outline-primary btn-sm']) ?>
                        </div>
                        <div class="table-responsive">
                            <table class="table admin-table mb-0">
                                <thead>
                                <tr>
                                    <th><?= __('Unit Code') ?></th>
                                    <th><?= __('Facility') ?></th>
                                    <th><?= __('Size (m³)') ?></th>
                                    <th><?= __('Status') ?></th>
                                    <th><?= __('Security') ?></th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php if ($storageUnits->isEmpty()): ?>
                                    <tr>
                                        <td colspan="5"><?= __('No storage units found.') ?></td>
                                    </tr>
                                <?php else: ?>
                                    <?php foreach ($storageUnits as $unit): ?>
                                        <tr>
                                            <td><?= h($unit->unit_code) ?></td>
                                            <td><?= h($unit->facility_name) ?></td>
                                            <td><?= h($unit->unit_size_m3) ?></td>
                                            <td><?= h(ucfirst((string)$unit->status)) ?></td>
                                            <td><?= h($unit->security_level) ?></td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <div class="col-12 col-xl-6">
                    <div class="admin-table-card h-100">
                        <div class="admin-table-header d-flex justify-content-between align-items-center">
                            <h2><?= __('Equipment Preview') ?></h2>
                            <?= $this->Html->link(__('View All'), ['controller' => 'Equipment', 'action' => 'index'], ['class' => 'btn btn-outline-primary btn-sm']) ?>
                        </div>
                        <div class="table-responsive">
                            <table class="table admin-table mb-0">
                                <thead>
                                <tr>
                                    <th><?= __('Name') ?></th>
                                    <th><?= __('Category') ?></th>
                                    <th><?= __('Qty Available') ?></th>
                                    <th><?= __('Status') ?></th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php if ($equipment->isEmpty()): ?>
                                    <tr>
                                        <td colspan="4"><?= __('No equipment found.') ?></td>
                                    </tr>
                                <?php else: ?>
                                    <?php foreach ($equipment as $item): ?>
                                        <tr>
                                            <td><?= h($item->name) ?></td>
                                            <td><?= h($item->category) ?></td>
                                            <td><?= h($item->quantity_available) ?></td>
                                            <td><?= h(ucfirst((string)$item->status)) ?></td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <div class="col-12 col-xl-6">
                    <div class="admin-table-card h-100">
                        <div class="admin-table-header d-flex justify-content-between align-items-center">
                            <h2><?= __('Inventory Preview') ?></h2>
                            <?= $this->Html->link(__('View All'), ['controller' => 'InventoryItems', 'action' => 'index'], ['class' => 'btn btn-outline-primary btn-sm']) ?>
                        </div>
                        <div class="table-responsive">
                            <table class="table admin-table mb-0">
                                <thead>
                                <tr>
                                    <th><?= __('Name') ?></th>
                                    <th><?= __('Category') ?></th>
                                    <th><?= __('On Hand') ?></th>
                                    <th><?= __('Reorder Threshold') ?></th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php if ($inventoryItems->isEmpty()): ?>
                                    <tr>
                                        <td colspan="4"><?= __('No inventory items found.') ?></td>
                                    </tr>
                                <?php else: ?>
                                    <?php foreach ($inventoryItems as $item): ?>
                                        <tr>
                                            <td><?= h($item->name) ?></td>
                                            <td><?= h($item->category) ?></td>
                                            <td><?= h($item->quantity_on_hand) ?></td>
                                            <td><?= h($item->reorder_threshold) ?></td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <div class="col-12">
                    <div class="admin-table-card">
                        <div class="admin-table-header d-flex justify-content-between align-items-center">
                            <div>
                                <h2><?= __('Recent Resource Assignments') ?></h2>
                                <p><?= __('Latest jobs with assigned trucks, equipment, storage units, and inventory items.') ?></p>
                            </div>

                            <?= $this->Html->link(
                                __('Manage Assignments'),
                                ['controller' => 'JobResources', 'action' => 'index'],
                                ['class' => 'btn btn-outline-primary btn-sm']
                            ) ?>
                        </div>

                        <div class="table-responsive">
                            <table class="table admin-table mb-0">
                                <thead>
                                <tr>
                                    <th><?= __('Job') ?></th>
                                    <th><?= __('Customer') ?></th>
                                    <th><?= __('Service Type') ?></th>
                                    <th><?= __('Job Date') ?></th>
                                    <th><?= __('Trucks') ?></th>
                                    <th><?= __('Equipment') ?></th>
                                    <th><?= __('Storage Units') ?></th>
                                    <th><?= __('Inventory Items') ?></th>
                                    <th class="actions"><?= __('Actions') ?></th>
                                </tr>
                                </thead>

                                <tbody>
                                <?php if (empty($recentAssignments)): ?>
                                    <tr>
                                        <td colspan="9"><?= __('No recent resource assignments found.') ?></td>
                                    </tr>
                                <?php else: ?>
                                    <?php foreach (array_slice($recentAssignments, 0, 3) as $assignment): ?>
                                        <?php
                                        $job = $assignment['job'] ?? null;

                                        $jobId = $assignment['job_id'] ?? null;
                                        $jobLabel = $jobId ? __('Job #{0}', $jobId) : __('Unknown Job');

                                        $customerName = '-';
                                        $serviceType = '-';
                                        $jobDate = '-';

                                        if ($job) {
                                            if ($job->hasValue('customer')) {
                                                $customerName = trim(
                                                    ($job->customer->first_name ?? '') . ' ' .
                                                    ($job->customer->last_name ?? '')
                                                );

                                                if ($customerName === '') {
                                                    $customerName = '-';
                                                }
                                            }

                                            if ($job->hasValue('job_type')) {
                                                $serviceType = $job->job_type->job_type_name ?? '-';
                                            }

                                            $jobDate = $job->job_date ?? '-';
                                        }
                                        ?>

                                        <tr>
                                            <td>
                                                <?php if ($jobId): ?>
                                                    <?= $this->Html->link(
                                                        $jobLabel,
                                                        ['controller' => 'Jobs', 'action' => 'view', $jobId],
                                                        ['class' => 'admin-action-link']
                                                    ) ?>
                                                <?php else: ?>
                                                    <?= h($jobLabel) ?>
                                                <?php endif; ?>
                                            </td>

                                            <td><?= h($customerName) ?></td>
                                            <td><?= h($serviceType) ?></td>
                                            <td><?= h($jobDate) ?></td>

                                            <td>
                                <span class="admin-status-badge">
                                    <?= h($assignment['truck_count'] ?? 0) ?>
                                </span>
                                            </td>

                                            <td>
                                <span class="admin-status-badge">
                                    <?= h($assignment['equipment_count'] ?? 0) ?>
                                </span>
                                            </td>

                                            <td>
                                <span class="admin-status-badge">
                                    <?= h($assignment['storage_unit_count'] ?? 0) ?>
                                </span>
                                            </td>

                                            <td>
                                <span class="admin-status-badge">
                                    <?= h($assignment['inventory_count'] ?? 0) ?>
                                </span>
                                            </td>

                                            <td class="actions">
                                                <div class="admin-action-stack">
                                                    <?php if ($jobId): ?>
                                                        <?= $this->Html->link(
                                                            __('View Resources'),
                                                            ['controller' => 'JobResources', 'action' => 'view', $jobId],
                                                            ['class' => 'admin-action-link']
                                                        ) ?>
                                                    <?php endif; ?>
                                                </div>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>
</div>
