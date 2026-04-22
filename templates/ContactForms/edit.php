<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\ContactForm $contactForm
 */
?>

<div class="mh-page-soft">
    <section class="admin-hero">
        <div class="container">
            <div class="admin-hero-shell">
                <div class="admin-hero-content">
                    <p class="admin-eyebrow"><?= __('Admin Dashboard') ?></p>
                    <h1><?= __('Edit Contact Form') ?></h1>
                    <p class="admin-hero-text">
                        <?= __('Update the enquiry details while keeping the original workflow unchanged.') ?>
                    </p>
                </div>
            </div>
        </div>
    </section>

    <section class="admin-section">
        <div class="container">
            <div class="row g-4 align-items-start">
                <div class="col-lg-3">
                    <div class="mh-form-card">
                        <div class="admin-table-header">
                            <h2><?= __('Actions') ?></h2>
                        </div>

                        <div class="admin-action-stack">
                            <?= $this->Form->postLink(
                                __('Delete'),
                                ['action' => 'delete', $contactForm->contact_form_id],
                                [
                                    'confirm' => __('Are you sure you want to delete # {0}?', $contactForm->contact_form_id),
                                    'class' => 'admin-action-link admin-action-link-danger'
                                ]
                            ) ?>

                            <?= $this->Html->link(
                                __('List Contact Forms'),
                                ['action' => 'index'],
                                ['class' => 'admin-action-link']
                            ) ?>
                        </div>
                    </div>
                </div>

                <div class="col-lg-9">
                    <div class="mh-form-card">
                        <div class="admin-table-header">
                            <h2><?= __('Edit Message Details') ?></h2>
                            <p><?= __('Review and update the enquiry information below.') ?></p>
                        </div>

                        <?= $this->Form->create($contactForm, ['class' => 'mh-form']) ?>

                        <div class="row g-3">
                            <div class="col-md-6">
                                <?= $this->Form->control('first_name', [
                                    'value' => $contactForm->customer->first_name ?? ''
                                ]) ?>
                            </div>

                            <div class="col-md-6">
                                <?= $this->Form->control('last_name', [
                                    'value' => $contactForm->customer->last_name ?? ''
                                ]) ?>
                            </div>

                            <div class="col-md-6">
                                <?= $this->Form->control('email', [
                                    'value' => $contactForm->customer->email ?? ''
                                ]) ?>
                            </div>

                            <div class="col-md-6">
                                <?= $this->Form->control('phone', [
                                    'value' => $contactForm->customer->phone ?? ''
                                ]) ?>
                            </div>

                            <div class="col-12">
                                <?= $this->Form->control('subject') ?>
                            </div>

                            <div class="col-12">
                                <?= $this->Form->control('message') ?>
                            </div>
                        </div>

                        <div class="mt-4">
                            <?= $this->Form->button(__('Submit'), ['class' => 'mh-btn-primary']) ?>
                        </div>

                        <?= $this->Form->end() ?>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
