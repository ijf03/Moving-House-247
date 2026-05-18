<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\InventoryItem $inventoryItem
 */
?>

<div class="mh-page-soft">
    <section class="admin-hero">
        <div class="container">
            <div class="admin-hero-shell">
                <div class="admin-hero-content">
                    <span class="admin-eyebrow"><?= __('Resources') ?></span>
                    <h1><?= __('Add Inventory Item') ?></h1>
                    <p class="admin-hero-text">
                        <?= __('Create a new inventory item and record its stock level, category, unit, and storage location.') ?>
                    </p>
                </div>
            </div>
        </div>
    </section>

    <section class="admin-section">
        <div class="container">
            <div class="row g-4 justify-content-center">
                <div class="col-lg-3">
                    <div class="admin-table-card">
                        <div class="admin-table-header">
                            <h2><?= __('Actions') ?></h2>
                            <p><?= __('Quick links for inventory management.') ?></p>
                        </div>

                        <div class="admin-action-stack">
                            <?= $this->Html->link(__('List Inventory Items'), ['action' => 'index'], ['class' => 'admin-action-link']) ?>
                        </div>
                    </div>
                </div>

                <div class="col-lg-9">
                    <div class="auth-card auth-card-wide">
                        <div class="auth-header">
                            <h2 class="auth-title"><?= __('Inventory Item Details') ?></h2>

                            <div class="d-flex justify-content-center mt-5 mb-5">
                                <p class="auth-subtitle text-center">
                                    <?= __('Fill in the details below to add a new inventory item to the system.') ?>
                                </p>
                            </div>
                        </div>

                        <?= $this->Form->create($inventoryItem, ['class' => 'auth-form']) ?>

                        <div class="row g-3">
                            <div class="col-md-6 auth-form-group">
                                <?= $this->Form->control('name', [
                                    'label' => 'Item Name',
                                    'placeholder' => 'Enter item name',
                                    'class' => 'auth-input',
                                ]) ?>
                            </div>

                            <div class="col-md-6 auth-form-group">
                                <?= $this->Form->control('category', [
                                    'type' => 'select',
                                    'label' => 'Category',
                                    'options' => $categoryOptions,
                                    'empty' => 'Select category',
                                    'class' => 'auth-input',
                                ]) ?>
                            </div>

                            <div class="col-md-6 auth-form-group">
                                <?= $this->Form->control('quantity_on_hand', [
                                    'type' => 'number',
                                    'label' => 'Quantity On Hand',
                                    'placeholder' => 'Enter current quantity',
                                    'class' => 'auth-input',
                                    'min' => '0',
                                    'step' => '1',
                                ]) ?>
                            </div>

                            <div class="col-md-6 auth-form-group">
                                <?= $this->Form->control('reorder_threshold', [
                                    'type' => 'number',
                                    'label' => 'Reorder Threshold',
                                    'placeholder' => 'Enter reorder threshold',
                                    'class' => 'auth-input',
                                    'min' => '0',
                                    'step' => '1',
                                ]) ?>
                            </div>

                            <div class="col-md-6 auth-form-group">
                                <?= $this->Form->control('unit', [
                                    'label' => 'Unit',
                                    'placeholder' => 'Enter unit type',
                                    'class' => 'auth-input',
                                ]) ?>
                            </div>

                            <div class="col-md-6 auth-form-group">
                                <?= $this->Form->control('storage_location', [
                                    'type' => 'select',
                                    'label' => 'Storage Location',
                                    'options' => $storageLocationOptions,
                                    'empty' => 'Select storage location',
                                    'class' => 'auth-input',
                                ]) ?>
                            </div>

                            <div class="col-md-6 auth-form-group">
                                <?= $this->Form->control('is_active', [
                                    'type' => 'select',
                                    'label' => 'Active',
                                    'options' => [
                                        1 => 'Yes',
                                        0 => 'No',
                                    ],
                                    'empty' => false,
                                    'default' => 1,
                                    'class' => 'auth-input',
                                ]) ?>
                            </div>
                        </div>

                        <div class="auth-form-actions">
                            <?= $this->Form->button(__('Create Inventory Item'), ['class' => 'mh-btn-primary']) ?>
                        </div>

                        <?= $this->Form->end() ?>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
