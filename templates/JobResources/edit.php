<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\JobResource $jobResource
 * @var string[]|\Cake\Collection\CollectionInterface $jobs
 */
?>

<div class="mh-page-soft">
    <section class="admin-hero">
        <div class="container">
            <div class="admin-hero-shell">
                <div class="admin-hero-content">
                    <span class="admin-eyebrow"><?= __('Admin') ?></span>
                    <h1><?= __('Edit Job Resource') ?></h1>
                    <p class="admin-hero-text">
                        <?= __('Update the allocated resource details for this job.') ?>
                    </p>
                </div>
            </div>
        </div>
    </section>

    <section class="admin-section">
        <div class="container">
            <div class="row g-4 align-items-start">
                <div class="col-lg-3">
                    <div class="mh-back-btn m-1">
                        <?= $this->Html->link(__('← Back to List'), ['action' => 'index']) ?>
                    </div>
                    <div class="mh-form-card">
                        <div class="admin-table-header">
                            <h2><?= __('Actions') ?></h2>
                        </div>

                        <div class="admin-action-stack">
                            <?= $this->Form->postLink(
                                __('Delete'),
                                ['action' => 'delete', $jobResource->job_resource_id],
                                [
                                    'confirm' => __('Are you sure you want to delete # {0}?', $jobResource->job_resource_id),
                                    'class' => 'admin-action-link admin-action-link-danger'
                                ]
                            ) ?>
                        </div>
                    </div>
                </div>

                <div class="col-lg-9">
                    <div class="mh-form-card">
                        <div class="admin-table-header">
                            <h2><?= __('Resource Details') ?></h2>
                            <p><?= __('Review and update the job resource information below.') ?></p>
                        </div>

                        <?= $this->Form->create($jobResource, ['class' => 'mh-form']) ?>

                        <div class="row g-3">
                            <div class="col-md-6">
                                <?= $this->Form->control('job_id', [
                                    'options' => $jobs,
                                    'empty' => true,
                                    'label' => 'Job'
                                ]) ?>
                            </div>

                            <div class="col-md-6">
                                <?= $this->Form->control('resource_type', [
                                    'label' => 'Resource Type'
                                ]) ?>
                            </div>

                            <div class="col-md-6">
                                <?= $this->Form->control('resource_id', [
                                    'label' => 'Resource ID'
                                ]) ?>
                            </div>

                            <div class="col-md-6">
                                <?= $this->Form->control('quantity', [
                                    'label' => 'Quantity'
                                ]) ?>
                            </div>

                            <div class="col-12">
                                <?= $this->Form->control('notes', [
                                    'label' => 'Notes',
                                    'rows' => 4
                                ]) ?>
                            </div>
                        </div>

                        <div class="mt-4">
                            <?= $this->Form->button(__('Save Changes'), [
                                'class' => 'mh-btn-primary'
                            ]) ?>
                        </div>

                        <?= $this->Form->end() ?>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
