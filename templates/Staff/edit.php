<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Staff $staff
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
                    <div class="mh-back-btn m-1">
                        <?= $this->Html->link(
                            __('← Back to List'),
                            ['action' => 'index']
                        ) ?>
                    </div>

                    <div class="admin-table-card mt-3">
                        <div class="admin-table-header">
                            <h2><?= __('Actions') ?></h2>
                            <p><?= __('Manage this user account.') ?></p>
                        </div>

                        <div class="admin-action-stack">
                            <?= $this->Form->postLink(
                                __('Delete Staff'),
                                ['action' => 'delete', $staff->staff_id],
                                [
                                    'confirm' => __('Are you sure you want to delete {0}?', $staff->full_name),
                                    'class' => 'admin-action-link admin-action-link-danger',
                                ],
                            ) ?>
                        </div>
                    </div>
                </div>

                <div class="col-lg-9">
                    <div class="auth-card auth-card-wide">
                        <div class="auth-header">
                            <h2 class="auth-title"><?= __('Edit Staff') ?></h2>
                            <p class="auth-subtitle">
                                <?= __('Make changes below and save when you are done.') ?>
                            </p>
                        </div>

                        <?= $this->Form->create($staff, ['class' => 'auth-form']) ?>

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
                    <?php if($isAdmin){?>
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
                                'value' => null,
                            ]) ?>
                        </div>
                    <?php } ?>
                </div>

                <div class="auth-form-actions">
                    <?= $this->Form->button(__('Save Staff'), ['class' => 'mh-btn-primary']) ?>
                </div>

                <?= $this->Form->end() ?>
            </fieldset>
        </div>
    </div>
</div>
