<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Truck $truck
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('List Trucks'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column column-80">
        <div class="trucks form content">
            <?= $this->Form->create($truck) ?>
            <fieldset>
                <legend><?= __('Add Truck') ?></legend>
                <?php
                    echo $this->Form->control('name');
                    echo $this->Form->control('rego');
                    echo $this->Form->control('truck_size');
                    echo $this->Form->control('capacity_m3');
                    echo $this->Form->control('max_payload_kg');
                    echo $this->Form->control('status');
                    echo $this->Form->control('current_location');
                    echo $this->Form->control('next_service_date', ['empty' => true]);
                    echo $this->Form->control('is_active');
                ?>
            </fieldset>
            <?= $this->Form->button(__('Submit')) ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>
