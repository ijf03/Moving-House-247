<?php
/**
 * @var \App\View\AppView $this
 * @var iterable<\App\Model\Entity\Equipment> $equipment
 */
?>

<div class="mh-page-soft">
    <section class="admin-hero">
        <div class="container">
            <div class="admin-hero-shell">
                <div class="admin-hero-content">
                    <p class="admin-eyebrow"><?= __('Resources') ?></p>
                    <h1><?= __('Manage Equipment') ?></h1>
                    <p class="admin-hero-text">
                        <?= __('Review equipment records, check availability, monitor condition, and manage operational resources.') ?>
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
                        <h2><?= __('Equipment Records') ?></h2>
                        <p><?= __('View, edit, and manage equipment items used across jobs and operations.') ?></p>
                    </div>

                    <?= $this->Html->link(
                        __('New Equipment'),
                        ['action' => 'add'],
                        ['class' => 'admin-primary-link']
                    ) ?>
                </div>

                <div class="admin-table-wrap">
                    <table class="admin-table">
                        <thead>
                        <tr>
                            <th><?= $this->Paginator->sort('equipment_id', 'ID') ?></th>
                            <th><?= $this->Paginator->sort('name', 'Name') ?></th>
                            <th><?= $this->Paginator->sort('category', 'Category') ?></th>
                            <th><?= $this->Paginator->sort('quantity_available', 'Quantity') ?></th>
                            <th><?= $this->Paginator->sort('status', 'Status') ?></th>
                            <th><?= $this->Paginator->sort('storage_location', 'Location') ?></th>
                            <th><?= $this->Paginator->sort('is_active', 'Active') ?></th>
                            <th><?= $this->Paginator->sort('created', 'Created') ?></th>
                            <th><?= $this->Paginator->sort('modified', 'Modified') ?></th>
                            <th class="actions"><?= __('Actions') ?></th>
                        </tr>
                        </thead>

                        <tbody>
                        <?php foreach ($equipment as $equipmentEntity): ?>
                            <tr>
                                <td><?= $this->Number->format($equipmentEntity->equipment_id) ?></td>
                                <td><?= h($equipmentEntity->name) ?></td>
                                <td><?= h($equipmentEntity->category) ?></td>
                                <td><?= $this->Number->format($equipmentEntity->quantity_available) ?></td>
                                <td>
                                        <span class="admin-status-badge">
                                            <?= h($equipmentEntity->status) ?>
                                        </span>
                                </td>
                                <td><?= h($equipmentEntity->storage_location) ?></td>
                                <td>
                                        <span class="admin-status-badge">
                                            <?= $equipmentEntity->is_active ? __('Active') : __('Inactive') ?>
                                        </span>
                                </td>
                                <td><?= h($equipmentEntity->created) ?></td>
                                <td><?= h($equipmentEntity->modified) ?></td>
                                <td class="actions">
                                    <div class="admin-action-stack">
                                        <?= $this->Html->link(
                                            __('View'),
                                            ['action' => 'view', $equipmentEntity->equipment_id],
                                            ['class' => 'admin-action-link']
                                        ) ?>

                                        <?= $this->Html->link(
                                            __('Edit'),
                                            ['action' => 'edit', $equipmentEntity->equipment_id],
                                            ['class' => 'admin-action-link']
                                        ) ?>

                                        <?= $this->Form->postLink(
                                            __('Delete'),
                                            ['action' => 'delete', $equipmentEntity->equipment_id],
                                            [
                                                'method' => 'delete',
                                                'confirm' => __('Are you sure you want to delete # {0}?', $equipmentEntity->equipment_id),
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
