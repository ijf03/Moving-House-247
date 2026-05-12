<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Job $job
 */

$identity = $this->request->getAttribute('identity');
$isStaff = $identity && (int)$identity->get('user_type') === 2;
?>

<div class="mh-page-soft">
    <section class="admin-section">
        <div class="container">
            <div class="row g-4 align-items-start">

                <div class="col-lg-3">
                    <div class="mh-back-btn m-1">
                        <?= $this->Html->link(
                            __('← Back'),
                            ['action' => $isStaff ? 'myJobs' : 'index']
                        ) ?>
                    </div>

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
                                            <span class="admin-status-badge admin-status-replied">
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
                            <p><?= __('Resource and staff requirement details') ?></p>
                        </div>

                        <div class="row g-3">
                            <div class="col-md-6">
                                <div class="mh-info-card">
                                    <div>
                                        <h3><?= __('Staff Required') ?></h3>
                                        <p>
                                            <?= count($job->staff_job ?? []) ?> / <?= h($job->staff_required ?? 0) ?>
                                        </p>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="mh-info-card">
                                    <div>
                                        <h3><?= __('Trucks Required') ?></h3>
                                        <p><?= h($job->truck_required ?? 0) ?></p>
                                    </div>
                                </div>
                            </div>

                            <div class="col-12">
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

                            <?php
                            $identity = $this->request->getAttribute('identity');
                            $isStaff = $identity && (int)$identity->get('user_type') === 2;
                            ?>

                            <?php if ($isStaff && $job->status === 'Processing' && empty($staffJob)): ?>
                                <div class="d-flex justify-content-center gap-3 mt-3">
                                    <?= $this->Form->postLink(
                                        __('Accept Job'),
                                        ['action' => 'takeJob', $job->job_id],
                                        [
                                            'class' => 'admin-action-link admin-action-link-success px-4 py-3 fs-5',
                                            'confirm' => __('Are you sure you want to take this job?')
                                        ]
                                    ) ?>

                                    <?= $this->Form->postLink(
                                        __('Reject Job'),
                                        ['action' => 'notInterested', $job->job_id],
                                        [
                                            'class' => 'admin-action-link admin-action-link-danger px-4 py-3 fs-5',
                                            'confirm' => __('Hide this job from your list?')
                                        ]
                                    ) ?>
                                </div>
                            <?php endif; ?>

                            <?php if ($isStaff && !empty($staffJob) && $staffJob->status === 'Confirmed'): ?>
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
                        <?php endif; ?>

                    </div>
                </div>

            </div>
        </div>
    </section>
</div>
