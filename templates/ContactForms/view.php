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
                            <h2><?= __('Message Details') ?></h2>
                            <p><?= __('Review the selected contact form record below.') ?></p>
                        </div>

                        <div class="admin-table-wrap">
                            <table class="admin-table">
                                <tbody>
                                <tr>
                                    <th><?= __('Customer') ?></th>
                                    <td>
                                        <?= $contactForm->hasValue('customer')
                                            ? $this->Html->link(
                                                $contactForm->customer->first_name . ' ' . $contactForm->customer->last_name,
                                                ['controller' => 'Customers', 'action' => 'view', $contactForm->customer->customer_id],
                                                ['class' => 'admin-inline-link']
                                            )
                                            : '' ?>
                                    </td>
                                </tr>
                                <tr>
                                    <th><?= __('First Name') ?></th>
                                    <td><?= h($contactForm->customer->first_name ?? '') ?></td>
                                </tr>
                                <tr>
                                    <th><?= __('Last Name') ?></th>
                                    <td><?= h($contactForm->customer->last_name ?? '') ?></td>
                                </tr>
                                <tr>
                                    <th><?= __('Email') ?></th>
                                    <td><?= h($contactForm->customer->email ?? '') ?></td>
                                </tr>
                                <tr>
                                    <th><?= __('Phone') ?></th>
                                    <td><?= h($contactForm->customer->phone ?? '') ?></td>
                                </tr>
                                <tr>
                                    <th><?= __('Subject') ?></th>
                                    <td><?= h($contactForm->subject) ?></td>
                                </tr>
                                <tr>
                                    <th><?= __('Status') ?></th>
                                    <td>
                                            <span class="admin-status-badge admin-status-<?= strtolower((string)($contactForm->status ?? 'new')) ?>">
                                                <?= h(ucfirst($contactForm->status ?? 'new')) ?>
                                            </span>
                                    </td>
                                </tr>
                                <tr>
                                    <th><?= __('Contact Form Id') ?></th>
                                    <td><?= $this->Number->format($contactForm->contact_form_id) ?></td>
                                </tr>
                                <tr>
                                    <th><?= __('Created') ?></th>
                                    <td><?= h($contactForm->created) ?></td>
                                </tr>
                                <tr>
                                    <th><?= __('Replied At') ?></th>
                                    <td><?= h($contactForm->replied_at ?? 'Not replied yet') ?></td>
                                </tr>
                                </tbody>
                            </table>
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
