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
                    <h1><?= __('Edit Equipment') ?></h1>
                    <p class="admin-hero-text">
                        <?= __('Update this equipment record’s quantity, status, location, and condition notes.') ?>
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
                            <p><?= __('Manage this equipment record.') ?></p>
                        </div>

                        <div class="admin-action-stack">
                            <?= $this->Html->link(__('List Equipment'), ['action' => 'index'], ['class' => 'admin-action-link']) ?>

                            <?= $this->Form->postLink(
                                __('Delete Equipment'),
                                ['action' => 'delete', $equipmentEntity->equipment_id],
                                [
                                    'confirm' => __('Are you sure you want to delete # {0}?', $equipmentEntity->equipment_id),
                                    'class' => 'admin-action-link admin-action-link-danger',
                                ]
                            ) ?>
                        </div>
                    </div>
                </div>

                <div class="col-lg-9">
                    <div class="auth-card auth-card-wide">
                        <div class="auth-header">
                            <h2 class="auth-title"><?= __('Equipment Details') ?></h2>
                            <p class="auth-subtitle">
                                <?= __('Edit the details below and save changes to update this equipment item.') ?>
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
                            <?= $this->Form->button(__('Save Changes'), ['class' => 'mh-btn-primary']) ?>
                        </div>

                        <?= $this->Form->end() ?>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
