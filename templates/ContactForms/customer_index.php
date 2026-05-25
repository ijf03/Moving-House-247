<div class="mh-page-soft">
    <section class="admin-hero">
        <div class="container admin-hero-shell">
            <div class="admin-hero-content">
                <span class="admin-eyebrow"><?= __('Customer Portal') ?></span>
                <h1><?= __('My Inquiries') ?></h1>
                <p class="admin-hero-text">
                    <?= __('Submit a new inquiry or check replies from our team.') ?>
                </p>
            </div>
        </div>
    </section>

    <section class="admin-section">
        <div class="container">

            <div class="row g-4 mb-4">
                <div class="col-md-6">
                    <div class="mh-info-card">
                        <div>
                            <h3><?= __('Submit a New Inquiry') ?></h3>
                            <p><?= __('Need help with a booking, quote, storage, or moving question? Send us a new message.') ?></p>

                            <div class="mt-3">
                                <?= $this->Html->link(
                                    __('Create Inquiry'),
                                    ['action' => 'add'],
                                    ['class' => 'admin-primary-link']
                                ) ?>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="mh-info-card">
                        <div>
                            <h3><?= __('Check Previous Inquiries') ?></h3>
                            <p><?= __('View your submitted inquiries, read admin replies, and send follow-up messages.') ?></p>

                            <div class="mt-3">
                                <a href="#inquiry-history" class="admin-action-link">
                                    <?= __('View Inquiry History') ?>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div id="inquiry-history" class="admin-table-card">
                <div class="admin-table-header admin-table-header-split">
                    <div>
                        <h2><?= __('Inquiry History') ?></h2>
                        <p><?= __('Select an inquiry to view the full conversation.') ?></p>
                    </div>
                </div>

                <?php if (!$contactForms->isEmpty()): ?>
                    <div class="admin-table-wrap">
                        <table class="admin-table">
                            <thead>
                            <tr>
                                <th><?= __('Subject') ?></th>
                                <th><?= __('Status') ?></th>
                                <th><?= __('Created') ?></th>
                                <th><?= __('Actions') ?></th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php foreach ($contactForms as $contactForm): ?>
                                <tr>
                                    <td><?= h($contactForm->subject) ?></td>
                                    <td>
                                        <span class="admin-status-badge admin-status-<?= strtolower((string)$contactForm->status) ?>">
                                            <?= h(ucfirst($contactForm->status)) ?>
                                        </span>
                                    </td>
                                    <td><?= h($contactForm->created?->format('d/m/Y') ) ?></td>
                                    <td>
                                        <?= $this->Html->link(
                                            __('View Conversation'),
                                            ['action' => 'customerView', $contactForm->contact_form_id],
                                            ['class' => 'admin-action-link']
                                        ) ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                <?php else: ?>
                    <div class="mh-info-card">
                        <div>
                            <h3><?= __('No inquiries yet') ?></h3>
                            <p><?= __('You have not submitted any contact form inquiries yet. Create a new inquiry to contact our team.') ?></p>
                        </div>
                    </div>
                <?php endif; ?>
            </div>

        </div>
    </section>
</div>
