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

                <div class="col-lg-9">
                    <div class="auth-card auth-card-wide">
                        <div class="auth-header">
                            <h2 class="auth-title"><?= __('New Invoice') ?></h2>

                            <div class="d-flex justify-content-center mt-5 mb-5">
                                <p class="auth-subtitle text-center">
                                    <?= __('Fill in the details to generate an invoice.') ?>
                                </p>
                            </div>
                        </div>

                        <?= $this->Form->create($invoice, ['class' => 'auth-form']) ?>

                        <div class="row g-3">

                            <div class="col-md-6 auth-form-group">
                                <?= $this->Form->control('booking_id', [
                                    'empty' => 'Select a booking',
                                    'options' => $bookings,
                                    'label' => 'Booking',
                                    'class' => 'auth-input'
                                ]) ?>
                            </div>

                            <div class="col-md-6 auth-form-group">
                                <?= $this->Form->control('status_display', [
                                    'type' => 'text',
                                    'value' => 'Pending',
                                    'readonly' => true,
                                    'label' => 'Status',
                                    'class' => 'auth-input'
                                ]) ?>
                            </div>

                            <div class="col-md-6 auth-form-group">
                                <?= $this->Form->control('due_date', [
                                    'type' => 'date',
                                    'label' => 'Due Date',
                                    'class' => 'auth-input',
                                    'min' => date('d-m-Y')
                                ]) ?>
                            </div>

                        </div>

                        <div class="auth-form-actions">
                            <?= $this->Form->button(__('Create Invoice and add items'), ['class' => 'mh-btn-primary']) ?>
                        </div>

                        <?= $this->Form->end() ?>
                    </div>
                </div>

            </div>
        </div>
    </section>
</div>
