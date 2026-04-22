<?php
/**
 * @var \App\View\AppView $this
 * @var iterable<\App\Model\Entity\Booking> $bookings
 */
?>

<div class="mh-page-soft">
    <section class="admin-hero">
        <div class="container">
            <div class="admin-hero-shell">
                <div class="admin-hero-content">
                    <p class="admin-eyebrow">Admin Dashboard</p>
                    <h1>Manage Bookings</h1>
                    <p class="admin-hero-text">
                        Review booking requests, filter job records, and manage pending removals and storage services.
                    </p>
                </div>
            </div>
        </div>
    </section>

    <section class="admin-section">
        <div class="container">
            <div class="admin-table-card">
                <div class="admin-table-header">
                    <div>
                        <h2>Booking Records</h2>
                        <p>Filter by status or service type, then review and action pending requests.</p>
                    </div>
                </div>

                <div class="admin-filter-card">
                    <?= $this->Form->create(null, ['type' => 'get', 'class' => 'admin-filter-form mh-form']) ?>
                    <div class="row g-3">
                        <div class="col-md-4">
                            <?=
                            $this->Form->control('status', [
                                'type' => 'select',
                                'label' => 'Booking Status',
                                'empty' => 'All Status',
                                'options' => [
                                    'Pending' => 'Pending',
                                    'Processing' => 'Processing',
                                    'Done' => 'Done',
                                    'Rejected' => 'Rejected',
                                ],
                                'default' => $status ?? null,
                            ])
                            ?>
                        </div>

                        <div class="col-md-4">
                            <?=
                            $this->Form->control('job_type_id', [
                                'type' => 'select',
                                'label' => 'Service Type',
                                'empty' => 'All Job Types',
                                'options' => $job_types,
                                'default' => $jobTypeId ?? null,
                            ])
                            ?>
                        </div>

                        <div class="col-md-4">
                            <?=
                            $this->Form->control('direction', [
                                'type' => 'select',
                                'label' => 'Sort by Date',
                                'options' => [
                                    'asc' => 'Ascending',
                                    'desc' => 'Descending',
                                ],
                                'default' => $direction ?? 'asc',
                            ])
                            ?>
                            <?= $this->Form->hidden('sort', ['value' => 'job_date']) ?>
                        </div>
                    </div>

                    <div class="admin-filter-actions">
                        <?= $this->Form->button(__('Apply Filters'), ['class' => 'admin-primary-link admin-primary-button']) ?>
                    </div>
                    <?= $this->Form->end() ?>
                </div>

                <div class="admin-table-wrap">
                    <table class="admin-table">
                        <thead>
                        <tr>
                            <th><?= __('Booking ID') ?></th>
                            <th><?= __('Customer Name') ?></th>
                            <th><?= __('Customer Email') ?></th>
                            <th><?= __('Customer Phone') ?></th>
                            <th><?= __('Service Type') ?></th>
                            <th><?= __('Pickup Address') ?></th>
                            <th><?= __('Dropoff Address') ?></th>
                            <th><?= __('Job Date') ?></th>
                            <th><?= __('Job Time') ?></th>
                            <th><?= __('Status') ?></th>
                            <th class="actions"><?= __('Actions') ?></th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php if ($bookings->isEmpty()): ?>
                            <tr>
                                <td colspan="11" style="text-align:center; color:gray;">
                                    No bookings found.
                                </td>
                            </tr>
                        <?php else: ?>

                        <?php foreach ($bookings as $booking): ?>

                            <tr>
                                <td><?= h($booking->booking_id) ?></td>
                                <td><?= h(($booking->customer->first_name ?? '') . ' ' . ($booking->customer->last_name ?? '')) ?></td>
                                <td><?= h($booking->customer->email ?? '') ?></td>
                                <td><?= h($booking->customer->phone ?? '') ?></td>
                                <td><?= h($booking->job_type->job_type_name ?? '') ?></td>
                                <td><?= h($booking->pickup_address) ?></td>
                                <td><?= h($booking->dropoff_address) ?></td>
                                <td><?= h($booking->job_date) ?></td>
                                <td><?= h($booking->job_time) ?></td>
                                <td>
                                    <span class="admin-status-badge admin-status-<?= strtolower((string)$booking->status) ?>">
                                        <?= h($booking->status) ?>
                                    </span>
                                </td>
                                <td class="actions">
                                    <div class="admin-action-stack">
                                        <?= $this->Html->link(__('View'), ['action' => 'view', $booking->booking_id], ['class' => 'admin-action-link']) ?>

                                        <?php if ($booking->status === 'Pending'): ?>
                                            <?= $this->Form->postLink(
                                                __('Accept'),
                                                ['action' => 'accept', $booking->booking_id],
                                                ['class' => 'admin-action-link admin-action-link-success']
                                            ) ?>

                                            <?= $this->Form->postLink(
                                                __('Reject'),
                                                ['action' => 'reject', $booking->booking_id],
                                                ['class' => 'admin-action-link admin-action-link-danger']
                                            ) ?>
                                        <?php endif; ?>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                        <?php endif; ?>
                        </tbody>
                    </table>
                </div>

            </div>
        </div>
    </section>
</div>
