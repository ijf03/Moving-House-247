<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\InvoiceItem $invoiceItem
 * @var string[]|\Cake\Collection\CollectionInterface $invoices
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $invoiceItem->invoice_item_id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $invoiceItem->invoice_item_id), 'class' => 'side-nav-item']
            ) ?>
            <?= $this->Html->link(__('List Invoice Items'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column column-80">
        <div class="invoiceItems form content">
            <?= $this->Form->create($invoiceItem) ?>
            <fieldset>
                <legend><?= __('Edit Invoice Item') ?></legend>
                <?php
                    echo $this->Form->control('invoice_id', ['options' => $invoices]);
                    echo $this->Form->control('description');
                    echo $this->Form->control('quantity');
                    echo $this->Form->control('unit_price_cents');
                    echo $this->Form->control('line_total_cents');
                    echo $this->Form->control('sort_order');
                ?>
            </fieldset>
            <?= $this->Form->button(__('Save Changes')) ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>
