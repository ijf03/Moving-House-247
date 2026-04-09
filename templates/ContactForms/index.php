<?php
/**
 * @var \App\View\AppView $this
 * @var iterable<\App\Model\Entity\ContactForm> $contactForms
 */
?>
<div class="contactForms index content">
    <h3><?= __('Contact Forms') ?></h3>

    <style>
        .unreplied-row {
            background-color: #eaf9ea;
        }
    </style>

    <div class="table-responsive">
        <table>
            <thead>
            <tr>
                <th><?= __('Contact Form') ?></th>
                <th><?= __('Customer') ?></th>
                <th><?= __('First Name') ?></th>
                <th><?= __('Last Name') ?></th>
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
                <tr class="<?= ($contactForm->status ?? 'new') !== 'replied' ? 'unreplied-row' : '' ?>">
                    <td><?= $this->Number->format($contactForm->contact_form_id) ?></td>
                    <td>
                        <?= $contactForm->hasValue('customer')
                            ? $this->Html->link(
                                $contactForm->customer->first_name . ' ' . $contactForm->customer->last_name,
                                ['controller' => 'Customers', 'action' => 'view', $contactForm->customer->customer_id]
                            )
                            : '' ?>
                    </td>
                    <td><?= h($contactForm->customer->first_name ?? '') ?></td>
                    <td><?= h($contactForm->customer->last_name ?? '') ?></td>
                    <td><?= h($contactForm->customer->email ?? '') ?></td>
                    <td><?= h($contactForm->customer->phone ?? '') ?></td>
                    <td><?= h($contactForm->subject) ?></td>
                    <td><?= h($contactForm->created) ?></td>
                    <td><?= h(ucfirst($contactForm->status ?? 'new')) ?></td>
                    <td class="actions">
                        <?= $this->Html->link(__('View'), ['action' => 'view', $contactForm->contact_form_id]) ?>
                        <?= $this->Html->link(__('Edit'), ['action' => 'edit', $contactForm->contact_form_id]) ?>
                        <?= $this->Form->postLink(
                            __('Delete'),
                            ['action' => 'delete', $contactForm->contact_form_id],
                            [
                                'method' => 'delete',
                                'confirm' => __('Are you sure you want to delete # {0}?', $contactForm->contact_form_id),
                            ]
                        ) ?>
                    </td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <div class="paginator">
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
