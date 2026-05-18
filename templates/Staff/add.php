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
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('List Staff'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column column-80">
        <div class="staff form content">
            <?= $this->Form->create($staffEntity) ?>
            <fieldset>
                <legend><?= __('Add Staff') ?></legend>
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
                    <?= $this->Form->button(__('Register Staff'), ['class' => 'mh-btn-primary']) ?>
                </div>

                <?= $this->Form->end() ?>
            </fieldset>
        </div>
    </div>
</div>
