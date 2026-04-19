<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\InvoiceItem $invoiceItem
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('Edit Invoice Item'), ['action' => 'edit', $invoiceItem->invoice_item_id], ['class' => 'side-nav-item']) ?>
            <?= $this->Form->postLink(__('Delete Invoice Item'), ['action' => 'delete', $invoiceItem->invoice_item_id], ['confirm' => __('Are you sure you want to delete # {0}?', $invoiceItem->invoice_item_id), 'class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('List Invoice Items'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('New Invoice Item'), ['action' => 'add'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column column-80">
        <div class="invoiceItems view content">
            <h3><?= h($invoiceItem->description) ?></h3>
            <table>
                <tr>
                    <th><?= __('Invoice') ?></th>
                    <td><?= $invoiceItem->hasValue('invoice') ? $this->Html->link($invoiceItem->invoice->stripe_invoice_id, ['controller' => 'Invoices', 'action' => 'view', $invoiceItem->invoice->invoice_id]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('Description') ?></th>
                    <td><?= h($invoiceItem->description) ?></td>
                </tr>
                <tr>
                    <th><?= __('Invoice Item Id') ?></th>
                    <td><?= $this->Number->format($invoiceItem->invoice_item_id) ?></td>
                </tr>
                <tr>
                    <th><?= __('Quantity') ?></th>
                    <td><?= $this->Number->format($invoiceItem->quantity) ?></td>
                </tr>
                <tr>
                    <th><?= __('Unit Price Cents') ?></th>
                    <td><?= $this->Number->format($invoiceItem->unit_price_cents) ?></td>
                </tr>
                <tr>
                    <th><?= __('Line Total Cents') ?></th>
                    <td><?= $this->Number->format($invoiceItem->line_total_cents) ?></td>
                </tr>
                <tr>
                    <th><?= __('Sort Order') ?></th>
                    <td><?= $this->Number->format($invoiceItem->sort_order) ?></td>
                </tr>
                <tr>
                    <th><?= __('Created') ?></th>
                    <td><?= h($invoiceItem->created) ?></td>
                </tr>
                <tr>
                    <th><?= __('Modified') ?></th>
                    <td><?= h($invoiceItem->modified) ?></td>
                </tr>
            </table>
        </div>
    </div>
</div>