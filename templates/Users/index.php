<?php
/**
 * @var \App\View\AppView $this
 * @var iterable<\App\Model\Entity\User> $users
 * @var bool $isAdmin
 * @var string|null $search
 * @var string|int|null $userTypeId
 * @var iterable $userTypes
 */

$identity = $this->request->getAttribute('identity');
$userId = $identity ? $identity->get('user_id') : null;
$isAdmin = $isAdmin ?? false;
?>

<div class="mh-page-soft">
    <section class="admin-hero">
        <div class="container">
            <div class="admin-hero-shell">
                <div class="admin-hero-content">
                    <p class="admin-eyebrow">Admin Dashboard</p>
                    <h1>Users</h1>
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
                        <h2>User Directory</h2>
                        <p>Browse all visible user records and manage account access.</p>
                    </div>

                    <?=
                    ($isAdmin ?? false)
                        ? $this->Html->link(__('New User'), ['action' => 'add'], ['class' => 'admin-primary-link'])
                        : ''
                    ?>
                </div>

                <div class="admin-filter-card">
                    <?= $this->Form->create(null, ['type' => 'get', 'class' => 'admin-filter-form mh-form']) ?>
                    <div class="row g-3">
                        <div class="col-md-6">
                            <?= $this->Form->control('search', [
                                'label' => 'Search',
                                'placeholder' => 'Name, email, phone, role...',
                                'value' => $search ?? '',
                            ]) ?>
                        </div>

                        <div class="col-md-6">
                            <?= $this->Form->control('user_type', [
                                'type' => 'select',
                                'label' => 'User Type',
                                'empty' => 'All User Types',
                                'options' => $userTypes ?? [],
                                'default' => $userTypeId ?? null,
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
                            <th><?= $this->Paginator->sort('email', 'Email') ?></th>
                            <th><?= $this->Paginator->sort('first_name', 'First Name') ?></th>
                            <th><?= $this->Paginator->sort('last_name', 'Last Name') ?></th>
                            <th><?= $this->Paginator->sort('UserTypes.name', 'User Type') ?></th>
                            <th class="actions"><?= __('Actions') ?></th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php foreach ($users as $user): ?>
                            <?php if ($user->user_id == $userId || $isAdmin): ?>
                                <tr>
                                    <td><?= h($user->email) ?></td>
                                    <td><?= h($user->first_name) ?></td>
                                    <td><?= h($user->last_name) ?></td>
                                    <td>
                                        <span class="admin-role-badge">
                                            <?= h($user->user_type_name) ?>
                                        </span>
                                    </td>
                                    <td class="actions">
                                        <div class="admin-action-stack">
                                            <?= $this->Html->link(' &nbsp;'.__('View'), ['action' => 'view', $user->user_id], ['class' => 'admin-action-link', 'escape'=>false]) ?>
                                            <?= $this->Html->link(__('Edit'), ['action' => 'edit', $user->user_id], ['class' => 'admin-action-link']) ?>
                                            <?= $this->Form->postLink(
                                                __('Delete'),
                                                ['action' => 'delete', $user->user_id],
                                                [
                                                    'method' => 'delete',
                                                    'confirm' => __('Are you sure you want to delete {0}?', $user->full_name),
                                                    'class' => 'admin-action-link admin-action-link-danger'
                                                ]
                                            ) ?>
                                        </div>
                                    </td>
                                </tr>
                            <?php endif; ?>
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
                    <p><?= $this->Paginator->counter(__('Page {{page}} of {{pages}}, showing {{current}} record(s) out of {{count}} total')) ?></p>
                </div>
            </div>
        </div>
    </section>
</div>
