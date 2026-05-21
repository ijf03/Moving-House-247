<?php
/**
 * @var \App\View\AppView $this
 * @var iterable<\App\Model\Entity\Staff> $staff
 */
?>
<div class="mh-page-soft">
    <section class="admin-hero">
        <div class="container">
            <div class="admin-hero-shell">
                <div class="admin-hero-content">
                    <p class="admin-eyebrow">Admin Dashboard</p>
                    <h1>Staff</h1>
                    <p class="admin-hero-text">
                        View registered users, manage account details, and keep staff and customer records organised.
                    </p>
                </div>
            </div>
        </div>
    </section>

    <section class="admin-section">
        <div class="container">
            <div class="admin-table-card">
                <div class="admin-table-header admin-table-header-split">
                    <div>
                        <h2>Staff Directory</h2>
                        <p>Browse all visible user records and manage account access.</p>
                    </div>
                    <?php if ($isAdmin) : ?>
                        <?= $this->Html->link(__('New Staff'), ['action' => 'add'], ['class' => 'admin-primary-link']) ?>
                    <?php endif; ?>
                </div>
                <div class="admin-filter-card">
                    <?= $this->Form->create(null, ['type' => 'get', 'class' => 'admin-filter-form mh-form']) ?>
                    <div class="row g-3">
                        <div class="col-md-6">
                            <?= $this->Form->control('search', [
                                'label' => 'Search',
                                'placeholder' => 'Name, email, phone',
                                'value' => $search ?? '',
                            ]) ?>
                        </div>

                        <div class="col-md-6">
                            <?= $this->Form->control('driver', [
                                'type' => 'select',
                                'label' => 'Driver',
                                'empty' => 'All Staff',
                                'options' => ['1' => 'Yes', '0' => 'No'],
                                'default' => $driver ?? null,
                            ]) ?>
                        </div>
                    </div>
                    <div class="admin-filter-actions">
                        <?= $this->Form->button(__('Apply Filters'), ['class' => 'admin-primary-link admin-primary-button']) ?>
                        <?= $this->Html->link(__('Reset'), ['action' => 'index'], ['class' => 'admin-action-link']) ?>
                    </div>
                    <?= $this->Form->end() ?>
                </div>
                <div class="table-responsive">
                    <table>
                        <thead>
                        <tr>
                            <th><?= $this->Paginator->sort('first_name') ?></th>
                            <th><?= $this->Paginator->sort('last_name') ?></th>
                            <th><?= $this->Paginator->sort('email') ?></th>
                            <th><?= $this->Paginator->sort('phone') ?></th>
                            <th><?= $this->Paginator->sort('Owns a driver license') ?></th>
                            <th class="actions"><?= __('Actions') ?></th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php foreach ($staff as $staffEntity):
                            if ($staffEntity->email == $userEmail || $isAdmin) { ?>
                                <tr>
                                    <td><?= h($staffEntity->first_name) ?></td>
                                    <td><?= h($staffEntity->last_name) ?></td>
                                    <td><?= h($staffEntity->email) ?></td>
                                    <td><?= h($staffEntity->phone) ?></td>
                                    <td><?= h($staffEntity->isDriverText) ?></td>
                                    <td class="actions">
                                        <?= $this->Html->link(__('View'), ['action' => 'view', $staffEntity->staff_id], ['class' => 'admin-action-link']) ?>
                                        <?= $this->Html->link(__('Edit'), ['action' => 'edit', $staffEntity->staff_id], ['class' => 'admin-action-link']) ?>
                                        <?= $this->Html->link(__('Availability'), ['action' => 'availability', $staffEntity->staff_id], ['class' => 'admin-action-link']) ?>
                                        <?= $this->Form->postLink(
                                            __('Delete'),
                                            ['action' => 'delete', $staffEntity->staff_id],
                                            [
                                                'method' => 'delete',
                                                'confirm' => __('Are you sure you want to delete {0}?', $staffEntity->full_name),
                                                'class' => 'admin-action-link admin-action-link-danger'
                                            ]
                                        ) ?>
                                    </td>
                                </tr>
                            <?php }
                        endforeach; ?>
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
