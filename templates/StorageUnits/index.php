<?php
/**
 * @var \App\View\AppView $this
 * @var iterable<\App\Model\Entity\StorageUnit> $storageUnits
 */
?>

<div class="mh-page-soft">
    <section class="admin-hero">
        <div class="container">
            <div class="admin-hero-shell">
                <div class="admin-hero-content">
                    <p class="admin-eyebrow"><?= __('Resources') ?></p>
                    <h1><?= __('Manage Storage Units') ?></h1>
                    <p class="admin-hero-text">
                        <?= __('Review storage unit records, check availability, and manage facility storage resources.') ?>
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
                        <h2><?= __('Storage Unit Records') ?></h2>
                        <p><?= __('View, edit, and manage all storage units currently recorded in the system.') ?></p>
                    </div>

                    <?= $this->Html->link(
                        __('New Storage Unit'),
                        ['action' => 'add'],
                        ['class' => 'admin-primary-link']
                    ) ?>
                </div>

                <div class="admin-table-wrap">
                    <table class="admin-table">
                        <thead>
                        <tr>
                            <th><?= $this->Paginator->sort('storage_unit_id', 'ID') ?></th>
                            <th><?= $this->Paginator->sort('unit_code', 'Unit Code') ?></th>
                            <th><?= $this->Paginator->sort('facility_name', 'Facility') ?></th>
                            <th><?= $this->Paginator->sort('unit_size_m3', 'Size m³') ?></th>
                            <th><?= $this->Paginator->sort('status', 'Status') ?></th>
                            <th><?= $this->Paginator->sort('security_level', 'Security') ?></th>
                            <th><?= $this->Paginator->sort('is_climate_controlled', 'Climate Controlled') ?></th>
                            <th><?= $this->Paginator->sort('is_active', 'Active') ?></th>
                            <th><?= $this->Paginator->sort('created', 'Created') ?></th>
                            <th><?= $this->Paginator->sort('modified', 'Modified') ?></th>
                            <th class="actions"><?= __('Actions') ?></th>
                        </tr>
                        </thead>

                        <tbody>
                        <?php foreach ($storageUnits as $storageUnit): ?>
                            <tr>
                                <td><?= $this->Number->format($storageUnit->storage_unit_id) ?></td>
                                <td><?= h($storageUnit->unit_code) ?></td>
                                <td><?= h($storageUnit->facility_name) ?></td>
                                <td>
                                    <?= $storageUnit->unit_size_m3 === null ? '' : $this->Number->format($storageUnit->unit_size_m3) ?>
                                </td>
                                <td>
                                        <span class="admin-status-badge">
                                            <?= h($storageUnit->status) ?>
                                        </span>
                                </td>
                                <td><?= h($storageUnit->security_level) ?></td>
                                <td><?= $storageUnit->is_climate_controlled ? __('Yes') : __('No') ?></td>
                                <td>
                                        <span class="admin-status-badge">
                                            <?= $storageUnit->is_active ? __('Active') : __('Inactive') ?>
                                        </span>
                                </td>
                                <td><?= h($storageUnit->created) ?></td>
                                <td><?= h($storageUnit->modified) ?></td>
                                <td class="actions">
                                    <div class="admin-action-stack">
                                        <?= $this->Html->link(
                                            __('View'),
                                            ['action' => 'view', $storageUnit->storage_unit_id],
                                            ['class' => 'admin-action-link']
                                        ) ?>

                                        <?= $this->Html->link(
                                            __('Edit'),
                                            ['action' => 'edit', $storageUnit->storage_unit_id],
                                            ['class' => 'admin-action-link']
                                        ) ?>

                                        <?= $this->Form->postLink(
                                            __('Delete'),
                                            ['action' => 'delete', $storageUnit->storage_unit_id],
                                            [
                                                'method' => 'delete',
                                                'confirm' => __('Are you sure you want to delete # {0}?', $storageUnit->storage_unit_id),
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
