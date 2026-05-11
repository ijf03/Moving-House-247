<?php
/**
 * @var \App\View\AppView $this
 * @var iterable<\App\Model\Entity\Job> $jobs
 */
?>
<div class="jobs index content">
    <?= $this->Html->link(__('New Job'), ['action' => 'add'], ['class' => 'button float-right']) ?>
    <h3><?= __('Jobs') ?></h3>
    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th><?= $this->Paginator->sort('job_id') ?></th>
                    <th><?= $this->Paginator->sort('job_type_id') ?></th>
                    <th><?= $this->Paginator->sort('pickup_address') ?></th>
                    <th><?= $this->Paginator->sort('dropoff_address') ?></th>
                    <th><?= $this->Paginator->sort('job_date') ?></th>
                    <th><?= $this->Paginator->sort('job_time') ?></th>
                    <th><?= __('Staff') ?></th>
                    <th><?= $this->Paginator->sort('customer_id') ?></th>
                    <th><?= $this->Paginator->sort('status') ?></th>
                    <th class="actions"><?= __('Actions') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($jobs as $job): ?>
                <tr>
                    <td><?= $this->Number->format($job->job_id) ?></td>
                    <td><?= $job->hasValue('job_type') ? $this->Html->link($job->job_type->job_type_name, ['controller' => 'JobTypes', 'action' => 'view', $job->job_type->job_type_id]) : '' ?></td>
                    <td><?= h($job->pickup_address) ?></td>
                    <td><?= h($job->dropoff_address) ?></td>
                    <td><?= h($job->job_date) ?></td>
                    <td><?= h($job->job_time) ?></td>
                    <td>
                        <?= h($job->confirmed_count ?? 0) ?> / <?= h($job->staff_required ?? 0) ?>
                    </td>
                    <td><?= $job->hasValue('customer') ? $this->Html->link($job->customer->first_name, ['controller' => 'Customers', 'action' => 'view', $job->customer->customer_id]) : '' ?></td>
                    <td><?= h($job->status) ?></td>
                    <td class="actions">
                        <?= $this->Html->link(__('View'), ['action' => 'view', $job->job_id]) ?>

                        <?php if ($job->status === 'Pending'): ?>
                            <?= $this->Html->link(__('Edit'), ['action' => 'edit', $job->job_id]) ?>

                            <?= $this->Form->postLink(
                                __('Delete'),
                                ['action' => 'delete', $job->job_id],
                                [
                                    'method' => 'delete',
                                    'confirm' => __('Are you sure you want to delete # {0}?', $job->job_id),
                                ]
                            ) ?>

                            <?= $this->Html->link(
                                __('Allocate'),
                                ['action' => 'allocate', $job->job_id],
                                ['class' => 'button']
                            ) ?>
                        <?php endif; ?>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <div class="paginator">
        <ul class="pagination">
            <?= $this->Paginator->first('<< ' . __('first')) ?>
            <?= $this->Paginator->prev('< ' . __('previous')) ?>
            <?= $this->Paginator->numbers() ?>
            <?= $this->Paginator->next(__('next') . ' >') ?>
            <?= $this->Paginator->last(__('last') . ' >>') ?>
        </ul>
        <p><?= $this->Paginator->counter(__('Page {{page}} of {{pages}}, showing {{current}} record(s) out of {{count}} total')) ?></p>
    </div>
</div>
