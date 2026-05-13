<?php
/**
 * @var \App\View\AppView $this
 * @var iterable<\App\Model\Entity\JobResource> $jobResources
 */
?>
<div class="jobResources index content">
    <?= $this->Html->link(__('New Booking Resource'), ['action' => 'add'], ['class' => 'button float-right']) ?>
    <h3><?= __('Booking Resources') ?></h3>
    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th><?= $this->Paginator->sort('booking_resource_id') ?></th>
                    <th><?= $this->Paginator->sort('booking_id') ?></th>
                    <th><?= $this->Paginator->sort('resource_type') ?></th>
                    <th><?= $this->Paginator->sort('resource_id') ?></th>
                    <th><?= $this->Paginator->sort('quantity') ?></th>
                    <th><?= $this->Paginator->sort('created') ?></th>
                    <th><?= $this->Paginator->sort('modified') ?></th>
                    <th class="actions"><?= __('Actions') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($jobResources as $jobResource): ?>
                <tr>
                    <td><?= $this->Number->format($jobResource->job_resource_id) ?></td>
                    <td><?= $jobResource->hasValue('booking') ? $this->Html->link($jobResource->job->booking_id, ['controller' => 'Jobs', 'action' => 'view', $jobResource->job->booking_id]) : '' ?></td>
                    <td><?= h($jobResource->resource_type) ?></td>
                    <td><?= $this->Number->format($jobResource->job_resource_id) ?></td>
                    <td><?= $this->Number->format($jobResource->quantity) ?></td>
                    <td class="actions">
                        <?= $this->Html->link(__('View'), ['action' => 'view', $jobResource->job_resource_id]) ?>
                        <?= $this->Html->link(__('Edit'), ['action' => 'edit', $jobResource->job_resource_id]) ?>
                        <?= $this->Form->postLink(
                            __('Delete'),
                            ['action' => 'delete', $jobResource->job_resource_id],
                            [
                                'method' => 'delete',
                                'confirm' => __('Are you sure you want to delete # {0}?', $jobResource->job_resource_id),
                            ]
                        ) ?>
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
