<?php

/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Job $job
 * @var \App\Model\Entity\StaffJob $staffJob
 */
?>

<div class="mh-page-soft">
    <section class="admin-hero">
        <div class="container">
            <div class="admin-hero-shell">
                <div class="admin-hero-content">
                    <span class="admin-eyebrow"><?= __('Staff') ?></span>
                    <h1><?= __('Submit Job Report') ?></h1>
                    <p class="admin-hero-text">
                        <?= __('Confirm the job outcome and add any extra information for the admin team.') ?>
                    </p>
                </div>
            </div>
        </div>
    </section>

    <section class="admin-section">
        <div class="container">
            <div class="mh-back-btn m-1">
                <?= $this->Html->link(__('← Back to Job Details'), ['action' => 'view', $job->job_id]) ?>
            </div>

            <div class="row g-4 align-items-start">
                <div class="col-lg-4">
                    <div class="booking-info-stack">
                        <div class="mh-info-card">
                            <div>
                                <h3><?= __('Job #') . h($job->job_id) ?></h3>
                                <p><?= h($job->description) ?></p>
                            </div>
                        </div>

                        <div class="mh-info-card">
                            <div>
                                <h3><?= __('Pickup') ?></h3>
                                <p><?= h($job->pickup_address) ?></p>
                            </div>
                        </div>

                        <div class="mh-info-card">
                            <div>
                                <h3><?= __('Dropoff') ?></h3>
                                <p><?= h($job->dropoff_address) ?></p>
                            </div>
                        </div>

                        <div class="mh-info-card">
                            <div>
                                <h3><?= __('Date / Time') ?></h3>
                                <p><?= h($job->job_date) ?> <?= h($job->job_time) ?></p>
                            </div>
                        </div>

                        <div class="mh-info-card">
                            <div>
                                <h3><?= __('Current Status') ?></h3>
                                <p>
                                    <span class="admin-role-badge">
                                        <?= h($job->status) ?>
                                    </span>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-8">
                    <div class="mh-form-card">
                        <div class="booking-form-header">
                            <h2><?= __('Job Outcome') ?></h2>
                            <p><?= __('Select whether the job was completed or incomplete, then add any extra notes if needed.') ?></p>
                        </div>

                        <?= $this->Form->create($staffJob, ['class' => 'booking-form']) ?>

                        <div class="row g-3">
                            <div class="col-12">
                                <label class="fw-bold mb-2 d-block">
                                    <?= __('Outcome') ?>
                                </label>

                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <label class="mh-info-card h-100" style="cursor: pointer;">
                                            <?= $this->Form->radio('report_outcome', [
                                                ['value' => 'Completed', 'text' => __('Job Completed')],
                                            ], [
                                                'value' => $staffJob->report_outcome ?? 'Completed',
                                                'required' => true,
                                                'hiddenField' => false,
                                            ]) ?>
                                        </label>
                                    </div>

                                    <div class="col-md-6">
                                        <label class="mh-info-card h-100" style="cursor: pointer;">
                                            <?= $this->Form->radio('report_outcome', [
                                                ['value' => 'Incomplete', 'text' => __('Job Incomplete')],
                                            ], [
                                                'value' => $staffJob->report_outcome ?? 'Completed',
                                                'required' => true,
                                                'hiddenField' => false,
                                            ]) ?>
                                        </label>
                                    </div>
                                </div>
                            </div>

                            <div class="col-12">
                                <?= $this->Form->control('report_notes', [
                                    'type' => 'textarea',
                                    'label' => 'Extra Information',
                                    'placeholder' => 'Add any notes about the job, issues, delays, damages, customer comments, or incomplete work.',
                                    'rows' => 6,
                                    'value' => $staffJob->report_notes ?? '',
                                    'class' => 'booking-input',
                                    'templates' => [
                                        'inputContainer' => '<div class="input booking-form-group {{type}}{{required}}">{{content}}</div>',
                                    ],
                                ]) ?>
                            </div>
                        </div>

                        <div class="booking-form-actions">
                            <?= $this->Form->button(__('Submit Report'), [
                                'class' => 'mh-btn-primary',
                            ]) ?>
                        </div>

                        <?= $this->Form->end() ?>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
