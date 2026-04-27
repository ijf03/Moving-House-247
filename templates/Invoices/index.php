<?php
/**
 * @var \App\View\AppView $this
 * @var iterable<\App\Model\Entity\Invoice> $invoices
 */
?>
<div class="invoices index content">
    <?= $this->Html->link(__('New Invoice'), ['action' => 'add'], ['class' => 'button float-right']) ?>
    <h3><?= __('Invoices') ?></h3>
    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th><?= $this->Paginator->sort('invoice_id') ?></th>
                    <th><?= $this->Paginator->sort('booking_id') ?></th>
                    <th><?= $this->Paginator->sort('customer_id') ?></th>
                    <th><?= $this->Paginator->sort('stripe_invoice_id') ?></th>
                    <th><?= $this->Paginator->sort('status') ?></th>
                    <th><?= $this->Paginator->sort('subtotal_cents') ?></th>
                    <th><?= $this->Paginator->sort('total_cents') ?></th>
                    <th><?= $this->Paginator->sort('sent_at') ?></th>
                    <th><?= $this->Paginator->sort('paid_at') ?></th>
                    <th><?= $this->Paginator->sort('created') ?></th>
                    <th><?= $this->Paginator->sort('modified') ?></th>
                    <th class="actions"><?= __('Actions') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($invoices as $invoice): ?>
                <tr>
                    <td><?= $this->Number->format($invoice->invoice_id) ?></td>
                    <td><?= $invoice->hasValue('booking') ? $this->Html->link($invoice->booking->booking_id, ['controller' => 'Bookings', 'action' => 'view', $invoice->booking->booking_id]) : '' ?></td>
                    <td><?= $invoice->hasValue('customer') ? $this->Html->link($invoice->customer->first_name, ['controller' => 'Customers', 'action' => 'view', $invoice->customer->customer_id]) : '' ?></td>
                    <td><?= h($invoice->stripe_invoice_id) ?></td>
                    <td><?= h($invoice->status) ?></td>
                    <td><?= $invoice->subtotal_cents === null ? '' : $this->Number->format($invoice->subtotal_cents) ?></td>
                    <td><?= $invoice->total_cents === null ? '' : $this->Number->format($invoice->total_cents) ?></td>
                    <td><?= h($invoice->sent_at) ?></td>
                    <td><?= h($invoice->paid_at) ?></td>
                    <td><?= h($invoice->created) ?></td>
                    <td><?= h($invoice->modified) ?></td>
                    <td class="actions">
                        <?= $this->Html->link(__('View'), ['action' => 'view', $invoice->invoice_id]) ?>
                        <?= $this->Html->link(__('Edit'), ['action' => 'edit', $invoice->invoice_id]) ?>
                        <?= $this->Form->postLink(
                            __('Delete'),
                            ['action' => 'delete', $invoice->invoice_id],
                            [
                                'method' => 'delete',
                                'confirm' => __('Are you sure you want to delete # {0}?', $invoice->invoice_id),
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