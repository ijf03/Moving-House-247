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
                    <h1><?= __('Edit User') ?></h1>
                    <p class="admin-hero-text">
                        <?= __('Update account details, credentials, and role information for this user.') ?>
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
                            <p><?= __('Manage this user account.') ?></p>
                        </div>

                        <div class="admin-action-stack">
                            <?= $this->Form->postLink(
                                __('Delete'),
                                ['action' => 'delete', $user->user_id],
                                [
                                    'confirm' => __('Are you sure you want to delete # {0}?', $user->user_id),
                                    'class' => 'admin-action-link admin-action-link-danger',
                                ],
                            ) ?>

                            <?= $this->Html->link(__('List Users'), ['action' => 'index'], ['class' => 'admin-action-link']) ?>
                        </div>
                    </div>
                </div>

                <div class="col-lg-9">
                    <div class="auth-card auth-card-wide">
                        <div class="auth-header">
                            <h2 class="auth-title"><?= __('Edit User') ?></h2>
                            <p class="auth-subtitle">
                                <?= __('Make changes below and save when you are done.') ?>
                            </p>
                        </div>

                        <?= $this->Form->create($user, ['class' => 'auth-form']) ?>

                        <div class="row g-3">
                            <div class="col-md-6 auth-form-group">
                                <?= $this->Form->control('first_name', [
                                    'label' => 'First Name*',
                                    'placeholder' => 'Enter first name',
                                    'class' => 'auth-input',
                                    'required' => true,
                                ]) ?>
                            </div>

                            <div class="col-md-6 auth-form-group">
                                <?= $this->Form->control('last_name', [
                                    'label' => 'Last Name*',
                                    'placeholder' => 'Enter last name',
                                    'class' => 'auth-input',
                                    'required' => true,
                                ]) ?>
                            </div>

                            <div class="col-md-6 auth-form-group">
                                <?= $this->Form->control('email', [
                                    'label' => 'Email*',
                                    'placeholder' => 'Enter email address',
                                    'class' => 'auth-input',
                                    'required' => true,
                                ]) ?>
                            </div>

                            <div class="col-md-6 auth-form-group">
                                <?= $this->Form->control('phone', [
                                    'label' => 'Phone*',
                                    'placeholder' => 'Enter phone number',
                                    'class' => 'auth-input',
                                    'required' => true,
                                ]) ?>
                            </div>

                            <div class="col-md-6 auth-form-group">
                                <?= $this->Form->control('password', [
                                    'type' => 'password',
                                    'label' => 'Password',
                                    'placeholder' => 'Leave blank to keep current password',
                                    'class' => 'auth-input',
                                    'required' => false,
                                    'value' => '',
                                ]) ?>
                            </div>

                            <div class="col-md-6 auth-form-group">
                                <?= $this->Form->control('confirm_password', [
                                    'type' => 'password',
                                    'label' => 'Confirm Password',
                                    'placeholder' => 'Re-enter new password',
                                    'class' => 'auth-input',
                                    'required' => false,
                                ]) ?>
                            </div>

                            <?php if ($userTypes) : ?>
                                <div class="col-md-6 auth-form-group">
                                    <?= $this->Form->control('user_type', [
                                        'options' => $userTypes,
                                        'label' => 'User Role',
                                        'class' => 'auth-input',
                                    ]) ?>
                                </div>
                            <?php endif; ?>
                        </div>

                        <div class="auth-form-actions">
                            <?= $this->Form->button(__('Save Changes'), ['class' => 'mh-btn-primary']) ?>
                        </div>

                        <?= $this->Form->end() ?>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
