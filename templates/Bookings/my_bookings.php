<?php
/**
 * @var \App\View\AppView $this
 * @var iterable<\App\Model\Entity\Booking> $bookings
 * @var \App\Model\Entity\Booking|null $popupBooking
 */
?>

<div class="mh-page-soft">
    <section class="admin-hero">
        <div class="container">
            <div class="admin-hero-shell">
                <div class="admin-hero-content">
                    <span class="admin-eyebrow"><?= __('Customer Portal') ?></span>
                    <h1><?= __('My Bookings') ?></h1>
                    <p class="admin-hero-text">
                        <?= __('View your confirmed bookings, check important job details, and open each booking for more information.') ?>
                    </p>
                </div>
            </div>
        </div>
    </section>

    <section class="admin-section">
        <div class="container">
            <div class="admin-table-card">
                <div class="admin-table-header">
                    <div class="admin-table-header-split">
                        <div>
                            <h2><?= __('My Accepted Bookings') ?></h2>
                            <p><?= __('Here are all bookings that have already been accepted.') ?></p>
                        </div>
                    </div>
                </div>

                <?php if (!empty($popupBooking)) : ?>
                    <script>
                        alert('Your booking request has been accepted.');
                    </script>
                <?php endif; ?>

                <?php if ($bookings->isEmpty()) : ?>
                    <p><?= __('You do not have any accepted bookings yet.') ?></p>
                <?php else : ?>
                    <div class="admin-table-wrap">
                        <table class="admin-table">
                            <thead>
                            <tr>
                                <th><?= __('Booking ID') ?></th>
                                <th><?= __('Service Type') ?></th>
                                <th><?= __('Pickup Address') ?></th>
                                <th><?= __('Dropoff Address') ?></th>
                                <th><?= __('Job Date') ?></th>
                                <th><?= __('Job Time') ?></th>
                                <th><?= __('Status') ?></th>
                                <th><?= __('Actions') ?></th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php foreach ($bookings as $booking) : ?>
                                <tr>
                                    <td><?= h($booking->booking_id) ?></td>
                                    <td><?= h($booking->job_type->job_type_name ?? '') ?></td>
                                    <td><?= h($booking->pickup_address) ?></td>
                                    <td><?= h($booking->dropoff_address) ?></td>
                                    <td><?= h($booking->job_date?->format('Y-m-d')) ?></td>
                                    <td><?= h($booking->job_time?->format('H:i')) ?></td>
                                    <td>
                                        <span class="admin-status-badge admin-status-replied">
                                            <?= h($booking->status) ?>
                                        </span>
                                    </td>
                                    <td>
                                        <div class="admin-action-stack">
                                            <?= $this->Html->link(
                                                __('View'),
                                                ['action' => 'view', $booking->booking_id],
                                                ['class' => 'admin-action-link'],
                                            ) ?>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </section>
</div>
