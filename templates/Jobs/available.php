<?php
/**
 * @var \App\View\AppView $this
 * @var iterable<\App\Model\Entity\Job> $jobs
 */
?>

<div class="mh-page-soft">
    <section class="admin-hero">
        <div class="container">
            <div class="admin-hero-shell">
                <div class="admin-hero-content">
                    <span class="admin-eyebrow"><?= __('Staff') ?></span>
                    <h1><?= __('Available Jobs') ?></h1>
                    <p class="admin-hero-text">
                        <?= __('Review available jobs and choose the work you are interested in taking.') ?>
                    </p>
                </div>
            </div>
        </div>
    </section>

    <section class="admin-section">
        <div class="container">
            <?php if ($jobs->isEmpty()): ?>
                <div class="admin-table-card">
                    <div class="admin-table-header">
                        <h2><?= __('No available jobs found.') ?></h2>
                        <p><?= __('There are currently no jobs ready for staff selection.') ?></p>
                    </div>
                </div>
            <?php else: ?>
                <div class="row g-4">
                    <?php foreach ($jobs as $job): ?>
                        <div class="col-lg-6">
                            <div class="admin-table-card h-100">
                                <div class="admin-table-header">
                                    <h2><?= __('Job #') . h($job->job_id) ?></h2>
                                    <p><?= h($job->description) ?></p>
                                </div>

                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <div class="mh-info-card">
                                            <div>
                                                <h3><?= __('Pickup') ?></h3>
                                                <p><?= h($job->pickup_address) ?></p>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="mh-info-card">
                                            <div>
                                                <h3><?= __('Dropoff') ?></h3>
                                                <p><?= h($job->dropoff_address) ?></p>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="mh-info-card">
                                            <div>
                                                <h3><?= __('Date / Time') ?></h3>
                                                <p><?= h($job->job_date?->format('d/m/Y') ) ?> <?= h($job->job_time) ?></p>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="mh-info-card">
                                            <div>
                                                <h3><?= __('Staff') ?></h3>
                                                <p>
                                                    <strong><?= __('Drivers:') ?></strong>
                                                    <?= h($job->driver_count ?? 0) ?> / <?= h($job->driver_required ?? 0) ?>
                                                </p>
                                                <p>
                                                    <strong><?= __('Porters:') ?></strong>
                                                    <?= h($job->porter_count ?? 0) ?> / <?= h($job->porter_required ?? 0) ?>
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="admin-action-stack mt-3">
                                    <?= $this->Html->link(
                                        __('View'),
                                        ['action' => 'view', $job->job_id],
                                        [
                                            'class' => 'admin-action-link mx-auto text-center',
                                            'style' => 'display: block; width: 160px;'
                                        ]
                                    ) ?>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>
    </section>
</div>
