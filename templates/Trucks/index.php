<?php
/**
 * @var \App\View\AppView $this
 * @var iterable<\App\Model\Entity\Truck> $trucks
 */
?>

<div class="mh-page-soft">
    <section class="admin-hero">
        <div class="container">
            <div class="admin-hero-shell">
                <div class="admin-hero-content">
                    <p class="admin-eyebrow"><?= __('Resources') ?></p>
                    <h1><?= __('Manage Trucks') ?></h1>
                    <p class="admin-hero-text">
                        <?= __('Review truck records, check capacity and service details, and manage vehicle availability.') ?>
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
                        <h2><?= __('Truck Records') ?></h2>
                        <p><?= __('View, edit, and manage trucks used for removal and transport services.') ?></p>
                    </div>

                    <?= $this->Html->link(
                        __('New Truck'),
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
                                'placeholder' => 'Name, rego, location...',
                                'value' => $search ?? '',
                            ]) ?>
                        </div>

                        <div class="col-md-3">
                            <?= $this->Form->control('truck_size', [
                                'type' => 'select',
                                'label' => 'Truck Size',
                                'empty' => 'All Sizes',
                                'options' => $truckSizeOptions ?? [],
                                'default' => $truckSize ?? null,
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
                            <th><?= $this->Paginator->sort('name', 'Name') ?></th>
                            <th><?= $this->Paginator->sort('rego', 'Rego') ?></th>
                            <th><?= $this->Paginator->sort('truck_size', 'Size') ?></th>
                            <th><?= $this->Paginator->sort('capacity_m3', 'Capacity m³') ?></th>
                            <th><?= $this->Paginator->sort('max_payload_kg', 'Payload kg') ?></th>
                            <th><?= $this->Paginator->sort('current_location', 'Location') ?></th>
                            <th><?= $this->Paginator->sort('next_service_date', 'Next Service') ?></th>
                            <th><?= $this->Paginator->sort('is_active', 'Active') ?></th>
                            <th class="actions"><?= __('Actions') ?></th>
                        </tr>
                        </thead>

                        <tbody>
                        <?php foreach ($trucks as $truck): ?>
                            <tr>
                                <td><?= h($truck->name) ?></td>
                                <td><?= h($truck->rego) ?></td>
                                <td><?= h($truck->truck_size) ?></td>
                                <td>
                                    <?= $truck->capacity_m3 === null ? '' : $this->Number->format($truck->capacity_m3) ?>
                                </td>
                                <td>
                                    <?= $truck->max_payload_kg === null ? '' : $this->Number->format($truck->max_payload_kg) ?>
                                </td>
                                <td><?= h($truck->current_location) ?></td>
                                <td><?= h($truck->next_service_date) ?></td>
                                <td>
                                        <span class="admin-status-badge">
                                            <?= $truck->is_active ? __('Active') : __('Inactive') ?>
                                        </span>
                                </td>
                                <td class="actions">
                                    <div class="admin-action-stack">
                                        <?= $this->Html->link(
                                            __('View'),
                                            ['action' => 'view', $truck->truck_id],
                                            ['class' => 'admin-action-link']
                                        ) ?>

                                        <?= $this->Html->link(
                                            __('Edit'),
                                            ['action' => 'edit', $truck->truck_id],
                                            ['class' => 'admin-action-link']
                                        ) ?>

                                        <?= $this->Form->postLink(
                                            __('Delete'),
                                            ['action' => 'delete', $truck->truck_id],
                                            [
                                                'method' => 'delete',
                                                'confirm' => __('Are you sure you want to delete # {0}?', $truck->truck_id),
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
