<?php
$this->assign('title', 'Register');
?>

<script src="https://www.google.com/recaptcha/api.js?hl=en" async defer></script>

<main class="mh-page-soft">
    <section class="auth-section">
        <div class="container">
            <div class="row justify-content-center py-5">
                <div class="col-12 col-md-11 col-lg-8 col-xl-7">
                    <div class="mh-form-card auth-card-wide">
                        <?= $this->Flash->render() ?>

                        <div class="auth-header text-center">
                            <p class="section-kicker mb-2">Create Account</p>
                            <h1 class="auth-title">Register</h1>
                            <p class="auth-subtitle">
                                Create a standard account to get started.
                            </p>
                        </div>

                        <?= $this->Form->create($this->get('user') ?? null, ['class' => 'auth-form']) ?>

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
                                    'required' => true,
                                ]) ?>
                            </div>

                            <div class="col-md-6">
                                <?= $this->Form->control('confirm_password', [
                                    'type' => 'password',
                                    'label' => 'Confirm Password*',
                                    'placeholder' => 'Confirm your password',
                                    'class' => 'auth-input',
                                    'required' => true,
                                ]) ?>
                            </div>

                            <div class="col-12">
                                <div class="auth-recaptcha">
                                    <div class="g-recaptcha" data-sitekey="<?= h($siteKey ?? '') ?>"></div>
                                </div>
                            </div>

                            <div class="col-12">
                                <div class="auth-form-actions">
                                    <?= $this->Form->button('Register', [
                                        'class' => 'mh-btn-primary',
                                    ]) ?>
                                </div>
                            </div>
                        </div>

                        <?= $this->Form->end() ?>

                        <div class="auth-links text-center">
                            <a href="<?= $this->Url->build(['controller' => 'Users', 'action' => 'login']) ?>">
                                Already have an account? Log in here
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>
