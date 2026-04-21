<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\User $user
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $user->user_id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $user->user_id), 'class' => 'side-nav-item']
            ) ?>
            <?= $this->Html->link(__('List Users'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column column-80">
        <div class="users form content">
            <?= $this->Form->create($user) ?>
            <fieldset>
                <legend><?= __('Edit User') ?></legend>
                <div class="row g-3">
                    <div class="col-md-6">
                        <?= $this->Form->control('first_name', [
                            'label' => 'First Name*',
                            'placeholder' => 'Enter your first name',
                            'class' => 'auth-input',
                            'required' => true,
                        ]) ?>
                    </div>

                    <div class="col-md-6">
                        <?= $this->Form->control('last_name', [
                            'label' => 'Last Name*',
                            'placeholder' => 'Enter your last name',
                            'class' => 'auth-input',
                            'required' => true,
                        ]) ?>
                    </div>

                    <div class="col-md-6">
                        <?= $this->Form->control('email', [
                            'label' => 'Email*',
                            'placeholder' => 'Enter your email',
                            'class' => 'auth-input',
                            'required' => true,
                        ]) ?>
                    </div>

                    <div class="col-md-6">
                        <?= $this->Form->control('phone', [
                            'label' => 'Phone*',
                            'placeholder' => 'Enter your phone number',
                            'class' => 'auth-input',
                            'required' => true,
                        ]) ?>
                    </div>

                    <div class="col-md-6">
                        <?= $this->Form->control('password', [
                            'type' => 'password',
                            'label' => 'Password*',
                            'placeholder' => 'Enter your password',
                            'class' => 'auth-input',
                            'required' => false,
                            'value' => '',
                        ]) ?>
                    </div>

                    <div class="col-md-6">
                        <?= $this->Form->control('confirm_password', [
                            'type' => 'password',
                            'label' => 'Confirm Password*',
                            'placeholder' => 'Confirm your password',
                            'class' => 'auth-input',
                            'required' => false,
                        ]) ?>
                    </div>
                    <?php if ($userTypes){ ?>
                    <div class="col-md-6">
                        <?= $this->Form->control('user_type', [
                            'options' => $userTypes,
                            'label' => 'User Role',
                        ]);
                        ?>
                    </div>
                    <?php } ?>
            </fieldset>
            <?= $this->Form->button(__('Submit')) ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>
