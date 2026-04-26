<?php
/**
 * @var \App\View\AppView $this
 * @var iterable<\App\Model\Entity\ContactForm> $contactForms
 */
?>

<div class="mh-page-soft">
    <section class="admin-hero">
        <div class="container">
            <div class="admin-hero-shell">
                <div class="admin-hero-content">
                    <p class="admin-eyebrow">Admin Dashboard</p>
                    <h1>Contact Forms</h1>
                    <p class="admin-hero-text">
                        Review customer enquiries, track response status, and manage incoming messages in one place.
                    </p>
                </div>
            </div>
        </div>
    </section>

    <section class="admin-section">
        <div class="container">
            <div class="admin-table-card">
                <div class="admin-table-header">
                    <div>
                        <h2>Incoming Messages</h2>
                        <p>Unreplied enquiries are highlighted so they are easy to spot.</p>
                    </div>
                </div>

                <div class="admin-table-wrap">
                    <table class="admin-table">
                        <thead>
                        <tr>
                            <th><?= __('Contact Form') ?></th>
                            <th><?= __('Customer') ?></th>
                            <th><?= __('Email') ?></th>
                            <th><?= __('Phone') ?></th>
                            <th><?= __('Subject') ?></th>
                            <th><?= __('Created') ?></th>
                            <th><?= __('Status') ?></th>
                            <th class="actions"><?= __('Actions') ?></th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php foreach ($contactForms as $contactForm): ?>
                            <tr class="<?= ($contactForm->status ?? 'new') !== 'replied' ? 'admin-row-highlight' : '' ?>">
                                <td><?= $this->Number->format($contactForm->contact_form_id) ?></td>
                                <td>
                                    <?= $contactForm->hasValue('customer')
                                        ? $this->Html->link(
                                            $contactForm->customer->first_name . ' ' . $contactForm->customer->last_name,
                                            ['controller' => 'Customers', 'action' => 'view', $contactForm->customer->customer_id],
                                            ['class' => 'admin-inline-link']
                                        )
                                        : '' ?>
                                </td>
                                <td><?= h($contactForm->customer->email ?? '') ?></td>
                                <td><?= h($contactForm->customer->phone ?? '') ?></td>
                                <td><?= h($contactForm->subject) ?></td>
                                <td><?= h($contactForm->created) ?></td>
                                <td>
                                    <span class="admin-status-badge admin-status-<?= strtolower((string)($contactForm->status ?? 'new')) ?>">
                                        <?= h(ucfirst($contactForm->status ?? 'new')) ?>
                                    </span>
                                </td>
                                <td class="actions">
                                    <div class="admin-action-stack">
                                        <?= $this->Html->link(__('View'), ['action' => 'view', $contactForm->contact_form_id], ['class' => 'admin-action-link']) ?>
                                        <?= $this->Html->link(__('Edit'), ['action' => 'edit', $contactForm->contact_form_id], ['class' => 'admin-action-link']) ?>
                                        <?= $this->Form->postLink(
                                            __('Delete'),
                                            ['action' => 'delete', $contactForm->contact_form_id],
                                            [
                                                'method' => 'delete',
                                                'confirm' => __('Are you sure you want to delete the message from {0}? This action cannot be undone.', $contactForm->customer->first_name),
                                                'class' => 'admin-action-link admin-action-link-danger'
                                            ]
                                        ) ?>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>

                <div class="admin-paginator">
                    <ul class="pagination">
                        <?= $this->Paginator->first('<< ' . __('first')) ?>
                        <?= $this->Paginator->prev('< ' . __('previous')) ?>
                        <?= $this->Paginator->numbers() ?>
                        <?= $this->Paginator->next(__('next') . ' >') ?>
                        <?= $this->Paginator->last(__('last') . ' >>') ?>
                    </ul>
                    <p><?= $this->Paginator->counter(__('Page {{page}} of {{pages}}, showing {{current}} record(s) out of {{count}} total')) ?></p>
                </div>
            </div>
        </div>
    </section>
</div>
