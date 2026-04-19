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

            <?= $this->Html->link(
                __('Back to Booking'),
                ['controller' => 'Bookings', 'action' => 'view', $invoice->booking_id],
                ['class' => 'side-nav-item']
            ) ?>

            <?php if (!empty($invoice->invoice_url)): ?>
                <a class="side-nav-item" href="<?= h($invoice->invoice_url) ?>" target="_blank" rel="noopener noreferrer">
                    <?= __('Open Hosted Invoice') ?>
                </a>
            <?php endif; ?>
        </div>
    </aside>

    <div class="column column-80">
        <div class="invoices view content">
            <h3><?= __('Invoice #{0}', $invoice->invoice_id) ?></h3>

            <table>
                <tr>
                    <th><?= __('Booking ID') ?></th>
                    <td><?= h($invoice->booking_id) ?></td>
                </tr>
                <tr>
                    <th><?= __('Customer') ?></th>
                    <td><?= h(($invoice->customer->first_name ?? '') . ' ' . ($invoice->customer->last_name ?? '')) ?></td>
                </tr>
                <tr>
                    <th><?= __('Customer Email') ?></th>
                    <td><?= h($invoice->customer->email ?? '') ?></td>
                </tr>
                <tr>
                    <th><?= __('Pickup Address') ?></th>
                    <td><?= h($invoice->booking->pickup_address ?? '') ?></td>
                </tr>
                <tr>
                    <th><?= __('Dropoff Address') ?></th>
                    <td><?= h($invoice->booking->dropoff_address ?? '') ?></td>
                </tr>
                <tr>
                    <th><?= __('Stripe Invoice ID') ?></th>
                    <td><?= h($invoice->stripe_invoice_id) ?></td>
                </tr>
                <tr>
                    <th><?= __('Status') ?></th>
                    <td><?= h($invoice->status) ?></td>
                </tr>
                <tr>
                    <th><?= __('Subtotal') ?></th>
                    <td>$<?= number_format(((int)$invoice->subtotal_cents) / 100, 2) ?></td>
                </tr>
                <tr>
                    <th><?= __('Total') ?></th>
                    <td>$<?= number_format(((int)$invoice->total_cents) / 100, 2) ?></td>
                </tr>
                <tr>
                    <th><?= __('Sent At') ?></th>
                    <td><?= h($invoice->sent_at) ?></td>
                </tr>
                <tr>
                    <th><?= __('Paid At') ?></th>
                    <td><?= h($invoice->paid_at) ?></td>
                </tr>
            </table>

            <?php if (!empty($invoice->invoice_items)): ?>
                <h4><?= __('Line Items') ?></h4>
                <table>
                    <thead>
                    <tr>
                        <th><?= __('Description') ?></th>
                        <th><?= __('Quantity') ?></th>
                        <th><?= __('Unit Price') ?></th>
                        <th><?= __('Line Total') ?></th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($invoice->invoice_items as $item): ?>
                        <tr>
                            <td><?= h($item->description) ?></td>
                            <td><?= h($item->quantity) ?></td>
                            <td>$<?= number_format($item->unit_price_cents / 100, 2) ?></td>
                            <td>$<?= number_format($item->line_total_cents / 100, 2) ?></td>
                        </tr>
                    <?php endforeach; ?>
                    </tbody>
                </table>
            <?php endif; ?>
        </div>
    </div>
</div>
