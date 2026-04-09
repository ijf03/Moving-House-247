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

    <?= $this->Html->css(['normalize.min', 'milligram.min', 'fonts', 'cake', 'home']) ?>

    <?= $this->fetch('meta') ?>
    <?= $this->fetch('css') ?>
    <?= $this->fetch('script') ?>
</head>

<body>
    <main class="landing-page">

        <section class="hero">
            <div class="hero-content">
                <h1>Contact Us!</h1>
                <h2>Get a Quote or ask a Question and we will reply as soon as we can!</h2>
            </div>
        </section>

        <div>
            <div>
                <div class="contactForms form content">
                    <?= $this->Form->create($contactForm) ?>
                    <fieldset>
                        <div class="form-row">
                            <?= $this->Form->control('first_name', ['label' => 'First Name*', 'required' => true]) ?>
                            <?= $this->Form->control('last_name', ['label' => 'Last Name*', 'required' => true]) ?>
                        </div>

                        <div class="form-row">
                            <?= $this->Form->control('email', ['label' => 'Email*', 'required' => true]) ?>
                            <?= $this->Form->control('phone', ['label' => 'Phone*','placeholder' => '400000000', 'required' => true]) ?>
                        </div>

                        <?= $this->Form->control('subject', ['label' => 'Subject*', 'required' => true]) ?>
                        <?= $this->Form->control('message', ['label' => 'Message*', 'type' => 'textarea', 'required' => true]) ?>

                        <div class="g-recaptcha" data-sitekey="<?= '6Lds85QsAAAAAEEWmyp2mWR9ITmNyAwoLeECRwAs' ?>"></div>
                    </fieldset>
                    <?= $this->Form->button(__('Submit')) ?>
                    <?= $this->Form->end() ?>
                </div>
            </div>
        </div>
    </main>
</body>
