<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\ContactForm $contactForm
 * @var \Cake\Collection\CollectionInterface|string[] $customers
 */

$this->assign('title', 'Contact Us');

$identity = $this->request->getAttribute('identity');
?>
<!DOCTYPE html>
<html>
<script src="https://www.google.com/recaptcha/api.js?hl=en" async defer></script>
<head>
    <?= $this->Html->charset() ?>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>
        <?= $this->fetch('title') ?>
    </title>
    <?= $this->Html->meta('icon') ?>

    <?= $this->Html->css(['normalize.min', 'milligram.min', 'fonts', 'cake', 'home', 'site']) ?>

    <?= $this->fetch('meta') ?>
    <?= $this->fetch('css') ?>
    <?= $this->fetch('script') ?>
</head>

<body class="mh-site">
<main class="landing-page mh-page-soft">

    <section class="contact-hero">
        <div class="container contact-hero-shell">
            <div class="contact-hero-content text-center text-lg-start">
                <p class="section-kicker mb-3">Contact Us</p>
                <h1>Ask a Question</h1>
                <p class="contact-hero-text">
                    Tell us what you need and our team will get back to you as soon as possible.
                </p>
            </div>
        </div>
    </section>
    <section class="contact-section">
        <div class="container">
            <div class="row g-4 g-lg-5 align-items-stretch">

                <div class="col-lg-4">
                    <div class="contact-info-stack">
                        <div class="mh-info-card">
                            <div class="mh-info-icon">📞</div>
                            <div>
                                <h3>Call Us</h3>
                                <p>Speak with our team for quick moving support.</p>
                            </div>
                        </div>

                        <div class="mh-info-card">
                            <div class="mh-info-icon">✉️</div>
                            <div>
                                <h3>Email Us</h3>
                                <p>Send us your enquiry and we will get back to you soon.</p>
                            </div>
                        </div>

                        <div class="mh-info-card">
                            <div class="mh-info-icon">📍</div>
                            <div>
                                <h3>Service Area</h3>
                                <p>We support local removal and storage enquiries.</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-8">
                    <div class="mh-form-card content">
                        <?= $this->Form->create($contactForm, ['class' => 'contact-form']) ?>

                        <div class="row g-3">
                            <div class="col-md-6">
                                <?= $this->Form->control('first_name', [
                                    'label' => 'First Name*',
                                    'required' => true,
                                ]) ?>
                            </div>

                            <div class="col-md-6">
                                <?= $this->Form->control('last_name', [
                                    'label' => 'Last Name*',
                                    'required' => true,
                                ]) ?>
                            </div>

                            <div class="col-md-6">
                                <?= $this->Form->control('email', [
                                    'label' => 'Email*',
                                    'required' => true,
                                ]) ?>
                            </div>

                            <div class="col-md-6">
                                <?= $this->Form->control('phone', [
                                    'label' => 'Phone*',
                                    'placeholder' => '0400000000',
                                    'required' => true,
                                ]) ?>
                            </div>

                            <div class="col-12">
                                <?= $this->Form->control('subject', [
                                    'label' => 'Subject*',
                                    'required' => true,
                                ]) ?>
                            </div>

                            <div class="col-12">
                                <?= $this->Form->control('message', [
                                    'label' => 'Message*',
                                    'type' => 'textarea',
                                    'required' => true,
                                    'rows' => 6,
                                ]) ?>
                            </div>

                            <div class="col-12">
                                <div class="recaptcha-wrap">
                                    <div class="g-recaptcha" data-sitekey="<?= h($siteKey ?? '') ?>"></div>
                                </div>
                            </div>

                            <div class="col-12">
                                <?= $this->Form->button(__('Send Message'), [
                                    'class' => 'contact-submit-btn',
                                ]) ?>
                            </div>
                        </div>

                        <?= $this->Form->end() ?>
                    </div>
                </div>

            </div>
        </div>
    </section>
</main>
</body>
</html>
