<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\JobResource $bookingResource
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('Edit Booking Resource'), ['action' => 'edit', $bookingResource->booking_resource_id], ['class' => 'side-nav-item']) ?>
            <?= $this->Form->postLink(__('Delete Booking Resource'), ['action' => 'delete', $bookingResource->booking_resource_id], ['confirm' => __('Are you sure you want to delete # {0}?', $bookingResource->booking_resource_id), 'class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('List Booking Resources'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('New Booking Resource'), ['action' => 'add'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column column-80">
        <div class="bookingResources view content">
            <h3><?= h($bookingResource->resource_type) ?></h3>
            <table>
                <tr>
                    <th><?= __('Booking') ?></th>
                    <td><?= $bookingResource->hasValue('booking') ? $this->Html->link($bookingResource->booking->booking_id, ['controller' => 'Bookings', 'action' => 'view', $bookingResource->booking->booking_id]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('Resource Type') ?></th>
                    <td><?= h($bookingResource->resource_type) ?></td>
                </tr>
                <tr>
                    <th><?= __('Booking Resource Id') ?></th>
                    <td><?= $this->Number->format($bookingResource->booking_resource_id) ?></td>
                </tr>
                <tr>
                    <th><?= __('Resource Id') ?></th>
                    <td><?= $this->Number->format($bookingResource->resource_id) ?></td>
                </tr>
                <tr>
                    <th><?= __('Quantity') ?></th>
                    <td><?= $this->Number->format($bookingResource->quantity) ?></td>
                </tr>
                <tr>
                    <th><?= __('Created') ?></th>
                    <td><?= h($bookingResource->created) ?></td>
                </tr>
                <tr>
                    <th><?= __('Modified') ?></th>
                    <td><?= h($bookingResource->modified) ?></td>
                </tr>
            </table>
            <div class="text">
                <strong><?= __('Notes') ?></strong>
                <blockquote>
                    <?= $this->Text->autoParagraph(h($bookingResource->notes)); ?>
                </blockquote>
            </div>
        </div>
    </div>
</div>
