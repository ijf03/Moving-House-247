<?php
/**
 * @var \App\View\AppView $this
 * @var iterable<\App\Model\Entity\User> $users
 */
$identity = $this->request->getAttribute('identity');
$userId = $identity ? $identity->get('user_id') : null;
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
                    $isAdmin
                        ? $this->Html->link(__('New User'), ['action' => 'add'], ['class' => 'admin-primary-link'])
                        : null
                    ?>
                </div>

                <div class="admin-table-wrap">
                    <table class="admin-table">
                        <thead>
                        <tr>
                            <th><?= $this->Paginator->sort('email') ?></th>
                            <th><?= $this->Paginator->sort('first_name') ?></th>
                            <th><?= $this->Paginator->sort('last_name') ?></th>
                            <th><?= $this->Paginator->sort('user_type') ?></th>
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
                                            <?= $this->Html->link(__('View'), ['action' => 'view', $user->user_id], ['class' => 'admin-action-link']) ?>
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
