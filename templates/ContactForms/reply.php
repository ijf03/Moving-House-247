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
            <?= $this->Html->link(__('Back to Message'), ['action' => 'view', $contactForm->contact_form_id], ['class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('List Contact Forms'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>

    <div class="column column-80">
        <div class="contactForms form content">
            <h3><?= __('Reply to Contact Message') ?></h3>

            <p><strong>Name:</strong> <?= h(($contactForm->customer->first_name ?? '') . ' ' . ($contactForm->customer->last_name ?? '')) ?></p>
            <p><strong>Email:</strong> <?= h($contactForm->customer->email ?? '') ?></p>
            <p><strong>Subject:</strong> <?= h($contactForm->subject) ?></p>

            <p><strong>Original Message:</strong></p>
            <blockquote>
                <?= $this->Text->autoParagraph(h($contactForm->message)) ?>
            </blockquote>

            <?php if (!empty($contactForm->admin_reply)): ?>
                <p><strong>Previous Admin Reply:</strong></p>
                <blockquote>
                    <?= $this->Text->autoParagraph(h($contactForm->admin_reply)) ?>
                </blockquote>
            <?php endif; ?>

            <?= $this->Form->create() ?>
            <fieldset>
                <legend><?= __('Send Reply') ?></legend>
                <?= $this->Form->control('reply_message', [
                    'type' => 'textarea',
                    'label' => 'Reply Message',
                    'required' => true
                ]) ?>
            </fieldset>
            <?= $this->Form->button(__('Send Email')) ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>
