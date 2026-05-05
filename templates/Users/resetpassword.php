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
                            <p class="section-kicker mb-2">Reset password</p>
                            <h1 class="auth-title">Reset Password</h1>
                            <p class="auth-subtitle">
                                Reset Your password
                            </p>
                        </div>

                        <?= $this->Form->create($this->get('user') ?? null, ['class' => 'auth-form']) ?>

                        <div class="row g-3">

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
                                <div class="auth-form-actions">
                                    <?= $this->Form->button('Submit', [
                                        'class' => 'auth-btn',
                                    ]) ?>
                                </div>
                            </div>
                        </div>

                        <?= $this->Form->end() ?>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>
