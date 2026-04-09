<?php
$this->assign('title', 'Login');
?>

<div class="login-centered-page">
    <div class="login-centered-card">
        <?= $this->Flash->render() ?>

        <?= $this->Form->create(null, ['class' => 'login-form']) ?>
            <?= $this->Form->control('email', [
                'label' => false,
                'placeholder' => 'Email',
                'class' => 'login-input',
                'required' => true,
            ]) ?>


        <div class="login-form-group">
            <?= $this->Form->control('password', [
                'label' => false,
                'placeholder' => 'Password',
                'class' => 'login-input',
                'required' => true,
            ]) ?>
        </div>

        <div class="login-form-actions">
            <?= $this->Form->button('Log in', [
                'class' => 'login-btn login-btn-primary',
            ]) ?>
        </div>

        <?= $this->Form->end() ?>

        <div class="login-divider"></div>
    <a href="resetpassword">Forgot Password?</a>
    <p>
        <a href="<?= $this->Url->build(['controller' => 'Users', 'action' => 'register']) ?>">
            Don't have an account? Register here!
        </a>
    </p>
    </div>
</div>
