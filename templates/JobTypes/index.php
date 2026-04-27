<?php
/**
 * @var \App\View\AppView $this
 * @var iterable<\App\Model\Entity\JobType> $jobTypes
 */
?>
<div class="jobTypes index content">
    <?= $this->Html->link(__('New Job Type'), ['action' => 'add'], ['class' => 'button float-right']) ?>
    <h3><?= __('Job Types') ?></h3>
    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th><?= $this->Paginator->sort('job_type_id') ?></th>
                    <th><?= $this->Paginator->sort('job_type_name') ?></th>
                    <th class="actions"><?= __('Actions') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($jobTypes as $jobType): ?>
                <tr>
                    <td><?= $this->Number->format($jobType->job_type_id) ?></td>
                    <td><?= h($jobType->job_type_name) ?></td>
                    <td class="actions">
                        <?= $this->Html->link(__('View'), ['action' => 'view', $jobType->job_type_id]) ?>
                        <?= $this->Html->link(__('Edit'), ['action' => 'edit', $jobType->job_type_id]) ?>
                        <?= $this->Form->postLink(
                            __('Delete'),
                            ['action' => 'delete', $jobType->job_type_id],
                            [
                                'method' => 'delete',
                                'confirm' => __('Are you sure you want to delete # {0}?', $jobType->job_type_id),
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