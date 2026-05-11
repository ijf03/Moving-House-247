<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\InventoryItem $inventoryItem
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('Edit Inventory Item'), ['action' => 'edit', $inventoryItem->inventory_item_id], ['class' => 'side-nav-item']) ?>
            <?= $this->Form->postLink(__('Delete Inventory Item'), ['action' => 'delete', $inventoryItem->inventory_item_id], ['confirm' => __('Are you sure you want to delete # {0}?', $inventoryItem->inventory_item_id), 'class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('List Inventory Items'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('New Inventory Item'), ['action' => 'add'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column column-80">
        <div class="inventoryItems view content">
            <h3><?= h($inventoryItem->name) ?></h3>
            <table>
                <tr>
                    <th><?= __('Name') ?></th>
                    <td><?= h($inventoryItem->name) ?></td>
                </tr>
                <tr>
                    <th><?= __('Category') ?></th>
                    <td><?= h($inventoryItem->category) ?></td>
                </tr>
                <tr>
                    <th><?= __('Unit') ?></th>
                    <td><?= h($inventoryItem->unit) ?></td>
                </tr>
                <tr>
                    <th><?= __('Storage Location') ?></th>
                    <td><?= h($inventoryItem->storage_location) ?></td>
                </tr>
                <tr>
                    <th><?= __('Inventory Item Id') ?></th>
                    <td><?= $this->Number->format($inventoryItem->inventory_item_id) ?></td>
                </tr>
                <tr>
                    <th><?= __('Quantity On Hand') ?></th>
                    <td><?= $this->Number->format($inventoryItem->quantity_on_hand) ?></td>
                </tr>
                <tr>
                    <th><?= __('Reorder Threshold') ?></th>
                    <td><?= $this->Number->format($inventoryItem->reorder_threshold) ?></td>
                </tr>
                <tr>
                    <th><?= __('Created') ?></th>
                    <td><?= h($inventoryItem->created) ?></td>
                </tr>
                <tr>
                    <th><?= __('Modified') ?></th>
                    <td><?= h($inventoryItem->modified) ?></td>
                </tr>
                <tr>
                    <th><?= __('Is Active') ?></th>
                    <td><?= $inventoryItem->is_active ? __('Yes') : __('No'); ?></td>
                </tr>
            </table>
        </div>
    </div>
</div>