<?php
$this->assign('title', 'Login');
?>

<main class="mh-page-soft">
    <section class="auth-section">
        <div class="container">
            <div class="row justify-content-center align-items-center min-vh-100 py-5">
                <div class="col-12 col-md-10 col-lg-6 col-xl-5">
                    <div class="mh-form-card">
                        <?= $this->Flash->render() ?>

                        <div class="auth-header text-center">
                            <p class="section-kicker mb-2">Welcome Back</p>
                            <h1 class="auth-title">Log In</h1>
                            <p class="auth-subtitle">
                                Sign in to continue to your account.
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

                        <div class="auth-form-group">
                            <?= $this->Form->control('password', [
                                'label' => 'Password',
                                'placeholder' => 'Enter your password',
                                'class' => 'auth-input',
                                'required' => true,
                            ]) ?>
                        </div>

                        <div class="auth-form-actions">
                            <?= $this->Form->button('Log In', [
                                'class' => 'auth-btn',
                            ]) ?>
                        </div>

                        <?= $this->Form->end() ?>

                        <div class="auth-links text-center">
                            <a href="<?= $this->Url->build(['controller' => 'Users', 'action' => 'forgetpassword']) ?>">
                                Forgot Password?
                            </a>
                            <p class="mt-3 mb-0">
                                <a href="<?= $this->Url->build(['controller' => 'Users', 'action' => 'register']) ?>">
                                    Don’t have an account? Register here
                                </a>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>
