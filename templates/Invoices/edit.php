<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Invoice $invoice
 * @var \App\Model\Entity\Booking $booking
 * @var \App\Model\Entity\Customer $customer
 * @var array $presetOptions
 */
?>

<div class="mh-page-soft">
    <section class="admin-hero">
        <div class="container">
            <div class="admin-hero-shell">
                <div class="admin-hero-content">
                    <span class="admin-eyebrow"><?= __('Admin') ?></span>
                    <h1><?= __('Edit Invoice') ?></h1>
                    <p class="admin-hero-text">
                        <?= __('Add invoice items, review totals, and prepare the invoice for sending.') ?>
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
                            <?= $this->Html->link(__('Back to Invoices'), ['action' => 'index'], [
                                'class' => 'admin-action-link'
                            ]) ?>

                            <?= $this->Html->link(__('View Invoice'), ['action' => 'view', $invoice->invoice_id], [
                                'class' => 'admin-action-link'
                            ]) ?>

                            <?= $this->Form->postLink(
                                __('Delete Invoice'),
                                ['action' => 'delete', $invoice->invoice_id],
                                [
                                    'confirm' => __('Are you sure you want to delete invoice # {0}?', $invoice->invoice_id),
                                    'class' => 'admin-action-link admin-action-link-danger'
                                ]
                            ) ?>
                        </div>
                    </div>
                </div>

                <div class="col-lg-9">
                    <div class="auth-card auth-card-wide mb-4">
                        <div class="auth-header">
                            <h2 class="auth-title">
                                <?= __('Invoice #{0}', $invoice->invoice_id) ?>
                            </h2>
                            <p class="auth-subtitle">
                                <?= __('Review invoice details before sending.') ?>
                            </p>
                        </div>

                        <div class="row g-3">

                            <div class="col-md-6 auth-form-group">
                                <label class="form-label"><?= __('Booking') ?></label>
                                <input
                                    type="text"
                                    class="auth-input"
                                    value="<?= h('Booking #' . $invoice->booking_id) ?>"
                                    readonly
                                >
                            </div>

                            <div class="col-md-6 auth-form-group">
                                <label class="form-label"><?= __('Customer') ?></label>
                                <input
                                    type="text"
                                    class="auth-input"
                                    value="<?= h(trim(($customer->first_name ?? '') . ' ' . ($customer->last_name ?? ''))) ?>"
                                    readonly
                                >
                            </div>

                            <div class="col-md-6 auth-form-group">
                                <label class="form-label"><?= __('Status') ?></label>
                                <input
                                    type="text"
                                    class="auth-input"
                                    value="<?= h(ucfirst($invoice->status)) ?>"
                                    readonly
                                >
                            </div>

                            <div class="col-md-6 auth-form-group">
                                <label class="form-label"><?= __('Current Total') ?></label>
                                <input
                                    type="text"
                                    class="auth-input"
                                    value="$<?= number_format(($invoice->total_cents ?? 0) / 100, 2) ?>"
                                    readonly
                                >
                            </div>

                        </div>

                        <?= $this->Form->create($invoice, ['class' => 'auth-form mt-3']) ?>

                        <div class="row g-3">
                            <div class="col-md-6 auth-form-group">
                                <?= $this->Form->control('due_date', [
                                    'type' => 'date',
                                    'label' => 'Due Date',
                                    'class' => 'auth-input',
                                    'min' => date('Y-m-d')
                                ]) ?>
                            </div>
                        </div>

                        <div class="auth-form-actions">
                            <?= $this->Form->button(__('Save Invoice Details'), [
                                'name' => 'action',
                                'value' => 'save_invoice',
                                'class' => 'mh-btn-primary'
                            ]) ?>
                        </div>

                        <?= $this->Form->end() ?>
                    </div>

                    <div class="auth-card auth-card-wide mb-4">
                        <div class="auth-header">
                            <h2 class="auth-title"><?= __('Add Invoice Item') ?></h2>
                            <p class="auth-subtitle">
                                <?= __('Add one item at a time. Preset items automatically use their preset price.') ?>
                            </p>
                        </div>

                        <?= $this->Form->create(null, ['class' => 'auth-form']) ?>

                        <div class="row g-3">

                            <div class="col-md-6 auth-form-group">
                                <?= $this->Form->control('preset', [
                                    'type' => 'select',
                                    'options' => $presetOptions,
                                    'label' => 'Preset',
                                    'class' => 'auth-input'
                                ]) ?>
                            </div>

                            <div class="col-md-6 auth-form-group">
                                <?= $this->Form->control('description', [
                                    'label' => 'Description',
                                    'placeholder' => 'Only required for custom items',
                                    'class' => 'auth-input'
                                ]) ?>
                            </div>

                            <div class="col-md-6 auth-form-group">
                                <?= $this->Form->control('quantity', [
                                    'type' => 'text',
                                    'label' => 'Quantity',
                                    'class' => 'auth-input',
                                    'required' => true
                                ]) ?>
                            </div>

                            <div class="col-md-6 auth-form-group">
                                <?= $this->Form->control('unit_price', [
                                    'type' => 'text',
                                    'label' => 'Unit Price (custom items only)',
                                    'placeholder' => 'Only required for custom items',
                                    'class' => 'auth-input'
                                ]) ?>
                            </div>

                        </div>

                        <div class="auth-form-actions">
                            <?= $this->Form->button(__('Add Item'), [
                                'name' => 'action',
                                'value' => 'add_item',
                                'class' => 'mh-btn-primary'
                            ]) ?>
                        </div>

                        <?= $this->Form->end() ?>
                    </div>

                    <div class="admin-table-card">
                        <div class="admin-table-header">
                            <h2><?= __('Invoice Items') ?></h2>
                        </div>

                        <?php if (!empty($invoice->invoice_items)): ?>
                            <div class="table-responsive">
                                <table class="table">
                                    <thead>
                                    <tr>
                                        <th><?= __('Description') ?></th>
                                        <th><?= __('Quantity') ?></th>
                                        <th><?= __('Unit Price') ?></th>
                                        <th><?= __('Line Total') ?></th>
                                        <th><?= __('Action') ?></th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php foreach ($invoice->invoice_items as $item): ?>
                                        <tr>
                                            <td><?= h($item->description) ?></td>
                                            <td><?= h($item->quantity) ?></td>
                                            <td>
                                                $<?= number_format(($item->unit_price_cents ?? 0) / 100, 2) ?>
                                            </td>
                                            <td>
                                                $<?= number_format(($item->line_total_cents ?? 0) / 100, 2) ?>
                                            </td>
                                            <td>
                                                <?= $this->Form->postLink(
                                                    __('Remove'),
                                                    ['action' => 'removeItem', $item->invoice_item_id],
                                                    [
                                                        'confirm' => __('Remove this invoice item?'),
                                                        'class' => 'admin-action-link'
                                                    ]
                                                ) ?>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                    </tbody>
                                    <tfoot>
                                    <tr>
                                        <th colspan="3" class="text-end"><?= __('Subtotal') ?></th>
                                        <th>
                                            $<?= number_format(($invoice->subtotal_cents ?? 0) / 100, 2) ?>
                                        </th>
                                        <th></th>
                                    </tr>
                                    <tr>
                                        <th colspan="3" class="text-end"><?= __('Total') ?></th>
                                        <th>
                                            $<?= number_format(($invoice->total_cents ?? 0) / 100, 2) ?>
                                        </th>
                                        <th></th>
                                    </tr>
                                    </tfoot>
                                </table>
                            </div>
                        <?php else: ?>
                            <p><?= __('No invoice items have been added yet.') ?></p>
                        <?php endif; ?>
                    </div>

                    <div class="auth-card auth-card-wide mt-4">
                        <div class="auth-header">
                            <h2 class="auth-title"><?= __('Finalise Invoice') ?></h2>
                            <p class="auth-subtitle">
                                <?= __('Once all invoice items have been added, you can send the invoice to the customer.') ?>
                            </p>
                        </div>

                        <div class="auth-form-actions">
                            <?php if (!empty($invoice->invoice_items)): ?>
                                <?= $this->Form->postLink(
                                    __('Finalise and Send Invoice'),
                                    ['action' => 'send', $invoice->invoice_id],
                                    [
                                        'confirm' => __('Are you sure you want to finalise and send this invoice?'),
                                        'class' => 'mh-btn-primary'
                                    ]
                                ) ?>
                            <?php else: ?>
                                <button class="mh-btn-primary" type="button" disabled>
                                    <?= __('Add at least one item before sending') ?>
                                </button>
                            <?php endif; ?>
                        </div>
                    </div>

                </div>

            </div>
        </div>
    </section>
</div>
