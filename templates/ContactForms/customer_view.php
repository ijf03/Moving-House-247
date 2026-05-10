<div class="mh-page-soft">
    <section class="admin-hero">
        <div class="container admin-hero-shell">
            <div class="admin-hero-content">
                <span class="admin-eyebrow"><?= __('Customer Portal') ?></span>
                <h1><?= h($contactForm->subject) ?></h1>
                <p class="admin-hero-text">
                    <?= __('View replies from our team and send follow-up messages.') ?>
                </p>
            </div>
        </div>
    </section>

    <section class="admin-section">
        <div class="container">
            <div class="admin-table-card">
                <div class="admin-table-header admin-table-header-split">
                    <div>
                        <h2><?= __('Conversation') ?></h2>
                        <p>
                            <?= __('Status: ') ?>
                            <span class="admin-status-badge admin-status-<?= strtolower((string)$contactForm->status) ?>">
                                <?= h(ucfirst($contactForm->status)) ?>
                            </span>
                        </p>
                    </div>

                    <?= $this->Html->link(
                        __('Back to My Inquiries'),
                        ['action' => 'customerIndex'],
                        ['class' => 'admin-action-link']
                    ) ?>
                </div>

                <?php if (!empty($contactForm->contact_form_replies)): ?>
                    <?php foreach ($contactForm->contact_form_replies as $reply): ?>
                        <div class="<?= $reply->sender_type === 'admin' ? 'mh-info-card' : 'mh-side-note' ?> mb-3">
                            <div>
                                <strong>
                                    <?= $reply->sender_type === 'admin'
                                        ? __('Moving House 24/7')
                                        : __('You') ?>
                                </strong>

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

                <div class="mt-4">
                    <div class="admin-table-header">
                        <h2><?= __('Send a Reply') ?></h2>
                        <p><?= __('Add a follow-up message to this inquiry.') ?></p>
                    </div>

                    <?= $this->Form->create(null, [
                        'url' => ['action' => 'customerReply', $contactForm->contact_form_id],
                        'class' => 'auth-form'
                    ]) ?>

                    <?= $this->Form->control('message', [
                        'type' => 'textarea',
                        'label' => __('Your Reply'),
                        'required' => true,
                        'class' => 'auth-input'
                    ]) ?>

                    <div class="auth-form-actions">
                        <?= $this->Form->button(__('Send Reply'), ['class' => 'mh-btn-primary']) ?>
                    </div>

                    <?= $this->Form->end() ?>
                </div>
            </div>
        </div>
    </section>
</div>
