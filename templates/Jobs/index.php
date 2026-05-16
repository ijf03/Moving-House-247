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
                    <p class="admin-eyebrow">Admin Dashboard</p>
                    <h1>Job Allocation</h1>
                    <p class="admin-hero-text">
                        Review jobs, monitor allocation progress, and assign required staff and trucks.
                    </p>
                </div>
            </div>
        </div>
    </section>

    <section class="admin-section">
        <div class="container">
            <div class="admin-table-card">
                <div class="admin-table-header admin-table-header-split">
                    <div>
                        <h2>Job Directory</h2>
                        <p>Pending jobs appear first so they can be allocated quickly.</p>
                    </div>
                </div>

                <div class="admin-table-wrap">
                    <table class="admin-table">
                        <thead>
                        <tr>
                            <th><?= $this->Paginator->sort('customer') ?></th>
                            <th><?= $this->Paginator->sort('job_type_id') ?></th>
                            <th><?= $this->Paginator->sort('pickup') ?></th>
                            <th><?= $this->Paginator->sort('dropoff') ?></th>
                            <th><?= $this->Paginator->sort('Details') ?></th>
                            <th><?= $this->Paginator->sort('status') ?></th>
                            <th><?= __('Staff') ?></th>
                            <th class="actions"><?= __('Actions') ?></th>
                        </tr>
                        </thead>

                        <tbody>
                        <?php foreach ($jobs as $job): ?>
                            <tr>
                                <td>
                                    <?= $job->hasValue('customer')
                                        ? h($job->customer->first_name. ' ' . $job->customer->last_name)
                                        : '' ?>
                                </td>
                                <td>
                                    <?= $job->hasValue('job_type')
                                        ? h($job->job_type->job_type_name)
                                        : '' ?>
                                </td>

                                <td><?= h($job->pickup_address) ?></td>
                                <td><?= h($job->dropoff_address) ?></td>
                                <td><?= h($job->job_date) ?> <br> <?= h($job->job_time) ?></td>

                                <td>
                                    <span class="admin-role-badge">
                                        <?= h($job->status) ?>
                                    </span>
                                </td>

                                <td>
                                    <span class="admin-role-badge d-block">
                                        <strong><?= __('Drivers:') ?></strong>
                                        <?= h($job->driver_count ?? 0) ?> / <?= h($job->driver_required ?? 0) ?>
                                        <br>
                                        <strong><?= __('Porters:') ?></strong>
                                        <?= h($job->porter_count ?? 0) ?> / <?= h($job->porter_required ?? 0) ?>
                                    </span>
                                </td>

                                <td class="actions">
                                    <div class="admin-action-stack">
                                        <?= $this->Html->link(
                                            __('View'),
                                            ['action' => 'view', $job->job_id],
                                            ['class' => 'admin-action-link']
                                        ) ?>

                                        <?php if ($job->status === 'Pending'): ?>
                                            <?= $this->Html->link(
                                                __('Edit'),
                                                ['action' => 'edit', $job->job_id],
                                                ['class' => 'admin-action-link']
                                            ) ?>

                                            <?= $this->Form->postLink(
                                                __('Delete'),
                                                ['action' => 'delete', $job->job_id],
                                                [
                                                    'method' => 'delete',
                                                    'confirm' => __('Are you sure you want to delete # {0}?', $job->job_id),
                                                    'class' => 'admin-action-link admin-action-link-danger'
                                                ]
                                            ) ?>

                                            <?= $this->Html->link(
                                                __('Allocate'),
                                                ['action' => 'allocate', $job->job_id],
                                                ['class' => 'admin-action-link']
                                            ) ?>
                                        <?php endif; ?>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>

                <div class="admin-paginator">
                    <ul class="pagination">
                        <?= $this->Paginator->first('<< ' . __('first')) ?>
                        <?= $this->Paginator->prev('< ' . __('previous')) ?>
                        <?= $this->Paginator->numbers() ?>
                        <?= $this->Paginator->next(__('next') . ' >') ?>
                        <?= $this->Paginator->last(__('last') . ' >>') ?>
                    </ul>
                    <p><?= $this->Paginator->counter(__('Page {{page}} of {{pages}}, showing {{current}} record(s) out of {{count}} total')) ?></p>
                </div>
            </div>
        </div>
    </section>
</div>
