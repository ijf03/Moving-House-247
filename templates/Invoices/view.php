<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Invoice $invoice
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('Edit Invoice'), ['action' => 'edit', $invoice->invoice_id], ['class' => 'side-nav-item']) ?>
            <?= $this->Form->postLink(__('Delete Invoice'), ['action' => 'delete', $invoice->invoice_id], ['confirm' => __('Are you sure you want to delete # {0}?', $invoice->invoice_id), 'class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('List Invoices'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('New Invoice'), ['action' => 'add'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column column-80">
        <div class="invoices view content">
            <h3><?= h($invoice->stripe_invoice_id) ?></h3>
            <table>
                <tr>
                    <th><?= __('Booking') ?></th>
                    <td><?= $invoice->hasValue('booking') ? $this->Html->link($invoice->booking->booking_id, ['controller' => 'Bookings', 'action' => 'view', $invoice->booking->booking_id]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('Customer') ?></th>
                    <td><?= $invoice->hasValue('customer') ? $this->Html->link($invoice->customer->first_name, ['controller' => 'Customers', 'action' => 'view', $invoice->customer->customer_id]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('Stripe Invoice Id') ?></th>
                    <td><?= h($invoice->stripe_invoice_id) ?></td>
                </tr>
                <tr>
                    <th><?= __('Status') ?></th>
                    <td><?= h($invoice->status) ?></td>
                </tr>
                <tr>
                    <th><?= __('Invoice Id') ?></th>
                    <td><?= $this->Number->format($invoice->invoice_id) ?></td>
                </tr>
                <tr>
                    <th><?= __('Subtotal Cents') ?></th>
                    <td><?= $invoice->subtotal_cents === null ? '' : $this->Number->format($invoice->subtotal_cents) ?></td>
                </tr>
                <tr>
                    <th><?= __('Total Cents') ?></th>
                    <td><?= $invoice->total_cents === null ? '' : $this->Number->format($invoice->total_cents) ?></td>
                </tr>
                <tr>
                    <th><?= __('Sent At') ?></th>
                    <td><?= h($invoice->sent_at) ?></td>
                </tr>
                <tr>
                    <th><?= __('Paid At') ?></th>
                    <td><?= h($invoice->paid_at) ?></td>
                </tr>
                <tr>
                    <th><?= __('Created') ?></th>
                    <td><?= h($invoice->created) ?></td>
                </tr>
                <tr>
                    <th><?= __('Modified') ?></th>
                    <td><?= h($invoice->modified) ?></td>
                </tr>
            </table>
            <div class="text">
                <strong><?= __('Invoice Url') ?></strong>
                <blockquote>
                    <?= $this->Text->autoParagraph(h($invoice->invoice_url)); ?>
                </blockquote>
            </div>
        </div>
    </div>
</div>