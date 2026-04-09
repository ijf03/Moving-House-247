<?php
$this->assign('title', 'Register');
?>

<script src="https://www.google.com/recaptcha/api.js?hl=en" async defer></script>

<div class="login-centered-page">
    <div class="login-centered-card">
        <?= $this->Flash->render() ?>

        <?= $this->Form->create($this->get('user') ?? null, ['class' => 'login-form']) ?>

        <div class="login-form-group">
            <?= $this->Form->control('email', [
                'label' => 'Email*',
                'placeholder' => 'Email',
                'class' => 'login-input',
                'required' => true,
            ]) ?>
        </div>

        <div class="login-form-group">
            <?= $this->Form->control('password', [
                'type' => 'password',
                'label' => 'Password*',
                'placeholder' => 'Password',
                'class' => 'login-input',
                'required' => true,
            ]) ?>
        </div>

        <div class="login-form-group">
            <?= $this->Form->control('confirm_password', [
                'type' => 'password',
                'label' => 'Confirm Password*',
                'placeholder' => 'Confirm Password',
                'class' => 'login-input',
                'required' => true,
            ]) ?>
        </div>

        <div class="login-form-group">
            <?= $this->Form->control('first_name', [
                'label' => 'First Name*',
                'placeholder' => 'First Name',
                'class' => 'login-input',
                'required' => true,
            ]) ?>
        </div>

        <div class="login-form-group">
            <?= $this->Form->control('last_name', [
                'label' => 'Last Name*',
                'placeholder' => 'Last Name',
                'class' => 'login-input',
                'required' => true,
            ]) ?>
        </div>

        <div class="login-form-group">
            <div class="g-recaptcha" data-sitekey='6Lds85QsAAAAAEEWmyp2mWR9ITmNyAwoLeECRwAs'></div>
        </div>

        <div class="login-form-actions">
            <?= $this->Form->button('Register', [
                'class' => 'login-btn login-btn-primary',
            ]) ?>
        </div>

        <?= $this->Form->end() ?>

        <div class="login-divider"></div>

        <a href="<?= $this->Url->build(['controller' => 'Users', 'action' => 'login']) ?>">
            Already have an account? Login here
        </a>
    </div>
</div>
