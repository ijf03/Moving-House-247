<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\StorageUnit $storageUnit
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('List Storage Units'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column column-80">
        <div class="storageUnits form content">
            <?= $this->Form->create($storageUnit) ?>
            <fieldset>
                <legend><?= __('Add Storage Unit') ?></legend>
                <?php
                    echo $this->Form->control('unit_code');
                    echo $this->Form->control('facility_name');
                    echo $this->Form->control('unit_size_m3');
                    echo $this->Form->control('status');
                    echo $this->Form->control('security_level');
                    echo $this->Form->control('is_climate_controlled');
                    echo $this->Form->control('is_active');
                ?>
            </fieldset>
            <?= $this->Form->button(__('Submit')) ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>
