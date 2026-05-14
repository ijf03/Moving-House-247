<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Invoice $invoice
 */
?>
<div class="mh-page-soft">
    <section class="admin-hero">
        <div class="container">
            <div class="admin-hero-shell">
                <div class="admin-hero-content">
                    <span class="admin-eyebrow"><?= __('Admin') ?></span>
                    <h1><?= __('Invoice #{0}', $invoice->invoice_id) ?></h1>
                    <p class="admin-hero-text">
                        <?= __('View the details of this invoice, customer, and booking information.') ?>
                    </p>
                </div>
            </div>
        </div>
    </section>

    <section class="admin-section">
        <div class="container">
            <div class="row g-4 justify-content-center">

                <div class="col-lg-3">
                    <div class="admin-table-card">
                        <div class="admin-table-header">
                            <h2><?= __('Actions') ?></h2>
                        </div>
                        <div class="admin-action-stack">
                            <?= $this->Html->link(__('Back to Invoices'), ['action' => 'index'], ['class' => 'admin-action-link']) ?>
                            <?= $this->Html->link(
                                __('Back to Booking'),
                                ['controller' => 'Bookings', 'action' => 'view', $invoice->booking_id],
                                ['class' => 'admin-action-link']
                            ) ?>
                            <?php if (!empty($invoice->invoice_url)): ?>
                                <?= $this->Html->link(
                                    __('View in Stripe'),
                                    $invoice->invoice_url,
                                    ['class' => 'admin-action-link', 'target' => '_blank', 'rel' => 'noopener noreferrer']
                                ) ?>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>

                <div class="col-lg-9">
                    <div class="auth-card auth-card-wide">
                        <div class="auth-header">
                            <h2 class="auth-title"><?= __('Invoice Details') ?></h2>
                            <p class="auth-subtitle"><?= __('Summary of the invoice, customer, booking, and payment status.') ?></p>
                        </div>

                        <table class="table table-striped">
                            <tr>
                                <th><?= __('Booking ID') ?></th>
                                <td><?= h($invoice->booking_id) ?></td>
                            </tr>
                            <tr>
                                <th><?= __('Customer') ?></th>
                                <td><?= h(trim(($invoice->customer->first_name ?? '') . ' ' . ($invoice->customer->last_name ?? ''))) ?></td>
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
                                <td><?= h(ucfirst($invoice->status)) ?></td>
                            </tr>
                            <tr>
                                <th><?= __('Subtotal') ?></th>
                                <td>$<?= number_format(((int)$invoice->subtotal_cents)/100, 2) ?></td>
                            </tr>
                            <tr>
                                <th><?= __('Total') ?></th>
                                <td>$<?= number_format(((int)$invoice->total_cents)/100, 2) ?></td>
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
                            <h4 class="mt-4"><?= __('Line Items') ?></h4>
                            <table class="table table-striped">
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
                                        <td>$<?= number_format($item->unit_price_cents/100, 2) ?></td>
                                        <td>$<?= number_format($item->line_total_cents/100, 2) ?></td>
                                    </tr>
                                <?php endforeach; ?>
                                </tbody>
                            </table>
                        <?php endif; ?>
                    </div>
                </div>

            </div>
        </div>
    </section>
</div>
