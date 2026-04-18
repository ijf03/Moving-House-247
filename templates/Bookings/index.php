<?php
/**
 * @var \App\View\AppView $this
 * @var iterable<\App\Model\Entity\Booking> $bookings
 */
?>
<div class="bookings index content">
    <?= $this->Html->link(__('New Booking'), ['action' => 'add'], ['class' => 'button float-right']) ?>
    <h3><?= __('Bookings') ?></h3>
    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th><?= $this->Paginator->sort('booking_id') ?></th>
                    <th><?= $this->Paginator->sort('customer_id') ?></th>
                    <th><?= $this->Paginator->sort('job_type_id') ?></th>
                    <th><?= $this->Paginator->sort('pickup_address') ?></th>
                    <th><?= $this->Paginator->sort('dropoff_address') ?></th>
                    <th><?= $this->Paginator->sort('job_date') ?></th>
                    <th><?= $this->Paginator->sort('job_time') ?></th>
                    <th><?= $this->Paginator->sort('status') ?></th>
                    <th><?= $this->Paginator->sort('created') ?></th>
                    <th class="actions"><?= __('Actions') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($bookings as $booking): ?>
                <tr>
                    <td><?= $this->Number->format($booking->booking_id) ?></td>
                    <td><?= $booking->hasValue('customer') ? $this->Html->link($booking->customer->first_name, ['controller' => 'Customers', 'action' => 'view', $booking->customer->customer_id]) : '' ?></td>
                    <td><?= $booking->hasValue('job_type') ? $this->Html->link($booking->job_type->job_type_name, ['controller' => 'JobTypes', 'action' => 'view', $booking->job_type->job_type_id]) : '' ?></td>
                    <td><?= h($booking->pickup_address) ?></td>
                    <td><?= h($booking->dropoff_address) ?></td>
                    <td><?= h($booking->job_date) ?></td>
                    <td><?= h($booking->job_time) ?></td>
                    <td><?= h($booking->status) ?></td>
                    <td><?= h($booking->created) ?></td>
                    <td class="actions">
                        <?= $this->Html->link(__('View'), ['action' => 'view', $booking->booking_id]) ?>
                        <?= $this->Html->link(__('Edit'), ['action' => 'edit', $booking->booking_id]) ?>
                        <?= $this->Form->postLink(
                            __('Delete'),
                            ['action' => 'delete', $booking->booking_id],
                            [
                                'method' => 'delete',
                                'confirm' => __('Are you sure you want to delete # {0}?', $booking->booking_id),
                            ]
                        ) ?>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <div class="paginator">
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