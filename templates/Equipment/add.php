<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Equipment $equipmentEntity
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('List Equipment'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column column-80">
        <div class="equipment form content">
            <?= $this->Form->create($equipmentEntity) ?>
            <fieldset>
                <legend><?= __('Add Equipment') ?></legend>
                <?php
                    echo $this->Form->control('name');
                    echo $this->Form->control('category');
                    echo $this->Form->control('quantity_available');
                    echo $this->Form->control('status');
                    echo $this->Form->control('storage_location');
                    echo $this->Form->control('condition_notes');
                    echo $this->Form->control('is_active');
                ?>
            </fieldset>
            <?= $this->Form->button(__('Submit')) ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>
