<?php
/**
 * @var \App\View\AppView $this
 * @var iterable<\App\Model\Entity\StaffJob> $staffJobs
 */
?>

<style>
    .small-job-button {
        font-size: 12px;
        padding: 4px 8px;
        line-height: 1.2;
        height: auto;
        min-height: unset;
        margin: 2px;
    }
</style>

<h2>My Jobs</h2>

<?php if ($staffJobs->isEmpty()): ?>
    <p>You have not taken any jobs yet.</p>
<?php else: ?>
    <table>
        <thead>
        <tr>
            <th>Job ID</th>
            <th>Description</th>
            <th>Pickup</th>
            <th>Dropoff</th>
            <th>Date</th>
            <th>Time</th>
            <th>Staff</th>
            <th>Status</th>
            <th>Report</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($staffJobs as $staffJob): ?>
            <tr>
                <td><?= h($staffJob->job->job_id ?? '') ?></td>
                <td><?= h($staffJob->job->description ?? '') ?></td>
                <td><?= h($staffJob->job->pickup_address ?? '') ?></td>
                <td><?= h($staffJob->job->dropoff_address ?? '') ?></td>
                <td><?= h($staffJob->job->job_date ?? '') ?></td>
                <td><?= h($staffJob->job->job_time ?? '') ?></td>
                <td>
                    <?= h($staffJob->confirmed_count ?? 0) ?> / <?= h($staffJob->job->staff_required ?? 0) ?>
                </td>
                <td><?= h($staffJob->job->status ?? '') ?></td>
                <td>
                    <?php if (!empty($staffJob->report_outcome)): ?>
                        Submitted
                    <?php elseif (($staffJob->job->status ?? '') === 'Ready'): ?>
                        <?= $this->Html->link(
                            __('Submit Report'),
                            ['controller' => 'Jobs', 'action' => 'report', $staffJob->job->job_id],
                            ['class' => 'button small-job-button']
                        ) ?>
                    <?php else: ?>
                        Not available yet
                    <?php endif; ?>
                </td>
                <td>
                    <?= $this->Html->link(
                        __('View'),
                        ['controller' => 'Jobs', 'action' => 'view', $staffJob->job->job_id],
                        ['class' => 'button small-job-button']
                    ) ?>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
<?php endif; ?>
