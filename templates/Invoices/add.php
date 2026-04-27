<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Booking $booking
 * @var \App\Model\Entity\Invoice $invoice
 * @var array $presets
 */
?>
<div class="mh-page-soft">
    <section class="admin-hero">
        <div class="container">
            <div class="admin-hero-shell">
                <div class="admin-hero-content">
                    <span class="admin-eyebrow"><?= __('Admin') ?></span>
                    <h1><?= __('Create Invoice') ?></h1>
                    <p class="admin-hero-text">
                        <?= __('Generate a new invoice for a booking.') ?>
                    </p>
                </div>
            </div>
        </div>
    </section>

    <section class="admin-section">
        <div class="container">
            <div class="row g-4 justify-content-center">

                <!-- Actions -->
                <div class="col-lg-3">
                    <div class="admin-table-card">
                        <div class="admin-table-header">
                            <h2><?= __('Actions') ?></h2>
                        </div>

                        <div class="admin-action-stack">
                            <?= $this->Html->link(__('Back to Invoices'), ['action' => 'index'], ['class' => 'admin-action-link']) ?>
                        </div>
                    </div>
                </div>

                <!-- Form -->
                <div class="col-lg-9">
                    <div class="auth-card auth-card-wide">
                        <div class="auth-header">
                            <h2 class="auth-title"><?= __('New Invoice') ?></h2>
                            <p class="auth-subtitle">
                                <?= __('Fill in the details to generate an invoice.') ?>
                            </p>
                        </div>

                        <?= $this->Form->create($invoice, ['class' => 'auth-form']) ?>

                        <div class="row g-3">

<legend><?= __('Invoice Items') ?></legend>

                <?php for ($i = 0; $i < 3; $i++): ?>
                    <div style="border:1px solid #ddd; padding:12px; margin-bottom:12px;">
                        <?= $this->Form->control("items.$i.preset", [
                            'type' => 'select',
                            'label' => 'Preset',
                            'options' => array_merge(['' => 'Custom item'], array_combine(
                                array_keys(array_filter($presets, fn($k) => $k !== '', ARRAY_FILTER_USE_KEY)),
                                array_map(
                                    fn($p) => is_array($p) ? $p['description'] . ' ($' . number_format($p['unit_price_cents'] / 100, 2) . ')' : '',
                                    array_filter($presets, fn($k) => $k !== '', ARRAY_FILTER_USE_KEY)
                                )
                            )),
                            'empty' => false,
                        ]) ?>

                        <?= $this->Form->control("items.$i.description", [
                            'label' => 'Description',
                        ]) ?>

                        <?= $this->Form->control("items.$i.quantity", [
                            'type' => 'number',
                            'step' => '0.01',
                            'min' => '0',
                            'label' => 'Quantity',
                        ]) ?>

                        <?= $this->Form->control("items.$i.unit_price", [
                            'type' => 'number',
                            'step' => '0.01',
                            'min' => '0',
                            'label' => 'Unit Price (AUD)',
                        ]) ?>
                    </div>
                <?php endfor; ?>
            </fieldset>


                            <div class="col-md-6 auth-form-group">
                                <?= $this->Form->control('due_date', [
                                    'type' => 'date',
                                    'label' => 'Due Date',
                                    'class' => 'auth-input'
                                ]) ?>
                            </div>

                        </div>

                        <div class="auth-form-actions">
                            <?= $this->Form->button(__('Create Invoice'), ['class' => 'mh-btn-primary']) ?>
                        </div>

                        <?= $this->Form->end() ?>
                    </div>
                </div>

            </div>
        </div>
    </section>
</div>
