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
                    <h1><?= __('Reply to Message') ?></h1>
                    <p class="admin-hero-text">
                        <?= __('Review the original enquiry and send a reply from the same page.') ?>
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
                            <?= $this->Html->link(
                                __('Back to Message'),
                                ['action' => 'view', $contactForm->contact_form_id],
                                ['class' => 'admin-action-link']
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
                            <h2><?= __('Send Reply') ?></h2>
                            <p><?= __('Use the details below to reply to this enquiry.') ?></p>
                        </div>

                        <div class="row g-3 mb-4">
                            <div class="col-md-4">
                                <div class="mh-info-card">
                                    <div>
                                        <h3><?= __('Name') ?></h3>
                                        <p><?= h(($contactForm->customer->first_name ?? '') . ' ' . ($contactForm->customer->last_name ?? '')) ?></p>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="mh-info-card">
                                    <div>
                                        <h3><?= __('Email') ?></h3>
                                        <p><?= h($contactForm->customer->email ?? '') ?></p>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="mh-info-card">
                                    <div>
                                        <h3><?= __('Subject') ?></h3>
                                        <p><?= h($contactForm->subject) ?></p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="mb-4">
                            <div class="admin-table-header">
                                <h2><?= __('Original Message') ?></h2>
                            </div>
                            <div class="mh-side-note">
                                <p><?= $this->Text->autoParagraph(h($contactForm->message)) ?></p>
                            </div>
                        </div>

                        <?php if (!empty($contactForm->admin_reply)): ?>
                            <div class="mb-4">
                                <div class="admin-table-header">
                                    <h2><?= __('Previous Admin Reply') ?></h2>
                                </div>
                                <div class="mh-info-card">
                                    <div>
                                        <p><?= $this->Text->autoParagraph(h($contactForm->admin_reply)) ?></p>
                                    </div>
                                </div>
                            </div>
                        <?php endif; ?>

                        <?= $this->Form->create(null, ['class' => 'mh-form']) ?>

                        <?= $this->Form->control('reply_message', [
                            'type' => 'textarea',
                            'label' => 'Reply Message',
                            'required' => true
                        ]) ?>

                        <div class="mt-4">
                            <?= $this->Form->button(__('Send Email'), ['class' => 'mh-btn-primary']) ?>
                        </div>

                        <?= $this->Form->end() ?>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
