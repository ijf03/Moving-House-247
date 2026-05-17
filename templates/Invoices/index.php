<?php
/**
 * @var \App\View\AppView $this
 * @var iterable<\App\Model\Entity\Invoice> $invoices
 */
?>
<section class="admin-hero">
    <div class="container admin-hero-shell">
        <div class="admin-hero-content">
            <span class="admin-eyebrow"><?= __('Invoice Management') ?></span>
            <h1><?= __('Invoices') ?></h1>
            <p class="admin-hero-text">
                <?= __('View, manage, and track customer invoices and payment statuses.') ?>
            </p>
        </div>
    </div>
</section>

<section class="admin-section mh-page-soft">
    <div class="container">
        <div class="admin-table-card">
            <div class="admin-table-header admin-table-header-split">
                <div>
                    <h2><?= __('All Invoices') ?></h2>
                    <p><?= __('Review invoice totals, statuses, and linked customer bookings.') ?></p>
                </div>
                <?= $this->Html->link(__('New Invoice'), ['action' => 'add'], ['class' => 'btn']) ?>
            </div>


            <div class="admin-table-wrap">
                <table class="admin-table">
                    <thead>
                    <tr>
                        <th><?= $this->Paginator->sort('ID') ?></th>
                        <th><?= $this->Paginator->sort('booking_id') ?></th>
                        <th><?= $this->Paginator->sort('customer_id') ?></th>
                        <th><?= __('Invoice URL') ?></th>
                        <th><?= $this->Paginator->sort('status') ?></th>
                        <th><?= __('Total ($)') ?></th>
                        <th><?= $this->Paginator->sort('sent_at') ?></th>
                        <th><?= $this->Paginator->sort('paid_at') ?></th>
                        <th class="actions"><?= __('Actions') ?></th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($invoices as $invoice): ?>
                        <tr>
                            <td><?= $this->Number->format($invoice->invoice_id) ?></td>

                            <td>
                                <?= $invoice->hasValue('booking')
                                    ? $this->Html->link(
                                        'Booking #' . $invoice->booking->booking_id,
                                        ['controller' => 'Bookings', 'action' => 'view', $invoice->booking->booking_id],
                                        ['class' => 'admin-inline-link']
                                    )
                                    : __('N/A') ?>
                            </td>

                            <td>
                                <?= $invoice->hasValue('customer')
                                    ? $this->Html->link(
                                        $invoice->customer->first_name . ' ' . $invoice->customer->last_name,
                                        ['controller' => 'Customers', 'action' => 'view', $invoice->customer->customer_id],
                                        ['class' => 'admin-inline-link']
                                    )
                                    : __('N/A') ?>
                            </td>

                            <td>
                                <?php if (!empty($invoice->invoice_url)): ?>
                                    <?= $this->Html->link(
                                        __('View'),
                                        $invoice->invoice_url,
                                        ['target' => '_blank', 'class' => 'mh-btn-primary']
                                    ) ?>
                                <?php else: ?>
                                    <?= __('N/A') ?>
                                <?php endif; ?>
                            </td>

                            <td>
                                        <span class="admin-status-badge">
                                            <?= h(ucfirst($invoice->status)) ?>
                                        </span>
                            </td>

                            <td>
                                <?= $invoice->total_cents !== null
                                    ? '$' . number_format($invoice->total_cents / 100, 2)
                                    : '' ?>
                            </td>

                            <td><?= h($invoice->sent_at) ?></td>
                            <td><?= h($invoice->paid_at) ?></td>
                            <td class="actions">
                                <?= $this->Html->link(__('View'), ['action' => 'view', $invoice->invoice_id], ['class' => 'admin-action-link']) ?>
                                <?php if (strtolower($invoice->status) !== 'paid'): ?>
                                    <?= $this->Html->link(__('Edit'), ['action' => 'edit', $invoice->invoice_id], ['class' => 'admin-action-link']) ?>

                                <?= $this->Form->postLink(
                                    __('Delete'),
                                    ['action' => 'delete', $invoice->invoice_id],
                                    [
                                        'method' => 'delete',
                                        'confirm' => __('Are you sure you want to delete # {0}?', $invoice->invoice_id),
                                        'class' => 'admin-action-link admin-action-link-danger'
                                    ]
                                ) ?>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                    </tbody>
                </table>
            </div>

            <div class="admin-paginator">
                <ul class="pagination">
                    <?= $this->Paginator->first('<< ' . __('first')) ?>
                    <?= $this->Paginator->prev('< ' . __('previous')) ?>
                    <?= $this->Paginator->numbers() ?>
                    <?= $this->Paginator->next(__('next') . ' >') ?>
                    <?= $this->Paginator->last(__('last') . ' >>') ?>
                </ul>
                <p>
                    <?= $this->Paginator->counter(
                        __('Page {{page}} of {{pages}}, showing {{current}} record(s) out of {{count}} total')
                    ) ?>
                </p>
            </div>
        </div>
    </div>
</section>
