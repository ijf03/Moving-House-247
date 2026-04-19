<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Booking $booking
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('Edit Booking'), ['action' => 'edit', $booking->booking_id], ['class' => 'side-nav-item']) ?>
            <?= $this->Form->postLink(__('Delete Booking'), ['action' => 'delete', $booking->booking_id], ['confirm' => __('Are you sure you want to delete # {0}?', $booking->booking_id), 'class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('List Bookings'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('New Booking'), ['action' => 'add'], ['class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('Generate Invoice'), ['controller' => 'Invoices', 'action' => 'add', $booking->booking_id], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column column-80">
        <div class="bookings view content">
            <h3><?= h($booking->booking_id) ?></h3>
            <table>
                <tr>
                    <th><?= __('Customer') ?></th>
                    <td><?= $booking->hasValue('customer') ? $this->Html->link($booking->customer->first_name, ['controller' => 'Customers', 'action' => 'view', $booking->customer->customer_id]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('Job Type') ?></th>
                    <td><?= $booking->hasValue('job_type') ? $this->Html->link($booking->job_type->job_type_name, ['controller' => 'JobTypes', 'action' => 'view', $booking->job_type->job_type_id]) : '' ?></td>
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
                    <th><?= __('Status') ?></th>
                    <td><?= h($booking->status) ?></td>
                </tr>
                <tr>
                    <th><?= __('Booking Id') ?></th>
                    <td><?= $this->Number->format($booking->booking_id) ?></td>
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
                    <th><?= __('Created') ?></th>
                    <td><?= h($booking->created) ?></td>
                </tr>
            </table>
        </div>
    </div>
</div>
