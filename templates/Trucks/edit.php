<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Truck $truck
 */
?>

<div class="mh-page-soft">
    <section class="admin-hero">
        <div class="container">
            <div class="admin-hero-shell">
                <div class="admin-hero-content">
                    <span class="admin-eyebrow"><?= __('Resources') ?></span>
                    <h1><?= __('Edit Truck') ?></h1>
                    <p class="admin-hero-text">
                        <?= __('Update this truck’s capacity, payload, location, service, and availability details.') ?>
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
                            <p><?= __('Manage this truck record.') ?></p>
                        </div>

                        <div class="admin-action-stack">
                            <?= $this->Html->link(__('List Trucks'), ['action' => 'index'], ['class' => 'admin-action-link']) ?>

                            <?= $this->Form->postLink(
                                __('Delete Truck'),
                                ['action' => 'delete', $truck->truck_id],
                                [
                                    'confirm' => __('Are you sure you want to delete # {0}?', $truck->truck_id),
                                    'class' => 'admin-action-link admin-action-danger'
                                ]
                            ) ?>
                        </div>
                    </div>
                </div>

                <div class="col-lg-9">
                    <div class="auth-card auth-card-wide">
                        <div class="auth-header">
                            <h2 class="auth-title"><?= __('Truck Details') ?></h2>
                            <p class="auth-subtitle">
                                <?= __('Edit the details below and save changes to update this truck.') ?>
                            </p>
                        </div>

                        <?= $this->Form->create($truck, ['class' => 'auth-form']) ?>

                        <div class="row g-3">
                            <div class="col-md-6 auth-form-group">
                                <?= $this->Form->control('name', [
                                    'label' => 'Truck Name',
                                    'placeholder' => 'Enter truck name',
                                    'class' => 'auth-input',
                                ]) ?>
                            </div>

                            <div class="col-md-6 auth-form-group">
                                <?= $this->Form->control('rego', [
                                    'label' => 'Registration',
                                    'placeholder' => 'Enter registration number',
                                    'class' => 'auth-input',
                                ]) ?>
                            </div>

                            <div class="col-md-6 auth-form-group">
                                <?= $this->Form->control('truck_size', [
                                    'label' => 'Truck Size',
                                    'placeholder' => 'Enter truck size',
                                    'class' => 'auth-input',
                                ]) ?>
                            </div>

                            <div class="col-md-6 auth-form-group">
                                <?= $this->Form->control('capacity_m3', [
                                    'label' => 'Capacity (m³)',
                                    'placeholder' => 'Enter capacity',
                                    'class' => 'auth-input',
                                ]) ?>
                            </div>

                            <div class="col-md-6 auth-form-group">
                                <?= $this->Form->control('max_payload_kg', [
                                    'label' => 'Max Payload (kg)',
                                    'placeholder' => 'Enter max payload',
                                    'class' => 'auth-input',
                                ]) ?>
                            </div>

                            <div class="col-md-6 auth-form-group">
                                <?= $this->Form->control('status', [
                                    'label' => 'Status',
                                    'placeholder' => 'Enter truck status',
                                    'class' => 'auth-input',
                                ]) ?>
                            </div>

                            <div class="col-md-6 auth-form-group">
                                <?= $this->Form->control('current_location', [
                                    'label' => 'Current Location',
                                    'placeholder' => 'Enter current location',
                                    'class' => 'auth-input',
                                ]) ?>
                            </div>

                            <div class="col-md-6 auth-form-group">
                                <?= $this->Form->control('next_service_date', [
                                    'label' => 'Next Service Date',
                                    'empty' => true,
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
                                    'class' => 'auth-input',
                                ]) ?>
                            </div>
                        </div>

                        <div class="auth-form-actions">
                            <?= $this->Form->button(__('Save Changes'), ['class' => 'mh-btn-primary']) ?>
                        </div>

                        <?= $this->Form->end() ?>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
