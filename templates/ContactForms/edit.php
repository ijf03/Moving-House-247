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
            <?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $contactForm->contact_form_id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $contactForm->contact_form_id), 'class' => 'side-nav-item']
            ) ?>
            <?= $this->Html->link(__('List Contact Forms'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>

    <div class="column column-80">
        <div class="contactForms form content">
            <?= $this->Form->create($contactForm) ?>
            <fieldset>
                <legend><?= __('Edit Contact Form') ?></legend>
                <?php
                echo $this->Form->control('first_name', [
                    'value' => $contactForm->customer->first_name ?? ''
                ]);
                echo $this->Form->control('last_name', [
                    'value' => $contactForm->customer->last_name ?? ''
                ]);
                echo $this->Form->control('email', [
                    'value' => $contactForm->customer->email ?? ''
                ]);
                echo $this->Form->control('phone', [
                    'value' => $contactForm->customer->phone ?? ''
                ]);
                echo $this->Form->control('subject');
                echo $this->Form->control('message');
                ?>
            </fieldset>
            <?= $this->Form->button(__('Submit')) ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>
