<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Job $job
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('Edit Job'), ['action' => 'edit', $job->job_id], ['class' => 'side-nav-item']) ?>
            <?= $this->Form->postLink(__('Delete Job'), ['action' => 'delete', $job->job_id], ['confirm' => __('Are you sure you want to delete # {0}?', $job->job_id), 'class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('List Jobs'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('New Job'), ['action' => 'add'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column column-80">
        <div class="jobs view content">
            <h3><?= h($job->pickup_address) ?></h3>
            <table>
                <tr>
                    <th><?= __('Job Type') ?></th>
                    <td><?= $job->hasValue('job_type') ? $this->Html->link($job->job_type->job_type_name, ['controller' => 'JobTypes', 'action' => 'view', $job->job_type->job_type_id]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('Pickup Address') ?></th>
                    <td><?= h($job->pickup_address) ?></td>
                </tr>
                <tr>
                    <th><?= __('Dropoff Address') ?></th>
                    <td><?= h($job->dropoff_address) ?></td>
                </tr>
                <tr>
                    <th><?= __('Job Date') ?></th>
                    <td><?= h($job->job_date) ?></td>
                </tr>
                <tr>
                    <th><?= __('Job Time') ?></th>
                    <td><?= h($job->job_time) ?></td>
                </tr>
                <tr>
                    <th><?= __('Customer') ?></th>
                    <td><?= $job->hasValue('customer') ? $this->Html->link($job->customer->first_name, ['controller' => 'Customers', 'action' => 'view', $job->customer->customer_id]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('Job Id') ?></th>
                    <td><?= $this->Number->format($job->job_id) ?></td>
                </tr>
            </table>
            <h4>Allocation Information</h4>

            <table>
                <tr>
                    <th>Status</th>
                    <td><?= h($job->status) ?></td>
                </tr>
                <tr>
                    <th>Staff Required</th>
                    <td><?= h($job->staff_required) ?></td>
                </tr>
                <tr>
                    <th>Trucks Required</th>
                    <td><?= h($job->truck_required) ?></td>
                </tr>
                <tr>
                    <th>Allocated Trucks</th>
                    <td>
                        <?php if (!empty($job->job_trucks)): ?>
                            <ul>
                                <?php foreach ($job->job_trucks as $jobTruck): ?>
                                    <li><?= h($jobTruck->truck->rego ?? 'Unknown Truck') ?></li>
                                <?php endforeach; ?>
                            </ul>
                        <?php else: ?>
                            No trucks allocated.
                        <?php endif; ?>
                    </td>
                </tr>
                <tr>
                    <th>Confirmed Staff</th>
                    <td>
                        <?php if (!empty($job->staff_job)): ?>
                            <?= count($job->staff_job) ?> / <?= h($job->staff_required) ?>
                        <?php else: ?>
                            0 / <?= h($job->staff_required) ?>
                        <?php endif; ?>
                    </td>
                </tr>
            </table>
            <div class="text">
                <strong><?= __('Description') ?></strong>
                <blockquote>
                    <?= $this->Text->autoParagraph(h($job->description)); ?>
                </blockquote>
            </div>
        </div>
    </div>
</div>
