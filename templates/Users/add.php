<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\User $user
 */
?>
<head>
<script>
    window.addEventListener('load', ()=> {
        const user_types = <?= json_encode($userTypes); ?>;
        isDriver = document.getElementById('isDriver');
        isDriver.style.display = (user_types[document.getElementById('user_type').value]) == 'Staff' ? 'block' : 'none';
        isDriver_checkbox = document.getElementById('isDriver_checkbox');
        license_number = document.getElementById('license_number');
        license_number.style.display = isDriver_checkbox.checked ? 'block' : 'none';
        document.getElementById('user_type').addEventListener('change', () => {
            if ((user_types[document.getElementById('user_type').value]) == 'Staff'){
                isDriver.style.display = 'block';
            }
            else{
                isDriver.style.display = 'none';
            }
        })
        isDriver_checkbox.addEventListener('change', () => {
            if (isDriver_checkbox.checked){
                license_number.style.display = 'block';
            }
            else{
                license_number.style.display = 'none';
            }
        })
    });
</script>
</head>
<div class="mh-page-soft">
    <section class="admin-hero">
        <div class="container">
            <div class="admin-hero-shell">
                <div class="admin-hero-content">
                    <span class="admin-eyebrow"><?= __('Admin') ?></span>
                    <h1><?= __('Add User') ?></h1>
                    <p class="admin-hero-text">
                        <?= __('Create a new user account and assign the appropriate role.') ?>
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
                            <p><?= __('Quick links for user management.') ?></p>
                        </div>

                        <div class="admin-action-stack">
                            <?= $this->Html->link(__('List Users'), ['action' => 'index'], ['class' => 'admin-action-link']) ?>
                        </div>
                    </div>
                </div>

                <div class="col-lg-9">
                    <div class="auth-card auth-card-wide">
                        <div class="auth-header">
                            <h2 class="auth-title"><?= __('Add User') ?></h2>
                            <p class="auth-subtitle">
                                <?= __('Fill in the user details below to create a new account.') ?>
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
                                    'label' => 'Password*',
                                    'placeholder' => 'Enter password',
                                    'class' => 'auth-input',
                                    'required' => true,
                                ]) ?>
                            </div>

                            <div class="col-md-6 auth-form-group">
                                <?= $this->Form->control('confirm_password', [
                                    'type' => 'password',
                                    'label' => 'Confirm Password*',
                                    'placeholder' => 'Confirm password',
                                    'class' => 'auth-input',
                                    'required' => true,
                                ]) ?>
                            </div>

                            <div class="col-md-6 auth-form-group">
                                <?= $this->Form->control('user_type', [
                                    'options' => $userTypes,
                                    'label' => 'User Role',
                                    'class' => 'auth-input',
                                    'id' => 'user_type',
                                ]) ?>
                            </div>

                            <div class="col-md-6 auth-form-group" id="isDriver" >
                                <?= $this->Form->control('isDriver', [
                                    'id' => 'isDriver_checkbox',
                                    'type' => 'checkbox',
                                    'value' => 1,
                                    'label' => 'Owns a Driver License',
                                    'class' => 'auth-input',
                                ]) ?>
                            </div>

                            <div class="col-md-6 auth-form-group" id="license_number" >
                                <?= $this->Form->control('license_number', [
                                    'placeholder' => 'Driver License Number',
                                    'label' => 'License Number',
                                    'class' => 'auth-input',
                                ]) ?>
                            </div>
                    </div>

                        <div class="auth-form-actions">
                            <?= $this->Form->button(__('Create User'), ['class' => 'mh-btn-primary']) ?>
                        </div>

                        <?= $this->Form->end() ?>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
