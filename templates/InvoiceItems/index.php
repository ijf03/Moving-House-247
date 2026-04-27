<?php
/**
 * @var \App\View\AppView $this
 * @var iterable<\App\Model\Entity\InvoiceItem> $invoiceItems
 */
?>
<div class="invoiceItems index content">
    <?= $this->Html->link(__('New Invoice Item'), ['action' => 'add'], ['class' => 'button float-right']) ?>
    <h3><?= __('Invoice Items') ?></h3>
    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th><?= $this->Paginator->sort('invoice_item_id') ?></th>
                    <th><?= $this->Paginator->sort('invoice_id') ?></th>
                    <th><?= $this->Paginator->sort('description') ?></th>
                    <th><?= $this->Paginator->sort('quantity') ?></th>
                    <th><?= $this->Paginator->sort('unit_price_cents') ?></th>
                    <th><?= $this->Paginator->sort('line_total_cents') ?></th>
                    <th><?= $this->Paginator->sort('sort_order') ?></th>
                    <th><?= $this->Paginator->sort('created') ?></th>
                    <th><?= $this->Paginator->sort('modified') ?></th>
                    <th class="actions"><?= __('Actions') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($invoiceItems as $invoiceItem): ?>
                <tr>
                    <td><?= $this->Number->format($invoiceItem->invoice_item_id) ?></td>
                    <td><?= $invoiceItem->hasValue('invoice') ? $this->Html->link($invoiceItem->invoice->stripe_invoice_id, ['controller' => 'Invoices', 'action' => 'view', $invoiceItem->invoice->invoice_id]) : '' ?></td>
                    <td><?= h($invoiceItem->description) ?></td>
                    <td><?= $this->Number->format($invoiceItem->quantity) ?></td>
                    <td><?= $this->Number->format($invoiceItem->unit_price_cents) ?></td>
                    <td><?= $this->Number->format($invoiceItem->line_total_cents) ?></td>
                    <td><?= $this->Number->format($invoiceItem->sort_order) ?></td>
                    <td><?= h($invoiceItem->created) ?></td>
                    <td><?= h($invoiceItem->modified) ?></td>
                    <td class="actions">
                        <?= $this->Html->link(__('View'), ['action' => 'view', $invoiceItem->invoice_item_id]) ?>
                        <?= $this->Html->link(__('Edit'), ['action' => 'edit', $invoiceItem->invoice_item_id]) ?>
                        <?= $this->Form->postLink(
                            __('Delete'),
                            ['action' => 'delete', $invoiceItem->invoice_item_id],
                            [
                                'method' => 'delete',
                                'confirm' => __('Are you sure you want to delete # {0}?', $invoiceItem->invoice_item_id),
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