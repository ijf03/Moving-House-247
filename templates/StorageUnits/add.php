<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\StorageUnit $storageUnit
 */
?>

<div class="mh-page-soft">
    <section class="admin-hero">
        <div class="container">
            <div class="admin-hero-shell">
                <div class="admin-hero-content">
                    <span class="admin-eyebrow"><?= __('Resources') ?></span>
                    <h1><?= __('Add Storage Unit') ?></h1>
                    <p class="admin-hero-text">
                        <?= __('Create a new storage unit and record its facility, size, status, and security details.') ?>
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
                            <p><?= __('Quick links for storage unit management.') ?></p>
                        </div>

                        <div class="admin-action-stack">
                            <?= $this->Html->link(__('List Storage Units'), ['action' => 'index'], ['class' => 'admin-action-link']) ?>
                        </div>
                    </div>
                </div>

                <div class="col-lg-9">
                    <div class="auth-card auth-card-wide">
                        <div class="auth-header">
                            <h2 class="auth-title"><?= __('Storage Unit Details') ?></h2>
                            <p class="auth-subtitle">
                                <?= __('Fill in the details below to add a new storage unit to the system.') ?>
                            </p>
                        </div>

                        <?= $this->Form->create($storageUnit, ['class' => 'auth-form']) ?>

                        <div class="row g-3">

                            <div class="col-md-6 auth-form-group">
                                <?= $this->Form->control('facility_name', [
                                    'label' => 'Facility Name',
                                    'placeholder' => 'Enter facility name',
                                    'class' => 'auth-input',
                                ]) ?>
                            </div>

                            <div class="col-md-6 auth-form-group">
                                <?= $this->Form->control('unit_code', [
                                    'label' => 'Unit Code',
                                    'placeholder' => 'Enter unit code',
                                    'class' => 'auth-input',
                                ]) ?>
                            </div>

                            <div class="col-md-6 auth-form-group">
                                <?= $this->Form->control('unit_size_m3', [
                                    'type' => 'number',
                                    'label' => 'Unit Size (m³)',
                                    'placeholder' => 'Enter unit size',
                                    'class' => 'auth-input',
                                    'min' => '0.01',
                                    'step' => '0.01',
                                ]) ?>
                            </div>

                            <div class="col-md-6 auth-form-group">
                                <?= $this->Form->control('security_level', [
                                    'type' => 'select',
                                    'label' => 'Security Level',
                                    'options' => $securityLevelOptions,
                                    'empty' => 'Select security level',
                                    'class' => 'auth-input',
                                ]) ?>
                            </div>

                            <div class="col-md-6 auth-form-group">
                                <?= $this->Form->control('is_climate_controlled', [
                                    'type' => 'select',
                                    'label' => 'Climate Controlled',
                                    'options' => [
                                        1 => 'Yes',
                                        0 => 'No',
                                    ],
                                    'empty' => false,
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
                            <?= $this->Form->button(__('Create Storage Unit'), ['class' => 'mh-btn-primary']) ?>
                        </div>

                        <?= $this->Form->end() ?>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
