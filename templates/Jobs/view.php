<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Job $job
 * @var \App\Model\Entity\StaffJob|null $staffJob
 */

$identity = $this->request->getAttribute('identity');
$role = $identity ? (int)$identity->get('user_type') : null;

$isAdmin = $role === 1;
$isStaff = $role === 2;
$isDriver = $isDriver ?? false;

$jobReports = $jobReports ?? new \Cake\Collection\Collection([]);
$assignedStaff = $assignedStaff ?? new \Cake\Collection\Collection([]);

?>

<div class="mh-page-soft">
    <section class="admin-section">
        <div class="container">
            <div class="row g-4 align-items-start">

                <div class="col-lg-3">
                    <div class="mh-back-btn m-1">
                        <?= $this->Html->link(
                            __('← Back to List'),
                            ['action' => $isStaff ? 'available' : 'index']
                        ) ?>
                    </div>

                    <?php if ($isAdmin): ?>
                        <div class="admin-table-card mt-3">
                            <div class="admin-table-header">
                                <h2><?= __('Actions') ?></h2>
                                <p><?= __('Manage this job.') ?></p>
                            </div>

                            <div class="admin-action-stack">
                                <?= $this->Html->link(
                                    __('Edit Job'),
                                    ['action' => 'edit', $job->job_id],
                                    ['class' => 'admin-action-link']
                                ) ?>

                                <?= $this->Form->postLink(
                                    __('Delete Job'),
                                    ['action' => 'delete', $job->job_id],
                                    [
                                        'confirm' => __('Are you sure you want to delete job # {0}?', $job->job_id),
                                        'class' => 'admin-action-link admin-action-link-danger',
                                    ]
                                ) ?>
                            </div>
                        </div>
                    <?php endif; ?>
                </div>

                <div class="col-lg-9">
                    <div class="admin-table-card">
                        <div class="admin-table-header">
                            <h2><?= __('Job #') . h($job->job_id) ?></h2>
                            <p><?= __('Job details and allocation information') ?></p>
                        </div>

                        <div class="row g-3">
                            <div class="col-md-6">
                                <div class="mh-info-card">
                                    <div>
                                        <h3><?= __('Job Type') ?></h3>
                                        <p><?= h($job->job_type->job_type_name ?? '') ?></p>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="mh-info-card">
                                    <div>
                                        <h3><?= __('Status') ?></h3>
                                        <p>
                                            <span class="admin-role-badge">
                                                <?= h($job->status) ?>
                                            </span>
                                        </p>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="mh-info-card">
                                    <div>
                                        <h3><?= __('Pickup Address') ?></h3>
                                        <p><?= h($job->pickup_address) ?></p>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="mh-info-card">
                                    <div>
                                        <h3><?= __('Dropoff Address') ?></h3>
                                        <p><?= h($job->dropoff_address) ?></p>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="mh-info-card">
                                    <div>
                                        <h3><?= __('Date') ?></h3>
                                        <p><?= h($job->job_date) ?></p>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="mh-info-card">
                                    <div>
                                        <h3><?= __('Time') ?></h3>
                                        <p><?= h($job->job_time) ?></p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="admin-table-header" style="margin-top: 2rem;">
                            <h2><?= __('Allocation Information') ?></h2>
                            <p><?= __('Driver, porter, and truck allocation details') ?></p>
                        </div>

                        <div class="row g-3">
                            <div class="col-md-6">
                                <div class="mh-info-card">
                                    <div>
                                        <h3><?= __('Drivers') ?></h3>
                                        <p>
                                            <span class="admin-role-badge">
                                                <?= h($job->driver_count ?? 0) ?> / <?= h($job->driver_required ?? 0) ?>
                                            </span>
                                        </p>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="mh-info-card">
                                    <div>
                                        <h3><?= __('Porters') ?></h3>
                                        <p>
                                            <span class="admin-role-badge">
                                                <?= h($job->porter_count ?? 0) ?> / <?= h($job->porter_required ?? 0) ?>
                                            </span>
                                        </p>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="mh-info-card">
                                    <div>
                                        <h3><?= __('Allocated Trucks') ?></h3>

                                        <?php if (!empty($job->job_trucks)): ?>
                                            <ul>
                                                <?php foreach ($job->job_trucks as $jobTruck): ?>
                                                    <li><?= h($jobTruck->truck->rego ?? 'Unknown Truck') ?></li>
                                                <?php endforeach; ?>
                                            </ul>
                                        <?php else: ?>
                                            <p><?= __('No trucks allocated.') ?></p>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <?php if ($isAdmin): ?>
                            <div class="admin-table-header" style="margin-top: 2rem;">
                                <h2><?= __('Staff Job Report') ?></h2>
                                <p><?= __('Submitted report and all staff assigned to this job') ?></p>
                            </div>

                            <?php if ($jobReports->isEmpty()): ?>
                                <div class="mh-info-card">
                                    <p><?= __('No staff report has been submitted yet.') ?></p>
                                </div>
                            <?php else: ?>
                                <?php foreach ($jobReports as $report): ?>
                                    <?php
                                    $reporterName = trim(
                                        ($report->staff->first_name ?? '') . ' ' .
                                        ($report->staff->last_name ?? '')
                                    );
                                    ?>

                                    <div class="mh-info-card" style="margin-bottom: 1rem;">
                                        <div>
                                            <h3><?= __('Submitted Report') ?></h3>

                                            <p>
                                                <strong><?= __('Submitted By:') ?></strong>
                                                <?= $reporterName !== '' ? h($reporterName) : h($report->staff_id) ?>

                                                <?php if (!empty($report->role)): ?>
                                                    (<?= h($report->role) ?>)
                                                <?php endif; ?>
                                            </p>

                                            <p>
                                                <strong><?= __('Outcome:') ?></strong>
                                                <?= h($report->report_outcome) ?>
                                            </p>

                                            <p>
                                                <strong><?= __('Notes:') ?></strong>
                                                <?= h($report->report_notes ?: 'No extra information provided.') ?>
                                            </p>

                                            <p>
                                                <strong><?= __('Submitted At:') ?></strong>
                                                <?= h($report->report_submitted_at) ?>
                                            </p>
                                        </div>
                                    </div>
                                <?php endforeach; ?>

                                <?php if ($job->status === 'Ready'): ?>
                                    <div class="d-flex justify-content-center mt-4">
                                        <?= $this->Form->postLink(
                                            __('Mark Completed'),
                                            ['action' => 'markCompleted', $job->job_id],
                                            [
                                                'class' => 'admin-action-link admin-action-link-success px-5 py-3 fs-4 text-center',
                                                'confirm' => __('Are you sure you want to mark this job as completed?')
                                            ]
                                        ) ?>
                                    </div>
                                <?php endif; ?>
                            <?php endif; ?>

                            <div class="admin-table-header" style="margin-top: 2rem;">
                                <h2><?= __('Assigned Staff') ?></h2>
                                <p><?= __('Driver and porter assigned to this job') ?></p>
                            </div>

                            <?php if ($assignedStaff->isEmpty()): ?>
                                <div class="mh-info-card">
                                    <p><?= __('No staff have been assigned to this job yet.') ?></p>
                                </div>
                            <?php else: ?>
                                <div class="row g-3">
                                    <?php foreach ($assignedStaff as $allocation): ?>
                                        <?php
                                        $staffName = trim(
                                            ($allocation->staff->first_name ?? '') . ' ' .
                                            ($allocation->staff->last_name ?? '')
                                        );
                                        ?>

                                        <div class="col-md-6">
                                            <div class="mh-info-card h-100">
                                                <div>
                                                    <h3><?= h($allocation->role ?? 'Staff') ?></h3>

                                                    <p>
                                                        <strong><?= __('Name:') ?></strong>
                                                        <?= $staffName !== '' ? h($staffName) : h($allocation->staff_id) ?>
                                                    </p>

                                                    <p>
                                                        <strong><?= __('Email:') ?></strong>
                                                        <?= h($allocation->staff->email ?? '') ?>
                                                    </p>

                                                    <p>
                                                        <strong><?= __('Phone:') ?></strong>
                                                        <?= h($allocation->staff->phone ?? '') ?>
                                                    </p>

                                                    <p>
                                                        <strong><?= __('Report Status:') ?></strong>
                                                        <?= !empty($allocation->report_outcome)
                                                            ? __('Submitted')
                                                            : __('Not Submitted') ?>
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                            <?php endif; ?>
                        <?php endif; ?>

                        <?php if (!empty($job->description)): ?>
                            <div class="admin-table-header" style="margin-top: 2rem;">
                                <h2><?= __('Description') ?></h2>
                                <p><?= __('Additional job information') ?></p>
                            </div>

                            <div class="mh-info-card">
                                <div>
                                    <?= $this->Text->autoParagraph(h($job->description)) ?>
                                </div>
                            </div>
                        <?php endif; ?>

                        <?php if ($isStaff && $job->status === 'Processing' && empty($staffJob)): ?>
                            <div class="admin-table-header" style="margin-top: 2rem;">
                                <h2><?= __('Action') ?></h2>
                            </div>

                            <div class="d-flex justify-content-center gap-4 mt-4">

                                <?php if ($isDriver): ?>
                                    <?= $this->Form->postLink(
                                        __('Accept as Driver'),
                                        ['action' => 'takeJob', $job->job_id, 'Driver'],
                                        [
                                            'class' => 'admin-action-link admin-action-link-success px-5 py-3 fs-4',
                                            'confirm' => __('Accept as driver?')
                                        ]
                                    ) ?>

                                    <?= $this->Form->postLink(
                                        __('Accept as Porter'),
                                        ['action' => 'takeJob', $job->job_id, 'Porter'],
                                        [
                                            'class' => 'admin-action-link admin-action-link-warning px-5 py-3 fs-4',
                                            'confirm' => __('Accept as porter?')
                                        ]
                                    ) ?>
                                <?php else: ?>
                                    <?= $this->Form->postLink(
                                        __('Accept'),
                                        ['action' => 'takeJob', $job->job_id, 'Porter'],
                                        [
                                            'class' => 'admin-action-link admin-action-link-warning px-5 py-3 fs-4',
                                            'confirm' => __('Accept?')
                                        ]
                                    ) ?>
                                <?php endif; ?>
                            </div>

                            <div class="d-flex justify-content-center mt-4">
                                <?= $this->Form->postLink(
                                    __('Reject'),
                                    ['action' => 'notInterested', $job->job_id],
                                    [
                                        'class' => 'admin-action-link admin-action-link-danger px-5 py-3 fs-4',
                                        'confirm' => __('Reject this job?')
                                    ]
                                ) ?>
                            </div>
                        <?php endif; ?>

                        <?php if (
                            $isStaff &&
                            !empty($staffJob) &&
                            $staffJob->status === 'Confirmed' &&
                            $job->status === 'Ready' &&
                            empty($staffJob->report_outcome)
                        ): ?>
                            <div class="admin-table-header" style="margin-top: 2rem;">
                                <h2><?= __('Report') ?></h2>
                                <p><?= __('Submit your job completion report') ?></p>
                            </div>

                            <div class="d-flex justify-content-center mt-4">
                                <?= $this->Html->link(
                                    __('Report Job'),
                                    ['action' => 'report', $job->job_id],
                                    [
                                        'class' => 'admin-action-link px-5 py-3 fs-4 text-center',
                                        'style' => 'display:block; width:280px;'
                                    ]
                                ) ?>
                            </div>
                        <?php endif; ?>

                        <?php if (
                            $isStaff &&
                            !empty($staffJob) &&
                            !empty($staffJob->report_outcome)
                        ): ?>
                            <div class="admin-table-header" style="margin-top: 2rem;">
                                <h2><?= __('Report') ?></h2>
                                <p><?= __('You have already submitted a report for this job.') ?></p>
                            </div>

                            <div class="mh-info-card text-center">
                                <p class="mb-0">
                                    <?= __('Report Submitted') ?>
                                </p>
                            </div>
                        <?php endif; ?>

                    </div>
                </div>

            </div>
        </div>
    </section>
</div>
