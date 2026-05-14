<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\JobResource $jobResource
 * @var \App\Model\Entity\Job $job
 * @var int|string $jobId
 * @var \Cake\Collection\CollectionInterface|array $trucks
 * @var \Cake\Collection\CollectionInterface|array $equipment
 * @var \Cake\Collection\CollectionInterface|array $storageUnits
 * @var \Cake\Collection\CollectionInterface|array $inventoryItems
 */

$customerName = '-';
$serviceType = '-';

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

$jobDisplay = 'Job #' . $job->job_id . ' - ' . $customerName . ' - ' . $serviceType;
?>

<div class="mh-page-soft">
    <section class="admin-hero">
        <div class="container">
            <div class="admin-hero-shell">
                <div class="admin-hero-content">
                    <span class="admin-eyebrow"><?= __('Resources') ?></span>
                    <h1><?= __('Add Job Resource') ?></h1>
                    <p class="admin-hero-text">
                        <?= __('Assign a truck, equipment item, storage unit, or inventory item to the selected job.') ?>
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
                            <p><?= __('Manage resources for this job.') ?></p>
                        </div>

                        <div class="admin-action-stack">
                            <?= $this->Html->link(
                                __('Back to Job Resources'),
                                ['action' => 'index'],
                                ['class' => 'admin-action-link']
                            ) ?>

                            <?= $this->Html->link(
                                __('View Job Resources'),
                                ['action' => 'view', $job->job_id],
                                ['class' => 'admin-action-link']
                            ) ?>

                            <?= $this->Html->link(
                                __('View Job'),
                                ['controller' => 'Jobs', 'action' => 'view', $job->job_id],
                                ['class' => 'admin-action-link']
                            ) ?>
                        </div>
                    </div>
                </div>

                <div class="col-lg-9">
                    <div class="auth-card auth-card-wide">
                        <div class="auth-header">
                            <h2 class="auth-title"><?= __('Resource Details') ?></h2>
                            <p class="auth-subtitle">
                                <?= __('Select exactly one resource type for this allocation.') ?>
                            </p>
                        </div>

                        <?= $this->Form->create($jobResource, ['class' => 'auth-form']) ?>

                        <?= $this->Form->hidden('job_id', ['value' => $job->job_id]) ?>

                        <div class="row g-3">

                            <div class="col-md-12 auth-form-group">
                                <?= $this->Form->control('job_display', [
                                    'type' => 'text',
                                    'label' => 'Selected Job',
                                    'value' => $jobDisplay,
                                    'readonly' => true,
                                    'class' => 'auth-input',
                                ]) ?>
                            </div>

                            <div class="col-md-6 auth-form-group">
                                <?= $this->Form->control('quantity', [
                                    'type' => 'number',
                                    'label' => 'Quantity',
                                    'placeholder' => 'Enter quantity',
                                    'class' => 'auth-input',
                                    'min' => '0.01',
                                    'step' => '0.01',
                                    'default' => 1,
                                ]) ?>
                            </div>

                            <div class="col-md-6 auth-form-group">
                                <?= $this->Form->control('truck_id', [
                                    'label' => 'Truck',
                                    'empty' => 'No truck selected',
                                    'options' => $trucks,
                                    'class' => 'auth-input resource-select',
                                    'id' => 'truck-id',
                                ]) ?>
                            </div>

                            <div class="col-md-6 auth-form-group">
                                <?= $this->Form->control('equipment_id', [
                                    'label' => 'Equipment',
                                    'empty' => 'No equipment selected',
                                    'options' => $equipment,
                                    'class' => 'auth-input resource-select',
                                    'id' => 'equipment-id',
                                ]) ?>
                            </div>

                            <div class="col-md-6 auth-form-group">
                                <?= $this->Form->control('storage_unit_id', [
                                    'label' => 'Storage Unit',
                                    'empty' => 'No storage unit selected',
                                    'options' => $storageUnits,
                                    'class' => 'auth-input resource-select',
                                    'id' => 'storage-unit-id',
                                ]) ?>
                            </div>

                            <div class="col-md-6 auth-form-group">
                                <?= $this->Form->control('inventory_id', [
                                    'label' => 'Inventory Item',
                                    'empty' => 'No inventory item selected',
                                    'options' => $inventoryItems,
                                    'class' => 'auth-input resource-select',
                                    'id' => 'inventory-id',
                                ]) ?>
                            </div>

                        </div>

                        <div class="auth-form-actions">
                            <?= $this->Form->button(__('Add Job Resource'), ['class' => 'mh-btn-primary']) ?>
                        </div>

                        <?= $this->Form->end() ?>

                        <script>
                            document.addEventListener('DOMContentLoaded', function () {
                                const selects = document.querySelectorAll('.resource-select');

                                function updateResourceSelects() {
                                    let selectedSelect = null;

                                    selects.forEach(function (select) {
                                        if (select.value !== '') {
                                            selectedSelect = select;
                                        }
                                    });

                                    selects.forEach(function (select) {
                                        if (selectedSelect && select !== selectedSelect) {
                                            select.disabled = true;
                                        } else {
                                            select.disabled = false;
                                        }
                                    });
                                }

                                selects.forEach(function (select) {
                                    select.addEventListener('change', updateResourceSelects);
                                });

                                updateResourceSelects();
                            });
                        </script>
                    </div>
                </div>

            </div>
        </div>
    </section>
</div>
