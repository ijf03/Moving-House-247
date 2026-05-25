<?php
/**
 * @var \App\View\AppView $this
 * @var iterable<\App\Model\Entity\StaffJob> $staffJobs
 */
?>

<div class="mh-page-soft">
    <section class="admin-hero">
        <div class="container">
            <div class="admin-hero-shell">
                <div class="admin-hero-content">
                    <span class="admin-eyebrow"><?= __('Staff') ?></span>
                    <h1><?= __('My Jobs') ?></h1>
                    <p class="admin-hero-text">
                        <?= __('View jobs you have chosen and monitor their current progress.') ?>
                    </p>
                </div>
            </div>
        </div>
    </section>

    <section class="admin-section">
        <div class="container">
            <div class="mh-back-btn m-1">
                <?= $this->Html->link(__('← Available Jobs'), ['action' => 'available']) ?>
            </div>

            <?php if ($staffJobs->isEmpty()): ?>
                <div class="admin-table-card">
                    <div class="admin-table-header">
                        <h2><?= __('No jobs selected yet.') ?></h2>
                        <p><?= __('Jobs you take will appear here.') ?></p>
                    </div>
                </div>
            <?php else: ?>
                <div class="row g-4">
                    <?php foreach ($staffJobs as $staffJob): ?>
                        <?php $job = $staffJob->job; ?>

                        <div class="col-lg-6">
                            <div class="admin-table-card h-100">
                                <div class="admin-table-header">
                                    <h2><?= __('Job #') . h($job->job_id ?? '') ?></h2>
                                    <p><?= h($job->description ?? '') ?></p>
                                </div>

                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <div class="mh-info-card">
                                            <div>
                                                <h3><?= __('Pickup') ?></h3>
                                                <p><?= h($job->pickup_address ?? '') ?></p>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="mh-info-card">
                                            <div>
                                                <h3><?= __('Dropoff') ?></h3>
                                                <p><?= h($job->dropoff_address ?? '') ?></p>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="mh-info-card">
                                            <div>
                                                <h3><?= __('Date / Time') ?></h3>
                                                <p><?= h($job->job_date?->format('d/m/Y')  ?? '') ?> <?= h($job->job_time ?? '') ?></p>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="mh-info-card">
                                            <div>
                                                <h3><?= __('Staff') ?></h3>
                                                <p>
                                                    <strong><?= __('Drivers:') ?></strong>
                                                    <?= h($staffJob->driver_count ?? 0) ?> / <?= h($staffJob->job->driver_required ?? 0) ?>
                                                </p>
                                                <p>
                                                    <strong><?= __('Porters:') ?></strong>
                                                    <?= h($staffJob->porter_count ?? 0) ?> / <?= h($staffJob->job->porter_required ?? 0) ?>
                                                </p>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="mh-info-card">
                                            <div>
                                                <h3><?= __('Status') ?></h3>
                                                <p>
                                                    <span class="admin-role-badge">
                                                        <?= h($job->status ?? '') ?>
                                                    </span>
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="admin-action-stack mt-3">
                                    <?= $this->Html->link(
                                        __('View Job'),
                                        ['action' => 'view', $job->job_id],
                                        [
                                            'class' => 'admin-action-link mx-auto text-center',
                                            'style' => 'display: block; width: 160px;'
                                        ]
                                    ) ?>

                                    <?php if (($job->status ?? '') === 'Ready' && empty($staffJob->report_submitted_at)): ?>
                                        <?= $this->Html->link(
                                            __('Submit Report'),
                                            ['action' => 'report', $job->job_id],
                                            [
                                                'class' => 'admin-action-link mx-auto text-center mt-2',
                                                'style' => 'display: block; width: 160px;'
                                            ]
                                        ) ?>
                                    <?php elseif (!empty($staffJob->report_submitted_at)): ?>
                                        <p class="text-center mt-2 mb-0">
                                            <?= __('Report Submitted') ?>
                                        </p>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>
    </section>
</div>
