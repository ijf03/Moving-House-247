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
                    <h1><?= __('Contact Message') ?></h1>
                    <p class="admin-hero-text">
                        <?= __('View the full enquiry details and current response status.') ?>
                    </p>
                </div>
            </div>
        </div>
    </section>

    <section class="admin-section">
        <div class="container">
            <div class="row g-4 align-items-start">
                <div class="col-lg-3">
                    <div class="mh-back-btn m-1">
                        <?= $this->Html->link(__('← Back to List'), ['action' => 'index']) ?>
                    </div>
                    <div class="mh-form-card">
                        <div class="admin-table-header">
                            <h2><?= __('Actions') ?></h2>
                        </div>

                        <div class="admin-action-stack">
                            <?= $this->Html->link(
                                __('Reply to Message'),
                                ['action' => 'reply', $contactForm->contact_form_id],
                                ['class' => 'admin-primary-link']
                            ) ?>

                            <?= $this->Html->link(
                                __('Edit Contact Form'),
                                ['action' => 'edit', $contactForm->contact_form_id],
                                ['class' => 'admin-action-link']
                            ) ?>

                            <?= $this->Form->postLink(
                                __('Delete Contact Form'),
                                ['action' => 'delete', $contactForm->contact_form_id],
                                [
                                    'confirm' => __('Are you sure you want to delete # {0}?', $contactForm->contact_form_id),
                                    'class' => 'admin-action-link admin-action-link-danger'
                                ]
                            ) ?>

                        </div>
                    </div>
                </div>

                <div class="col-lg-9">
                    <div class="admin-table-card">
                        <div class="admin-table-header">
                            <div class="d-flex align-items-center gap-2 flex-wrap mb-2">
                                <h2 class="mb-0">
                                    <?= $contactForm->hasValue('customer')
                                        ? $this->Html->link(
                                            $contactForm->customer->first_name . ' ' . $contactForm->customer->last_name,
                                            ['controller' => 'Customers', 'action' => 'view', $contactForm->customer->customer_id],
                                            ['class' => 'admin-inline-link']
                                        )
                                        : __('Guest Customer') ?>
                                </h2>

                                <span class="admin-status-badge admin-status-<?= strtolower((string)($contactForm->status ?? 'new')) ?>">
                                    <?= h(ucfirst($contactForm->status ?? 'new')) ?>
                                </span>
                            </div>
                            <p><?= __('Review the selected contact form record below.') ?></p>
                        </div>

                        <div class="row g-3">

                            <div class="col-md-6 col-lg-4">
                                <div class="mh-info-card">
                                    <div>
                                        <h3><?= __('Email') ?></h3>
                                        <p><?= h($contactForm->customer->email ?? '') ?></p>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6 col-lg-4">
                                <div class="mh-info-card">
                                    <div>
                                        <h3><?= __('Phone Number') ?></h3>
                                        <p><?= h($contactForm->customer->phone ?? 'Not provided') ?></p>
                                    </div>
                                </div>
                            </div>


                            <div class="col-md-6 col-lg-4">
                                <div class="mh-info-card">
                                    <div>
                                        <h3><?= __('Subject') ?></h3>
                                        <p><?= h($contactForm->subject) ?></p>
                                    </div>
                                </div>
                            </div>



                            <div class="col-12">
                                <div class="mh-info-card">
                                    <div class="col-6">
                                        <h3><?= __('Created') ?></h3>
                                        <p><?= h($contactForm->created) ?></p>
                                    </div>
                                    <div class="col-6">
                                        <h3><?= __('Replied At') ?></h3>
                                        <p><?= h($contactForm->replied_at ?? 'Not replied yet') ?></p>
                                    </div>
                                </div>
                            </div>


                            <div class="col-12">
                                <div class="mh-info-card">
                                    <div>
                                        <h3><?= __('Originl Inquiry') ?></h3>
                                        <p><?= nl2br(h($contactForm->message)) ?></p>
                                    </div>
                                </div>
                            </div>

                        </div>

                        <div class="mt-4">
                            <div class="admin-table-header">
                                <h2><?= __('Conversation') ?></h2>
                            </div>

                            <?php if (!empty($contactForm->contact_form_replies)): ?>
                                <?php foreach ($contactForm->contact_form_replies as $reply): ?>
                                    <div class="<?= $reply->sender_type === 'admin' ? 'mh-info-card' : 'mh-side-note' ?> mb-3">
                                        <div>
                                            <strong><?= h(ucfirst($reply->sender_type)) ?></strong>
                                            <p><?= $this->Text->autoParagraph(h($reply->message)) ?></p>
                                            <small><?= h($reply->created) ?></small>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <div class="mh-info-card">
                                    <div>
                                        <p><?= __('No conversation messages have been saved yet.') ?></p>
                                    </div>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
