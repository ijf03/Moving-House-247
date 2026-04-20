<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\User $user
 */
$this->assign('title', 'Reset Password');
?>

<script src="https://www.google.com/recaptcha/api.js?hl=en" async defer></script>

<main class="auth-page">
    <section class="auth-section">
        <div class="container">
            <div class="row justify-content-center align-items-center min-vh-100 py-5">
                <div class="col-12 col-md-10 col-lg-6 col-xl-5">
                    <div class="auth-card">
                        <?= $this->Flash->render() ?>

                        <div class="auth-header text-center">
                            <p class="section-kicker mb-2">Password Recovery</p>
                            <h1 class="auth-title">Reset Password</h1>
                            <p class="auth-subtitle">
                                Enter your email to continue.
                            </p>
                        </div>

                        <?= $this->Form->create(null, ['class' => 'auth-form']) ?>

                        <div class="auth-form-group">
                            <?= $this->Form->control('email', [
                                'label' => 'Email',
                                'placeholder' => 'Enter your email',
                                'class' => 'auth-input',
                                'required' => true,
                            ]) ?>
                        </div>

                        <div class="auth-recaptcha">
                            <div class="g-recaptcha" data-sitekey="<?= h($siteKey ?? '') ?>"></div>
                        </div>

                        <div class="auth-form-actions">
                            <?= $this->Form->button(__('Submit'), [
                                'class' => 'auth-btn',
                            ]) ?>
                        </div>

                        <?= $this->Form->end() ?>

                        <div class="auth-links text-center">
                            <a href="<?= $this->Url->build(['controller' => 'Users', 'action' => 'login']) ?>">
                                Back to login
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>
