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
                            <?= $this->Form->control('search', [
                                'label' => 'Search',
                                'placeholder' => 'Customer, email, phone, address, status...',
                                'value' => $search ?? '',
                            ]) ?>
                        </div>

                        <div class="col-md-4">
                            <?= $this->Form->control('status', [
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
                            ]) ?>
                        </div>

                        <div class="col-md-4">
                            <?= $this->Form->control('job_type_id', [
                                'type' => 'select',
                                'label' => 'Service Type',
                                'empty' => 'All Job Types',
                                'options' => $job_types ?? [],
                                'default' => $jobTypeId ?? null,
                            ]) ?>
                        </div>
                    </div>

                    <div class="admin-filter-actions">
                        <?= $this->Form->button(__('Apply Filters'), ['class' => 'admin-primary-link admin-primary-button']) ?>
                        <?= $this->Html->link(__('Reset'), ['action' => 'index'], ['class' => 'admin-action-link']) ?>
                    </div>
                    <?= $this->Form->end() ?>
                </div>

                <div class="admin-table-wrap">
                    <table class="admin-table">
                        <thead>
                        <tr>
                            <th><?= $this->Paginator->sort('booking_id', 'ID') ?></th>
                            <th><?= $this->Paginator->sort('Customers.first_name', 'Customer') ?></th>
                            <th><?= __('Contact') ?></th>
                            <th><?= $this->Paginator->sort('JobTypes.job_type_name', 'Service') ?></th>
                            <th><?= $this->Paginator->sort('pickup_address', 'Pickup') ?></th>
                            <th><?= $this->Paginator->sort('dropoff_address', 'Dropoff') ?></th>
                            <th><?= $this->Paginator->sort('job_date', 'Date') ?></th>
                            <th><?= $this->Paginator->sort('job_time', 'Time') ?></th>
                            <th><?= $this->Paginator->sort('status', 'Status') ?></th>
                            <th class="actions"><?= __('Actions') ?></th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php if ($bookings->isEmpty()) : ?>
                            <tr>
                                <td colspan="11" style="text-align:center; color:gray;">
                                    No bookings found.
                                </td>
                            </tr>
                        <?php else : ?>
                            <?php foreach ($bookings as $booking) : ?>
                                <?php
                                $customerName = trim(
                                    ($booking->customer->first_name ?? '') . ' ' .
                                    ($booking->customer->last_name ?? ''),
                                );

                                if ($customerName === '') {
                                    $customerName = 'this customer';
                                }

                                $serviceType = $booking->job_type->job_type_name ?? 'this service';
                                ?>

                            <tr>
                                <td><?= h($booking->booking_id) ?></td>
                                <td><?= h(($booking->customer->first_name ?? '') . ' ' . ($booking->customer->last_name ?? '')) ?></td>
                                <td><?= h($booking->customer->email ?? '') . ' ' . ($booking->customer->phone ?? '')?></td>
                                <td><?= h($booking->job_type->job_type_name ?? '') ?></td>


                                <td><?= h($booking->pickup_address) ?></td>
                                <td><?= h($booking->dropoff_address) ?></td>
                                <td><?= h($booking->job_date?->format('d/m/Y')) ?></td>
                                <td><?= h($booking->job_time) ?></td>
                                <td>
                                    <span class="admin-status-badge">
                                        <?= h($booking->status) ?>
                                    </span>
                                </td>
                                <td>
                                    <div class="admin-action-stack">
                                        <?= $this->Html->link(__('View'), ['action' => 'view', $booking->booking_id], ['class' => 'admin-action-link']) ?>

                                        <?php if ($booking->status === 'Pending') : ?>
                                            <?= $this->Form->postLink(
                                                __('Accept'),
                                                ['action' => 'accept', $booking->booking_id],
                                                [
                                                    'class' => 'admin-action-link admin-action-link-success',
                                                    'confirm' => __(
                                                        'Are you sure you want to accept the booking for {0} ({1})?',
                                                        $customerName,
                                                        $serviceType,
                                                    ),
                                                ],
                                            ) ?>

                                            <?= $this->Form->postLink(
                                                __('Reject'),
                                                ['action' => 'reject', $booking->booking_id],
                                                [
                                                    'class' => 'admin-action-link admin-action-link-danger',
                                                    'confirm' => __(
                                                        'Are you sure you want to reject the booking for {0} ({1})?',
                                                        $customerName,
                                                        $serviceType,
                                                    ),
                                                ],
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
