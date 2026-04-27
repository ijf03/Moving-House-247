<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Job $job
 * @var string[]|\Cake\Collection\CollectionInterface $jobTypes
 * @var string[]|\Cake\Collection\CollectionInterface $customers
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $job->job_id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $job->job_id), 'class' => 'side-nav-item']
            ) ?>
            <?= $this->Html->link(__('List Jobs'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column column-80">
        <div class="jobs form content">
            <?= $this->Form->create($job) ?>
            <fieldset>
                <legend><?= __('Edit Job') ?></legend>
                <?php
                    echo $this->Form->control('job_type_id', ['options' => $jobTypes]);
                    echo $this->Form->control('description');
                    echo $this->Form->control('pickup_address');
                    echo $this->Form->control('dropoff_address');
                    echo $this->Form->control('job_date');
                    echo $this->Form->control('job_time');
                    echo $this->Form->control('customer_id', ['options' => $customers]);
                ?>
            </fieldset>
            <?= $this->Form->button(__('Submit')) ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>
