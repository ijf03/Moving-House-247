<?php

/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Job $job
 * @var \App\Model\Entity\StaffJob $staffJob
 */
?>

<div class="jobs report content">
    <h3>Submit Job Report</h3>

    <table>
        <tr>
            <th>Job ID</th>
            <td><?= h($job->job_id) ?></td>
        </tr>
        <tr>
            <th>Description</th>
            <td><?= h($job->description) ?></td>
        </tr>
        <tr>
            <th>Pickup Address</th>
            <td><?= h($job->pickup_address) ?></td>
        </tr>
        <tr>
            <th>Dropoff Address</th>
            <td><?= h($job->dropoff_address) ?></td>
        </tr>
        <tr>
            <th>Date</th>
            <td><?= h($job->job_date) ?></td>
        </tr>
        <tr>
            <th>Time</th>
            <td><?= h($job->job_time) ?></td>
        </tr>
        <tr>
            <th>Current Job Status</th>
            <td><?= h($job->status) ?></td>
        </tr>
    </table>

    <?= $this->Form->create($staffJob) ?>

    <fieldset>
        <legend>Job Outcome</legend>

        <?= $this->Form->radio('report_outcome', [
            ['value' => 'Completed', 'text' => 'Job Completed'],
            ['value' => 'Incomplete', 'text' => 'Job Incomplete'],
        ], [
            'value' => $staffJob->report_outcome ?? 'Completed',
            'required' => true,
        ]) ?>

        <?= $this->Form->control('report_notes', [
            'type' => 'textarea',
            'label' => 'Extra Information',
            'placeholder' => 'Add any notes about the job, issues, delays, damages, customer comments, or incomplete work.',
            'rows' => 6,
            'value' => $staffJob->report_notes ?? '',
        ]) ?>
    </fieldset>

    <?= $this->Form->button(__('Submit Report')) ?>
    <?= $this->Form->end() ?>

    <p>
        <?= $this->Html->link(__('Back to Job Details'), ['action' => 'view', $job->job_id]) ?>
    </p>
</div>
