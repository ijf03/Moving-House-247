<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Job $job
 * @var string[]|\Cake\Collection\CollectionInterface $jobTypes
 * @var string[]|\Cake\Collection\CollectionInterface $customers
 */
?>

<div class="mh-page-soft">
    <section class="admin-hero">
        <div class="container">
            <div class="admin-hero-shell">
                <div class="admin-hero-content">
                    <p class="admin-eyebrow"><?= __('Jobs') ?></p>
                    <h1><?= __('Edit Job') ?></h1>
                    <p class="admin-hero-text">
                        <?= __('Update the job details below.') ?>
                    </p>
                </div>
            </div>
        </div>
    </section>

    <section class="admin-section">
        <div class="container">
            <div class="row g-4 align-items-start">
                <div class="col-lg-3">
                    <div class="mh-form-card">
                        <div class="admin-table-header">
                            <h2><?= __('Actions') ?></h2>
                        </div>

                        <div class="admin-action-stack">
                            <?= $this->Html->link(
                                __('Back to List'),
                                ['action' => 'index'],
                                ['class' => 'admin-action-link']
                            ) ?>

                            <?= $this->Form->postLink(
                                __('Delete'),
                                ['action' => 'delete', $job->job_id],
                                [
                                    'confirm' => __('Are you sure you want to delete # {0}?', $job->job_id),
                                    'class' => 'admin-action-link admin-action-link-danger'
                                ]
                            ) ?>
                        </div>
                    </div>
                </div>

                <div class="col-lg-9">
                    <div class="mh-form-card">
                        <div class="admin-table-header">
                            <h2><?= __('Job Details') ?></h2>
                            <p><?= __('Review and update the moving job information.') ?></p>
                        </div>

                        <?= $this->Form->create($job, ['class' => 'mh-form']) ?>

                        <div class="row g-3">
                            <div class="col-md-6">
                                <?= $this->Form->control('job_type_id', [
                                    'options' => $jobTypes,
                                    'label' => 'Job Type'
                                ]) ?>
                            </div>

                            <div class="col-md-6">
                                <?= $this->Form->control('customer_id', [
                                    'options' => $customers,
                                    'label' => 'Customer'
                                ]) ?>
                            </div>

                            <div class="col-12">
                                <?= $this->Form->control('description', [
                                    'label' => 'Description',
                                    'rows' => 4
                                ]) ?>
                            </div>

                            <div class="col-md-6">
                                <?= $this->Form->control('pickup_address', [
                                    'label' => 'Pickup Address'
                                ]) ?>
                            </div>

                            <div class="col-md-6">
                                <?= $this->Form->control('dropoff_address', [
                                    'label' => 'Drop-off Address'
                                ]) ?>
                            </div>

                            <div class="col-md-6">
                                <?= $this->Form->control('job_date', [
                                    'label' => 'Job Date'
                                ]) ?>
                            </div>

                            <div class="col-md-6">
                                <?= $this->Form->control('job_time', [
                                    'label' => 'Job Time'
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
