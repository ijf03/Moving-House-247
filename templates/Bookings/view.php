<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Booking $booking
 */
?>
<div class="bookings view content">
    <h3><?= __('Booking #') . h($booking->booking_id) ?></h3>
    <table>
        <tr>
            <th><?= __('Customer Name') ?></th>
            <td><?= h(($booking->customer->first_name ?? '') . ' ' . ($booking->customer->last_name ?? '')) ?></td>
        </tr>
        <tr>
            <th><?= __('Customer Email') ?></th>
            <td><?= h($booking->customer->email ?? '') ?></td>
        </tr>
        <tr>
            <th><?= __('Customer Phone') ?></th>
            <td><?= h($booking->customer->phone ?? '') ?></td>
        </tr>
        <tr>
            <th><?= __('Service Type') ?></th>
            <td><?= h($booking->job_type->job_type_name ?? '') ?></td>
        </tr>
        <tr>
            <th><?= __('Pickup Address') ?></th>
            <td><?= h($booking->pickup_address) ?></td>
        </tr>
        <tr>
            <th><?= __('Dropoff Address') ?></th>
            <td><?= h($booking->dropoff_address) ?></td>
        </tr>
        <tr>
            <th><?= __('Job Date') ?></th>
            <td><?= h($booking->job_date) ?></td>
        </tr>
        <tr>
            <th><?= __('Job Time') ?></th>
            <td><?= h($booking->job_time) ?></td>
        </tr>
        <tr>
            <th><?= __('Status') ?></th>
            <td><?= h($booking->status) ?></td>
        </tr>
    </table>
</div>
