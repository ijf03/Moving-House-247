<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\JobType $jobType
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $jobType->job_type_id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $jobType->job_type_id), 'class' => 'side-nav-item']
            ) ?>
            <?= $this->Html->link(__('List Job Types'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column column-80">
        <div class="jobTypes form content">
            <?= $this->Form->create($jobType) ?>
            <fieldset>
                <legend><?= __('Edit Job Type') ?></legend>
                <?php
                    echo $this->Form->control('job_type_name');
                    echo $this->Form->control('job_type_description');
                ?>
            </fieldset>
            <?= $this->Form->button(__('Submit')) ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>
