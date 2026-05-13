<?php
/**
 * @var \App\View\AppView $this
 * @var iterable<\App\Model\Entity\InventoryItem> $inventoryItems
 */
?>

<div class="mh-page-soft">
    <section class="admin-hero">
        <div class="container">
            <div class="admin-hero-shell">
                <div class="admin-hero-content">
                    <p class="admin-eyebrow"><?= __('Resources') ?></p>
                    <h1><?= __('Manage Inventory Items') ?></h1>
                    <p class="admin-hero-text">
                        <?= __('Review stock levels, storage locations, reorder thresholds, and inventory availability.') ?>
                    </p>
                </div>
            </div>
        </div>
    </section>

    <section class="admin-section">
        <div class="container">
            <div class="admin-table-card">
                <div class="admin-table-header">
                    <div>
                        <h2><?= __('Inventory Records') ?></h2>
                        <p><?= __('View, edit, and manage inventory items used across jobs and operations.') ?></p>
                    </div>

                    <?= $this->Html->link(
                        __('New Inventory Item'),
                        ['action' => 'add'],
                        ['class' => 'admin-primary-link']
                    ) ?>
                </div>

                <div class="admin-table-wrap">
                    <table class="admin-table">
                        <thead>
                        <tr>
                            <th><?= $this->Paginator->sort('inventory_item_id', 'ID') ?></th>
                            <th><?= $this->Paginator->sort('name', 'Name') ?></th>
                            <th><?= $this->Paginator->sort('category', 'Category') ?></th>
                            <th><?= $this->Paginator->sort('quantity_on_hand', 'Qty') ?></th>
                            <th><?= $this->Paginator->sort('reorder_threshold', 'Reorder') ?></th>
                            <th><?= $this->Paginator->sort('unit', 'Unit') ?></th>
                            <th><?= $this->Paginator->sort('storage_location', 'Location') ?></th>
                            <th><?= $this->Paginator->sort('is_active', 'Active') ?></th>
                            <th><?= $this->Paginator->sort('created', 'Created') ?></th>
                            <th><?= $this->Paginator->sort('modified', 'Modified') ?></th>
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
                                <td>
                                        <span class="admin-status-badge">
                                            <?= $inventoryItem->is_active ? __('Active') : __('Inactive') ?>
                                        </span>
                                </td>
                                <td><?= h($inventoryItem->created) ?></td>
                                <td><?= h($inventoryItem->modified) ?></td>
                                <td class="actions">
                                    <div class="admin-action-stack">
                                        <?= $this->Html->link(
                                            __('View'),
                                            ['action' => 'view', $inventoryItem->inventory_item_id],
                                            ['class' => 'admin-action-link']
                                        ) ?>

                                        <?= $this->Html->link(
                                            __('Edit'),
                                            ['action' => 'edit', $inventoryItem->inventory_item_id],
                                            ['class' => 'admin-action-link']
                                        ) ?>

                                        <?= $this->Form->postLink(
                                            __('Delete'),
                                            ['action' => 'delete', $inventoryItem->inventory_item_id],
                                            [
                                                'method' => 'delete',
                                                'confirm' => __('Are you sure you want to delete # {0}?', $inventoryItem->inventory_item_id),
                                                'class' => 'admin-action-link admin-action-link-danger',
                                            ]
                                        ) ?>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>

                <div class="admin-pagination">
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
</div>
