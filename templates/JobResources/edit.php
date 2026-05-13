<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\JobResource $jobResource
 * @var string[]|\Cake\Collection\CollectionInterface $jobs
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $jobResource->booking_resource_id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $jobResource->booking_resource_id), 'class' => 'side-nav-item']
            ) ?>
            <?= $this->Html->link(__('List Booking Resources'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column column-80">
        <div class="jobResources form content">
            <?= $this->Form->create($jobResource) ?>
            <fieldset>
                <legend><?= __('Edit Booking Resource') ?></legend>
                <?php
                    echo $this->Form->control('booking_id', ['options' => $jobs, 'empty' => true]);
                    echo $this->Form->control('resource_type');
                    echo $this->Form->control('resource_id');
                    echo $this->Form->control('quantity');
                    echo $this->Form->control('notes');
                ?>
            </fieldset>
            <?= $this->Form->button(__('Submit')) ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>
