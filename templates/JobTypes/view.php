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
            <?= $this->Html->link(__('Edit Job Type'), ['action' => 'edit', $jobType->job_type_id], ['class' => 'side-nav-item']) ?>
            <?= $this->Form->postLink(__('Delete Job Type'), ['action' => 'delete', $jobType->job_type_id], ['confirm' => __('Are you sure you want to delete # {0}?', $jobType->job_type_id), 'class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('List Job Types'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('New Job Type'), ['action' => 'add'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column column-80">
        <div class="jobTypes view content">
            <h3><?= h($jobType->job_type_name) ?></h3>
            <table>
                <tr>
                    <th><?= __('Job Type Name') ?></th>
                    <td><?= h($jobType->job_type_name) ?></td>
                </tr>
                <tr>
                    <th><?= __('Job Type Id') ?></th>
                    <td><?= $this->Number->format($jobType->job_type_id) ?></td>
                </tr>
            </table>
            <div class="text">
                <strong><?= __('Job Type Description') ?></strong>
                <blockquote>
                    <?= $this->Text->autoParagraph(h($jobType->job_type_description)); ?>
                </blockquote>
            </div>
        </div>
    </div>
</div>