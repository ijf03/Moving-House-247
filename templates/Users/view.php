<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\User $user
 */
?>

<div class="mh-page-soft">
    <section class="admin-hero">
        <div class="container">
            <div class="admin-hero-shell">
                <div class="admin-hero-content">
                    <span class="admin-eyebrow"><?= __('Admin') ?></span>
                    <h1><?= __('View User') ?></h1>
                    <p class="admin-hero-text">
                        <?= __('Review this user’s account information and manage available actions.') ?>
                    </p>
                </div>
            </div>
        </div>
    </section>

    <section class="admin-section">
        <div class="container">
            <div class="row g-4 justify-content-center">
                <div class="col-lg-3">
                    <div class="mh-back-btn m-1">
                        <?= $this->Html->link(__('← Back to List'), ['action' => 'index']) ?>
                    </div>
                    <div class="admin-table-card">
                        <div class="admin-table-header">
                            <h2><?= __('Actions') ?></h2>
                            <p><?= __('Manage this user record.') ?></p>
                        </div>

                        <div class="admin-action-stack">
                            <?= $this->Html->link(__('Edit User'), ['action' => 'edit', $user->user_id], ['class' => 'admin-action-link']) ?>

                            <?= $this->Form->postLink(
                                __('Delete User'),
                                ['action' => 'delete', $user->user_id],
                                [
                                    'confirm' => __('Are you sure you want to delete # {0}?', $user->user_id),
                                    'class' => 'admin-action-link admin-action-link-danger'
                                ]
                            ) ?>
                        </div>
                    </div>
                </div>

                <div class="col-lg-9">
                    <div class="admin-table-card">
                        <div class="admin-table-header">
                            <h2><?= h($user->first_name . ' ' . $user->last_name) ?></h2>
                            <p><?= h($user->email) ?></p>
                        </div>

                        <div class="row g-3">
                            <div class="col-md-6">
                                <div class="mh-info-card">
                                    <div>
                                        <h3><?= __('User ID') ?></h3>
                                        <p><?= $this->Number->format($user->user_id) ?></p>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="mh-info-card">
                                    <div>
                                        <h3><?= __('Phone') ?></h3>
                                        <p><?= h($user->phone) ?></p>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="mh-info-card">
                                    <div>
                                        <h3><?= __('Email') ?></h3>
                                        <p><?= h($user->email) ?></p>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="mh-info-card">
                                    <div>
                                        <h3><?= __('First Name') ?></h3>
                                        <p><?= h($user->first_name) ?></p>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="mh-info-card">
                                    <div>
                                        <h3><?= __('Last Name') ?></h3>
                                        <p><?= h($user->last_name) ?></p>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="mh-info-card">
                                    <div>
                                        <h3><?= __('User Type') ?></h3>
                                        <p>
                                            <span class="admin-role-badge">
                                                <?= h($user->user_type_name) ?>
                                            </span>
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
