<?php
/**
 * @var \App\View\AppView $this
 * @var iterable<\App\Model\Entity\InvoiceItemPreset> $invoiceItemPresets
 */
?>
<div class="invoiceItemPresets index content">
    <?= $this->Html->link(__('New Invoice Item Preset'), ['action' => 'add'], ['class' => 'button float-right']) ?>
    <h3><?= __('Invoice Item Presets') ?></h3>
    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th><?= $this->Paginator->sort('invoice_item_preset_id') ?></th>
                    <th><?= $this->Paginator->sort('code') ?></th>
                    <th><?= $this->Paginator->sort('name') ?></th>
                    <th><?= $this->Paginator->sort('description') ?></th>
                    <th><?= $this->Paginator->sort('unit_price_cents') ?></th>
                    <th><?= $this->Paginator->sort('is_active') ?></th>
                    <th><?= $this->Paginator->sort('sort_order') ?></th>
                    <th><?= $this->Paginator->sort('created') ?></th>
                    <th><?= $this->Paginator->sort('modified') ?></th>
                    <th class="actions"><?= __('Actions') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($invoiceItemPresets as $invoiceItemPreset): ?>
                <tr>
                    <td><?= $this->Number->format($invoiceItemPreset->invoice_item_preset_id) ?></td>
                    <td><?= h($invoiceItemPreset->code) ?></td>
                    <td><?= h($invoiceItemPreset->name) ?></td>
                    <td><?= h($invoiceItemPreset->description) ?></td>
                    <td><?= $this->Number->format($invoiceItemPreset->unit_price_cents) ?></td>
                    <td><?= h($invoiceItemPreset->is_active) ?></td>
                    <td><?= $this->Number->format($invoiceItemPreset->sort_order) ?></td>
                    <td><?= h($invoiceItemPreset->created) ?></td>
                    <td><?= h($invoiceItemPreset->modified) ?></td>
                    <td class="actions">
                        <?= $this->Html->link(__('View'), ['action' => 'view', $invoiceItemPreset->invoice_item_preset_id]) ?>
                        <?= $this->Html->link(__('Edit'), ['action' => 'edit', $invoiceItemPreset->invoice_item_preset_id]) ?>
                        <?= $this->Form->postLink(
                            __('Delete'),
                            ['action' => 'delete', $invoiceItemPreset->invoice_item_preset_id],
                            [
                                'method' => 'delete',
                                'confirm' => __('Are you sure you want to delete # {0}?', $invoiceItemPreset->invoice_item_preset_id),
                            ]
                        ) ?>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <div class="paginator">
        <ul class="pagination">
            <?= $this->Paginator->first('<< ' . __('first')) ?>
            <?= $this->Paginator->prev('< ' . __('previous')) ?>
            <?= $this->Paginator->numbers() ?>
            <?= $this->Paginator->next(__('next') . ' >') ?>
            <?= $this->Paginator->last(__('last') . ' >>') ?>
        </ul>
        <p><?= $this->Paginator->counter(__('Page {{page}} of {{pages}}, showing {{current}} record(s) out of {{count}} total')) ?></p>
    </div>
</div>