<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\ContactForm $contactForm
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('Edit Contact Form'), ['action' => 'edit', $contactForm->contact_form_id], ['class' => 'side-nav-item']) ?>
            <?= $this->Form->postLink(
                __('Delete Contact Form'),
                ['action' => 'delete', $contactForm->contact_form_id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $contactForm->contact_form_id), 'class' => 'side-nav-item']
            ) ?>
            <?= $this->Html->link(__('List Contact Forms'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('Reply to Message'), ['action' => 'reply', $contactForm->contact_form_id], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>

    <div class="column column-80">
        <div class="contactForms view content">
            <h3><?= h(($contactForm->customer->first_name ?? '') . ' ' . ($contactForm->customer->last_name ?? '')) ?></h3>

            <table>
                <tr>
                    <th><?= __('Customer') ?></th>
                    <td>
                        <?= $contactForm->hasValue('customer')
                            ? $this->Html->link(
                                $contactForm->customer->first_name . ' ' . $contactForm->customer->last_name,
                                ['controller' => 'Customers', 'action' => 'view', $contactForm->customer->customer_id]
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
                    <td><?= h(ucfirst($contactForm->status ?? 'new')) ?></td>
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
            </table>

            <div class="text">
                <strong><?= __('Customer Message') ?></strong>
                <blockquote>
                    <?= $this->Text->autoParagraph(h($contactForm->message)); ?>
                </blockquote>
            </div>

            <div class="text">
                <strong><?= __('Admin Reply') ?></strong>
                <blockquote>
                    <?= !empty($contactForm->admin_reply)
                        ? $this->Text->autoParagraph(h($contactForm->admin_reply))
                        : __('No reply has been sent yet.') ?>
                </blockquote>
            </div>
        </div>
    </div>
</div>
