<?php
/**
 * @var \App\View\AppView $this
 * @var iterable<\App\Model\Entity\InventoryItem> $inventoryItems
 */
?>
<div class="inventoryItems index content">
    <?= $this->Html->link(__('New Inventory Item'), ['action' => 'add'], ['class' => 'button float-right']) ?>
    <h3><?= __('Inventory Items') ?></h3>
    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th><?= $this->Paginator->sort('inventory_item_id') ?></th>
                    <th><?= $this->Paginator->sort('name') ?></th>
                    <th><?= $this->Paginator->sort('category') ?></th>
                    <th><?= $this->Paginator->sort('quantity_on_hand') ?></th>
                    <th><?= $this->Paginator->sort('reorder_threshold') ?></th>
                    <th><?= $this->Paginator->sort('unit') ?></th>
                    <th><?= $this->Paginator->sort('storage_location') ?></th>
                    <th><?= $this->Paginator->sort('is_active') ?></th>
                    <th><?= $this->Paginator->sort('created') ?></th>
                    <th><?= $this->Paginator->sort('modified') ?></th>
                    <th class="actions"><?= __('Actions') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($inventoryItems as $inventoryItem): ?>
                <tr>
                    <td><?= $this->Number->format($inventoryItem->inventory_item_id) ?></td>
                    <td><?= h($inventoryItem->name) ?></td>
                    <td><?= h($inventoryItem->category) ?></td>
                    <td><?= $this->Number->format($inventoryItem->quantity_on_hand) ?></td>
                    <td><?= $this->Number->format($inventoryItem->reorder_threshold) ?></td>
                    <td><?= h($inventoryItem->unit) ?></td>
                    <td><?= h($inventoryItem->storage_location) ?></td>
                    <td><?= h($inventoryItem->is_active) ?></td>
                    <td><?= h($inventoryItem->created) ?></td>
                    <td><?= h($inventoryItem->modified) ?></td>
                    <td class="actions">
                        <?= $this->Html->link(__('View'), ['action' => 'view', $inventoryItem->inventory_item_id]) ?>
                        <?= $this->Html->link(__('Edit'), ['action' => 'edit', $inventoryItem->inventory_item_id]) ?>
                        <?= $this->Form->postLink(
                            __('Delete'),
                            ['action' => 'delete', $inventoryItem->inventory_item_id],
                            [
                                'method' => 'delete',
                                'confirm' => __('Are you sure you want to delete # {0}?', $inventoryItem->inventory_item_id),
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