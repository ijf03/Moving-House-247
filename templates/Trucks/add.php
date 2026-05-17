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
                    <h1><?= __('Add Truck') ?></h1>
                    <p class="admin-hero-text">
                        <?= __('Create a new truck resource and record its capacity, payload, service, and availability details.') ?>
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
                            <p><?= __('Quick links for truck management.') ?></p>
                        </div>

                        <div class="admin-action-stack">
                            <?= $this->Html->link(__('List Trucks'), ['action' => 'index'], ['class' => 'admin-action-link']) ?>
                        </div>
                    </div>
                </div>

                <div class="col-lg-9">
                    <div class="auth-card auth-card-wide">
                        <div class="auth-header">
                            <h2 class="auth-title"><?= __('Truck Details') ?></h2>
                            <p class="auth-subtitle">
                                <?= __('Fill in the details below to add a new truck to the system.') ?>
                            </p>
                        </div>

                        <?= $this->Form->create($truck, ['class' => 'auth-form']) ?>

                        <div class="row g-3">
                            <div class="col-md-6 auth-form-group">
                                <?= $this->Form->control('rego', [
                                    'label' => 'Registration',
                                    'placeholder' => 'Example: 1AB2CD or FB23CA',
                                    'class' => 'auth-input',
                                    'maxlength' => 6,
                                ]) ?>
                            </div>

                            <div class="col-md-6 auth-form-group">
                                <?= $this->Form->control('capacity_m3', [
                                    'type' => 'number',
                                    'label' => 'Capacity (m³)',
                                    'placeholder' => 'Enter capacity',
                                    'class' => 'auth-input',
                                    'min' => '0.01',
                                    'step' => '0.01',
                                ]) ?>
                            </div>

                            <div class="col-md-6 auth-form-group">
                                <?= $this->Form->control('max_payload_kg', [
                                    'type' => 'number',
                                    'label' => 'Max Payload (kg)',
                                    'placeholder' => 'Enter max payload',
                                    'class' => 'auth-input',
                                    'min' => '0.01',
                                    'step' => '0.01',
                                ]) ?>
                            </div>

                            <div class="col-md-6 auth-form-group">
                                <?= $this->Form->control('current_location', [
                                    'type' => 'select',
                                    'label' => 'Current Location',
                                    'options' => $depotOptions,
                                    'empty' => 'Select depot',
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
                                    'default' => 1,
                                    'class' => 'auth-input',
                                ]) ?>
                            </div>
                        </div>

                        <div class="auth-form-actions">
                            <?= $this->Form->button(__('Create Truck'), ['class' => 'mh-btn-primary']) ?>
                        </div>

                        <?= $this->Form->end() ?>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
