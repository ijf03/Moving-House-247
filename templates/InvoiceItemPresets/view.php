<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\InvoiceItemPreset $invoiceItemPreset
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('Edit Invoice Item Preset'), ['action' => 'edit', $invoiceItemPreset->invoice_item_preset_id], ['class' => 'side-nav-item']) ?>
            <?= $this->Form->postLink(__('Delete Invoice Item Preset'), ['action' => 'delete', $invoiceItemPreset->invoice_item_preset_id], ['confirm' => __('Are you sure you want to delete # {0}?', $invoiceItemPreset->invoice_item_preset_id), 'class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('List Invoice Item Presets'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('New Invoice Item Preset'), ['action' => 'add'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column column-80">
        <div class="invoiceItemPresets view content">
            <h3><?= h($invoiceItemPreset->name) ?></h3>
            <table>
                <tr>
                    <th><?= __('Code') ?></th>
                    <td><?= h($invoiceItemPreset->code) ?></td>
                </tr>
                <tr>
                    <th><?= __('Name') ?></th>
                    <td><?= h($invoiceItemPreset->name) ?></td>
                </tr>
                <tr>
                    <th><?= __('Description') ?></th>
                    <td><?= h($invoiceItemPreset->description) ?></td>
                </tr>
                <tr>
                    <th><?= __('Invoice Item Preset Id') ?></th>
                    <td><?= $this->Number->format($invoiceItemPreset->invoice_item_preset_id) ?></td>
                </tr>
                <tr>
                    <th><?= __('Unit Price Cents') ?></th>
                    <td><?= $this->Number->format($invoiceItemPreset->unit_price_cents) ?></td>
                </tr>
                <tr>
                    <th><?= __('Sort Order') ?></th>
                    <td><?= $this->Number->format($invoiceItemPreset->sort_order) ?></td>
                </tr>
                <tr>
                    <th><?= __('Created') ?></th>
                    <td><?= h($invoiceItemPreset->created) ?></td>
                </tr>
                <tr>
                    <th><?= __('Modified') ?></th>
                    <td><?= h($invoiceItemPreset->modified) ?></td>
                </tr>
                <tr>
                    <th><?= __('Is Active') ?></th>
                    <td><?= $invoiceItemPreset->is_active ? __('Yes') : __('No'); ?></td>
                </tr>
            </table>
        </div>
    </div>
</div>