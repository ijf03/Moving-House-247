<?php
/**
 * @var \App\View\AppView $this
 * @var iterable<\App\Model\Entity\BookingResource> $bookingResources
 */
?>
<div class="bookingResources index content">
    <?= $this->Html->link(__('New Booking Resource'), ['action' => 'add'], ['class' => 'button float-right']) ?>
    <h3><?= __('Booking Resources') ?></h3>
    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th><?= $this->Paginator->sort('booking_resource_id') ?></th>
                    <th><?= $this->Paginator->sort('booking_id') ?></th>
                    <th><?= $this->Paginator->sort('resource_type') ?></th>
                    <th><?= $this->Paginator->sort('resource_id') ?></th>
                    <th><?= $this->Paginator->sort('quantity') ?></th>
                    <th><?= $this->Paginator->sort('created') ?></th>
                    <th><?= $this->Paginator->sort('modified') ?></th>
                    <th class="actions"><?= __('Actions') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($bookingResources as $bookingResource): ?>
                <tr>
                    <td><?= $this->Number->format($bookingResource->booking_resource_id) ?></td>
                    <td><?= $bookingResource->hasValue('booking') ? $this->Html->link($bookingResource->booking->booking_id, ['controller' => 'Bookings', 'action' => 'view', $bookingResource->booking->booking_id]) : '' ?></td>
                    <td><?= h($bookingResource->resource_type) ?></td>
                    <td><?= $this->Number->format($bookingResource->resource_id) ?></td>
                    <td><?= $this->Number->format($bookingResource->quantity) ?></td>
                    <td><?= h($bookingResource->created) ?></td>
                    <td><?= h($bookingResource->modified) ?></td>
                    <td class="actions">
                        <?= $this->Html->link(__('View'), ['action' => 'view', $bookingResource->booking_resource_id]) ?>
                        <?= $this->Html->link(__('Edit'), ['action' => 'edit', $bookingResource->booking_resource_id]) ?>
                        <?= $this->Form->postLink(
                            __('Delete'),
                            ['action' => 'delete', $bookingResource->booking_resource_id],
                            [
                                'method' => 'delete',
                                'confirm' => __('Are you sure you want to delete # {0}?', $bookingResource->booking_resource_id),
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