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
                    <h1><?= __('Edit Storage Unit') ?></h1>
                    <p class="admin-hero-text">
                        <?= __('Update this storage unit’s facility, size, availability, and security details.') ?>
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
                            <p><?= __('Manage this storage unit record.') ?></p>
                        </div>

                        <div class="admin-action-stack">
                            <?= $this->Html->link(__('List Storage Units'), ['action' => 'index'], ['class' => 'admin-action-link']) ?>

                            <?= $this->Form->postLink(
                                __('Delete Storage Unit'),
                                ['action' => 'delete', $storageUnit->storage_unit_id],
                                [
                                    'confirm' => __('Are you sure you want to delete # {0}?', $storageUnit->storage_unit_id),
                                    'class' => 'admin-action-link admin-action-danger'
                                ]
                            ) ?>
                        </div>
                    </div>
                </div>

                <div class="col-lg-9">
                    <div class="auth-card auth-card-wide">
                        <div class="auth-header">
                            <h2 class="auth-title"><?= __('Storage Unit Details') ?></h2>
                            <p class="auth-subtitle">
                                <?= __('Edit the details below and save changes to update this storage unit.') ?>
                            </p>
                        </div>

                        <?= $this->Form->create($storageUnit, ['class' => 'auth-form']) ?>

                        <div class="row g-3">
                            <div class="col-md-6 auth-form-group">
                                <?= $this->Form->control('unit_code', [
                                    'label' => 'Unit Code',
                                    'placeholder' => 'Enter unit code',
                                    'class' => 'auth-input',
                                ]) ?>
                            </div>

                            <div class="col-md-6 auth-form-group">
                                <?= $this->Form->control('facility_name', [
                                    'label' => 'Facility Name',
                                    'placeholder' => 'Enter facility name',
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
                                <?= $this->Form->control('status', [
                                    'label' => 'Status',
                                    'placeholder' => 'Enter unit status',
                                    'class' => 'auth-input',
                                ]) ?>
                            </div>

                            <div class="col-md-6 auth-form-group">
                                <?= $this->Form->control('security_level', [
                                    'label' => 'Security Level',
                                    'placeholder' => 'Enter security level',
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
