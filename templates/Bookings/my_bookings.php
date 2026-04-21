<?php
/**
 * @var \App\View\AppView $this
 * @var iterable<\App\Model\Entity\Booking> $bookings
 */
?>
<div class="bookings index content">
    <h3><?= __('My Accepted Bookings') ?></h3>

    <?php if ($bookings->isEmpty()): ?>
        <p><?= __('You do not have any accepted bookings yet.') ?></p>
    <?php else: ?>
        <?php if (!empty($popupBooking)): ?>
            <script>
                alert('Your booking request has been accepted.');
            </script>
        <?php endif; ?>
        <table>
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
            <?php foreach ($bookings as $booking): ?>
                <tr>
                    <td><?= h($booking->booking_id) ?></td>
                    <td><?= h($booking->job_type->job_type_name ?? '') ?></td>
                    <td><?= h($booking->pickup_address) ?></td>
                    <td><?= h($booking->dropoff_address) ?></td>
                    <td><?= h($booking->job_date) ?></td>
                    <td><?= h($booking->job_time) ?></td>
                    <td><?= h($booking->status) ?></td>
                    <td>
                        <?= $this->Html->link(__('View'), ['action' => 'view', $booking->booking_id]) ?>
                    </td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    <?php endif; ?>
</div>
