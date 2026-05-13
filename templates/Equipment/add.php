<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Equipment $equipmentEntity
 */
?>

<div class="mh-page-soft">
    <section class="admin-hero">
        <div class="container">
            <div class="admin-hero-shell">
                <div class="admin-hero-content">
                    <span class="admin-eyebrow"><?= __('Resources') ?></span>
                    <h1><?= __('Add Equipment') ?></h1>
                    <p class="admin-hero-text">
                        <?= __('Create a new equipment record and track its category, quantity, status, location, and condition.') ?>
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
                            <p><?= __('Quick links for equipment management.') ?></p>
                        </div>

                        <div class="admin-action-stack">
                            <?= $this->Html->link(__('List Equipment'), ['action' => 'index'], ['class' => 'admin-action-link']) ?>
                        </div>
                    </div>
                </div>

                <div class="col-lg-9">
                    <div class="auth-card auth-card-wide">
                        <div class="auth-header">
                            <h2 class="auth-title"><?= __('Equipment Details') ?></h2>
                            <p class="auth-subtitle">
                                <?= __('Fill in the details below to add a new equipment item to the system.') ?>
                            </p>
                        </div>

                        <?= $this->Form->create($equipmentEntity, ['class' => 'auth-form']) ?>

                        <div class="row g-3">
                            <div class="col-md-6 auth-form-group">
                                <?= $this->Form->control('name', [
                                    'label' => 'Equipment Name',
                                    'placeholder' => 'Enter equipment name',
                                    'class' => 'auth-input',
                                ]) ?>
                            </div>

                            <div class="col-md-6 auth-form-group">
                                <?= $this->Form->control('category', [
                                    'label' => 'Category',
                                    'placeholder' => 'Enter category',
                                    'class' => 'auth-input',
                                ]) ?>
                            </div>

                            <div class="col-md-6 auth-form-group">
                                <?= $this->Form->control('quantity_available', [
                                    'type' => 'number',
                                    'label' => 'Quantity Available',
                                    'placeholder' => 'Enter quantity available',
                                    'class' => 'auth-input',
                                    'min' => '0',
                                    'step' => '1',
                                ]) ?>
                            </div>

                            <div class="col-md-6 auth-form-group">
                                <?= $this->Form->control('status', [
                                    'label' => 'Status',
                                    'placeholder' => 'Enter status',
                                    'class' => 'auth-input',
                                ]) ?>
                            </div>

                            <div class="col-md-6 auth-form-group">
                                <?= $this->Form->control('storage_location', [
                                    'label' => 'Storage Location',
                                    'placeholder' => 'Enter storage location',
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

                            <div class="col-12 auth-form-group">
                                <?= $this->Form->control('condition_notes', [
                                    'label' => 'Condition Notes',
                                    'placeholder' => 'Enter condition notes',
                                    'class' => 'auth-input',
                                    'rows' => 4,
                                ]) ?>
                            </div>
                        </div>

                        <div class="auth-form-actions">
                            <?= $this->Form->button(__('Create Equipment'), ['class' => 'mh-btn-primary']) ?>
                        </div>

                        <?= $this->Form->end() ?>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
