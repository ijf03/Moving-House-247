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

                <div class="admin-filter-card">
                    <?= $this->Form->create(null, ['type' => 'get', 'class' => 'admin-filter-form mh-form']) ?>
                    <div class="row g-3">
                        <div class="col-md-3">
                            <?= $this->Form->control('search', [
                                'label' => 'Search',
                                'placeholder' => 'Unit code, facility, security...',
                                'value' => $search ?? '',
                            ]) ?>
                        </div>

                        <div class="col-md-3">
                            <?= $this->Form->control('security_level', [
                                'type' => 'select',
                                'label' => 'Security Level',
                                'empty' => 'All Security Levels',
                                'options' => $securityLevelOptions ?? [],
                                'default' => $securityLevel ?? null,
                            ]) ?>
                        </div>

                        <div class="col-md-3">
                            <?= $this->Form->control('is_active', [
                                'type' => 'select',
                                'label' => 'Active',
                                'empty' => 'All',
                                'options' => [1 => 'Active', 0 => 'Inactive'],
                                'default' => $isActive ?? null,
                            ]) ?>
                        </div>
                    </div>

                    <div class="admin-filter-actions">
                        <?= $this->Form->button(__('Apply Filters'), ['class' => 'admin-primary-link admin-primary-button']) ?>
                        <?= $this->Html->link(__('Reset'), ['action' => 'index'], ['class' => 'admin-action-link']) ?>
                    </div>
                    <?= $this->Form->end() ?>
                </div>

                <div class="admin-table-wrap">
                    <table class="admin-table">
                        <thead>
                        <tr>
                            <th><?= $this->Paginator->sort('storage_unit_id', 'ID') ?></th>
                            <th><?= $this->Paginator->sort('facility_name', 'Facility') ?></th>
                            <th><?= $this->Paginator->sort('unit_code', 'Unit Code') ?></th>
                            <th><?= $this->Paginator->sort('unit_size_m3', 'Size (m³)') ?></th>
                            <th><?= $this->Paginator->sort('security_level', 'Security') ?></th>
                            <th><?= $this->Paginator->sort('is_climate_controlled', 'Climate Controlled') ?></th>
                            <th><?= $this->Paginator->sort('is_active', 'Active') ?></th>
                            <th class="actions"><?= __('Actions') ?></th>
                        </tr>
                        </thead>

                        <tbody>
                        <?php foreach ($storageUnits as $storageUnit): ?>
                            <tr>
                                <td><?= $this->Number->format($storageUnit->storage_unit_id) ?></td>
                                <td><?= h($storageUnit->facility_name) ?></td>
                                <td><?= h($storageUnit->unit_code) ?></td>
                                <td>
                                    <?= $storageUnit->unit_size_m3 === null ? '' : $this->Number->format($storageUnit->unit_size_m3) ?>
                                </td>
                                <td><?= h(ucfirst($storageUnit->security_level)) ?></td>
                                <td><?= $storageUnit->is_climate_controlled ? __('Yes') : __('No') ?></td>
                                <td>
                                        <span class="admin-status-badge">
                                            <?= $storageUnit->is_active ? __('Active') : __('Inactive') ?>
                                        </span>
                                </td>
                                <td class="actions">
                                    <div class="admin-action-stack">
                                        <?= $this->Html->link(
                                            ' &nbsp;'.__('View'),
                                            ['action' => 'view', $storageUnit->storage_unit_id],
                                            ['class' => 'admin-action-link','escape'=>false]
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

                <div class="admin-paginator">
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
