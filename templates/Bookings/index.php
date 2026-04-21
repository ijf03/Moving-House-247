<?php
/**
 * @var \App\View\AppView $this
 * @var iterable<\App\Model\Entity\Booking> $bookings
 */
?>
<div class="bookings index content">
    <h3><?= __('Manage Bookings') ?></h3>

    <?= $this->Form->create(null, ['type' => 'get']) ?>
    <fieldset>
        <legend><?= __('Filter and Sort') ?></legend>
        <?php
        echo $this->Form->control('status', [
            'type' => 'select',
            'empty' => 'All Status',
            'options' => [
                'Pending' => 'Pending',
                'Processing' => 'Processing',
                'Done' => 'Done',
                'Rejected' => 'Rejected',
            ],
            'default' => $status ?? null,
        ]);

        echo $this->Form->control('job_type_id', [
            'type' => 'select',
            'empty' => 'All Job Types',
            'options' => [
                1 => 'Removal',
                2 => 'Storage',
            ],
            'default' => $jobTypeId ?? null,
        ]);

        echo $this->Form->control('sort', [
            'type' => 'hidden',
            'value' => 'job_date',
        ]);

        echo $this->Form->control('direction', [
            'type' => 'select',
            'label' => 'Sort by Date',
            'options' => [
                'asc' => 'Ascending',
                'desc' => 'Descending',
            ],
            'default' => $direction ?? 'asc',
        ]);
        ?>
    </fieldset>
    <?= $this->Form->button(__('Apply')) ?>
    <?= $this->Form->end() ?>
    <div style="overflow-x: auto;">
        <?php if ($bookings->isEmpty()): ?>
            <p>No result found.</p>
        <?php else: ?>
    <table>
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
            <th><?= __('Actions') ?></th>
        </tr>
        </thead>
        <tbody>
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
                <td><?= h($booking->status) ?></td>
                <td>
                    <?= $this->Html->link(__('View'), ['action' => 'view', $booking->booking_id]) ?>

                    <?php if ($booking->status === 'Pending'): ?>
                        <?= $this->Form->postLink(__('Accept'), ['action' => 'accept', $booking->booking_id]) ?>
                        <?= $this->Form->postLink(__('Reject'), ['action' => 'reject', $booking->booking_id]) ?>
                    <?php endif; ?>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
    <?php endif; ?>
    </div>
</div>
