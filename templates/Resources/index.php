<?php
/**
 * @var \App\View\AppView $this
 * @var int $truckCount
 * @var int $storageUnitCount
 * @var int $equipmentCount
 * @var int $inventoryItemCount
 * @var int $lowStockCount
 * @var int $activeAssignmentCount
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
                        <?= __('Choose the resource area you want to manage. Each section opens a dedicated page for viewing, adding, editing, and assigning resources.') ?>
                    </p>
                </div>
            </div>
        </div>
    </section>

    <section class="admin-section">
        <div class="container">

            <div class="admin-table-card mb-4">
                <div class="admin-table-header">
                    <h2><?= __('Start Here') ?></h2>
                    <p>
                        <?= __('Use job resource assignments when you need to allocate trucks, equipment, storage, or inventory to an accepted job.') ?>
                    </p>
                </div>

                <div class="row g-4">
                    <div class="col-lg-12">
                        <div class="mh-info-card h-100">
                            <div>
                                <h3><?= __('Job Resource Requirements') ?></h3>

                                <p>
                                    <?= __('Set how many trucks, equipment items, storage units, and inventory items are needed for each accepted job.') ?>
                                </p>

                                <p class="admin-muted-text mt-2">
                                    <?= __('Active assignments:') ?> <?= h($activeAssignmentCount) ?>
                                </p>

                                <?= $this->Html->link(
                                    __('Manage Assignments'),
                                    ['controller' => 'JobResources', 'action' => 'index'],
                                    ['class' => 'admin-primary-link mt-3'],
                                ) ?>
                            </div>
                        </div>
                    </div>


                </div>
            </div>

            <div class="admin-table-card">
                <div class="admin-table-header">
                    <h2><?= __('Manage Resource Categories') ?></h2>
                    <p>
                        <?= __('Select one category to view and maintain its records.') ?>
                    </p>
                </div>

                <div class="row g-4">
                    <div class="col-md-6 col-xl-3">
                        <div class="mh-info-card h-100">
                            <div>
                                <h3><?= __('Trucks') ?></h3>

                                <p>
                                    <?= __('Manage moving trucks used for customer jobs.') ?>
                                </p>

                                <p class="admin-muted-text mt-2">
                                    <?= __('Total trucks:') ?> <?= h($truckCount) ?>
                                </p>

                                <?= $this->Html->link(
                                    __('Manage Trucks'),
                                    ['controller' => 'Trucks', 'action' => 'index'],
                                    ['class' => 'admin-primary-link mt-3'],
                                ) ?>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6 col-xl-3">
                        <div class="mh-info-card h-100">
                            <div>
                                <h3><?= __('Storage Units') ?></h3>

                                <p>
                                    <?= __('Manage storage spaces available for customers.') ?>
                                </p>

                                <p class="admin-muted-text mt-2">
                                    <?= __('Total units:') ?> <?= h($storageUnitCount) ?>
                                </p>

                                <?= $this->Html->link(
                                    __('Manage Storage'),
                                    ['controller' => 'StorageUnits', 'action' => 'index'],
                                    ['class' => 'admin-primary-link mt-3'],
                                ) ?>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6 col-xl-3">
                        <div class="mh-info-card h-100">
                            <div>
                                <h3><?= __('Equipment') ?></h3>

                                <p>
                                    <?= __('Manage tools and equipment needed for moving jobs.') ?>
                                </p>

                                <p class="admin-muted-text mt-2">
                                    <?= __('Total equipment:') ?> <?= h($equipmentCount) ?>
                                </p>

                                <?= $this->Html->link(
                                    __('Manage Equipment'),
                                    ['controller' => 'Equipment', 'action' => 'index'],
                                    ['class' => 'admin-primary-link mt-3'],
                                ) ?>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6 col-xl-3">
                        <div class="mh-info-card h-100">
                            <div>
                                <h3><?= __('Inventory') ?></h3>

                                <p>
                                    <?= __('Track consumable items and stock levels.') ?>
                                </p>

                                <p class="admin-muted-text mt-2 d-flex flex-wrap align-items-center">
                                    <span class="text-nowrap"><?= __('Items:') ?> <?= h($inventoryItemCount) ?></span>
                                    <span class="mx-3 text-muted d-none d-sm-inline">|</span>
                                    <span class="text-nowrap"><?= __('Low stock:') ?> <?= h($lowStockCount) ?></span>
                                </p>

                                <?= $this->Html->link(
                                    __('Manage Inventory'),
                                    ['controller' => 'InventoryItems', 'action' => 'index'],
                                    ['class' => 'admin-primary-link mt-3'],
                                ) ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </section>
</div>
