<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\InventoryItem $inventoryItem
 */
?>

<div class="mh-page-soft">
    <section class="admin-hero">
        <div class="container">
            <div class="admin-hero-shell">
                <div class="admin-hero-content">
                    <span class="admin-eyebrow"><?= __('Resources') ?></span>
                    <h1><?= h($inventoryItem->name) ?></h1>
                    <p class="admin-hero-text">
                        <?= __('View inventory details, stock levels, storage location, and reorder information.') ?>
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
                            <p><?= __('Manage this inventory item record.') ?></p>
                        </div>

                        <div class="admin-action-stack">
                            <?= $this->Html->link(__('Edit Inventory Item'), ['action' => 'edit', $inventoryItem->inventory_item_id], ['class' => 'admin-action-link']) ?>

                            <?= $this->Html->link(__('List Inventory Items'), ['action' => 'index'], ['class' => 'admin-action-link']) ?>

                            <?= $this->Html->link(__('New Inventory Item'), ['action' => 'add'], ['class' => 'admin-action-link']) ?>

                            <?= $this->Form->postLink(
                                __('Delete Inventory Item'),
                                ['action' => 'delete', $inventoryItem->inventory_item_id],
                                [
                                    'confirm' => __('Are you sure you want to delete # {0}?', $inventoryItem->inventory_item_id),
                                    'class' => 'admin-action-link admin-action-link-danger',
                                ]
                            ) ?>
                        </div>
                    </div>
                </div>

                <div class="col-lg-9">
                    <div class="admin-table-card">
                        <div class="admin-table-header">
                            <h2><?= __('Inventory Item Information') ?></h2>
                            <p><?= __('Detailed information for this inventory item.') ?></p>
                        </div>

                        <div class="table-responsive">
                            <table class="table admin-table">
                                <tbody>
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
                                    <th><?= __('Inventory Item ID') ?></th>
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
                                    <th><?= __('Active') ?></th>
                                    <td><?= $inventoryItem->is_active ? __('Yes') : __('No') ?></td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
