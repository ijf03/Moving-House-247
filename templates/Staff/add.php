<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Staff $staffEntity
 */
?>
<head>
    <script>
        window.addEventListener('load', ()=> {
            isDriver_checkbox = document.getElementById('isDriver_checkbox');
            license_number = document.getElementById('license_number');
            license_number.style.display = isDriver_checkbox.checked ? 'block' : 'none';
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
                    <h1><?= __('Add Staff') ?></h1>
                    <p class="admin-hero-text">
                        <?= __('Create a new staff account.') ?>
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
                            <p><?= __('Quick links for staff management.') ?></p>
                        </div>

                        <div class="admin-action-stack">
                            <?= $this->Html->link(__('List Staff'), ['action' => 'index'], ['class' => 'admin-action-link']) ?>
                        </div>
                    </div>
                </div>

                <div class="col-lg-9">
                    <div class="auth-card auth-card-wide">
                        <div class="auth-header">
                            <h2 class="auth-title"><?= __('Add Staff') ?></h2>
                            <p class="auth-subtitle">
                                <?= __('Fill in the staff details below to create a new account.') ?>
                            </p>
                        </div>
                <?= $this->Form->create($staffEntity, ['class' => 'auth-form']) ?>

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
                        <?= $this->Form->control('isDriver', [
                            'label' => 'Owns a Driver License',
                            'id' => 'isDriver_checkbox',
                            'type' => 'checkbox',
                            'value' => 1,
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
                    <?= $this->Form->button(__('Register Staff'), ['class' => 'mh-btn-primary']) ?>
                </div>

                <?= $this->Form->end() ?>
            </fieldset>
        </div>
    </div>
</div>
