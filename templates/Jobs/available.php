<?php
/**
 * @var \App\View\AppView $this
 * @var iterable<\App\Model\Entity\Job> $jobs
 */
?>

<h2>Available Jobs</h2>

<?php if ($jobs->isEmpty()): ?>
    <p>No available jobs found.</p>
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
            <th>Action</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($jobs as $job): ?>
            <tr>
                <td><?= h($job->job_id) ?></td>
                <td><?= h($job->description) ?></td>
                <td><?= h($job->pickup_address) ?></td>
                <td><?= h($job->dropoff_address) ?></td>
                <td><?= h($job->job_date) ?></td>
                <td><?= h($job->job_time) ?></td>
                <td>
                    <?= h($job->confirmed_count ?? 0) ?> / <?= h($job->staff_required) ?>
                </td>
                <td>
                    <?= $this->Html->link(
                        __('View'),
                        ['action' => 'view', $job->job_id],
                        ['class' => 'button']
                    ) ?>

                    <?= $this->Form->postLink(
                        __('Take Job'),
                        ['action' => 'takeJob', $job->job_id],
                        ['confirm' => __('Are you sure you want to take this job?')]
                    ) ?>

                    <?= $this->Form->postLink(
                        __('Not Interested'),
                        ['action' => 'notInterested', $job->job_id],
                        ['confirm' => __('Hide this job from your list?')]
                    ) ?>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
<?php endif; ?>
