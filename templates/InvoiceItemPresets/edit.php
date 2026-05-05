<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\InvoiceItemPreset $invoiceItemPreset
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $invoiceItemPreset->invoice_item_preset_id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $invoiceItemPreset->invoice_item_preset_id), 'class' => 'side-nav-item']
            ) ?>
            <?= $this->Html->link(__('List Invoice Item Presets'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column column-80">
        <div class="invoiceItemPresets form content">
            <?= $this->Form->create($invoiceItemPreset) ?>
            <fieldset>
                <legend><?= __('Edit Invoice Item Preset') ?></legend>
                <?php
                    echo $this->Form->control('code');
                    echo $this->Form->control('name');
                    echo $this->Form->control('description');
                    echo $this->Form->control('unit_price_cents');
                    echo $this->Form->control('is_active');
                    echo $this->Form->control('sort_order');
                ?>
            </fieldset>
            <?= $this->Form->button(__('Submit')) ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>
