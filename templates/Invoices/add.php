<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Booking $booking
 * @var \App\Model\Entity\Invoice $invoice
 * @var array $presets
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('Back to Booking'), ['controller' => 'Bookings', 'action' => 'view', $booking->booking_id], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>

    <div class="column column-80">
        <div class="invoices form content">
            <h3><?= __('Generate Invoice for Booking #{0}', $booking->booking_id) ?></h3>

            <p><strong><?= __('Customer:') ?></strong> <?= h($booking->customer->first_name . ' ' . $booking->customer->last_name) ?></p>
            <p><strong><?= __('Email:') ?></strong> <?= h($booking->customer->email) ?></p>
            <p><strong><?= __('Job Type:') ?></strong> <?= h($booking->job_type->job_type_name ?? '') ?></p>
            <p><strong><?= __('Pickup:') ?></strong> <?= h($booking->pickup_address) ?></p>
            <p><strong><?= __('Dropoff:') ?></strong> <?= h($booking->dropoff_address) ?></p>

            <?= $this->Form->create($invoice) ?>
            <fieldset>
                <legend><?= __('Invoice Items') ?></legend>

                <?php for ($i = 0; $i < 5; $i++): ?>
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

            <?= $this->Form->button(__('Generate and Send Invoice')) ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>
