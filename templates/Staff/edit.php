<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Staff $staff
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $staff->staff_id],
                ['confirm' => __('Are you sure you want to delete {0}?', $staff->full_name), 'class' => 'side-nav-item']
            ) ?>
            <?= $this->Html->link(__('List Staff'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column column-80">
        <div class="staff form content">
            <?= $this->Form->create($staff) ?>
            <fieldset>
                <legend><?= __('Edit Staff') ?></legend>
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
                    <div class="col-md-6 auth-form-group">
                        <?= $this->Form->control('isDriver', [
                            'label' => 'Owns a valid driving license?',
                            'type' => 'checkbox',
                            'value' => 0,
                            'class' => 'auth-input',
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
