<?php
/**
 * @var \App\View\AppView $this
 * @var iterable<\App\Model\Entity\Equipment> $equipment
 */
?>
<div class="equipment index content">
    <?= $this->Html->link(__('New Equipment'), ['action' => 'add'], ['class' => 'button float-right']) ?>
    <h3><?= __('Equipment') ?></h3>
    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th><?= $this->Paginator->sort('equipment_id') ?></th>
                    <th><?= $this->Paginator->sort('name') ?></th>
                    <th><?= $this->Paginator->sort('category') ?></th>
                    <th><?= $this->Paginator->sort('quantity_available') ?></th>
                    <th><?= $this->Paginator->sort('status') ?></th>
                    <th><?= $this->Paginator->sort('storage_location') ?></th>
                    <th><?= $this->Paginator->sort('is_active') ?></th>
                    <th><?= $this->Paginator->sort('created') ?></th>
                    <th><?= $this->Paginator->sort('modified') ?></th>
                    <th class="actions"><?= __('Actions') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($equipment as $equipmentEntity): ?>
                <tr>
                    <td><?= $this->Number->format($equipmentEntity->equipment_id) ?></td>
                    <td><?= h($equipmentEntity->name) ?></td>
                    <td><?= h($equipmentEntity->category) ?></td>
                    <td><?= $this->Number->format($equipmentEntity->quantity_available) ?></td>
                    <td><?= h($equipmentEntity->status) ?></td>
                    <td><?= h($equipmentEntity->storage_location) ?></td>
                    <td><?= h($equipmentEntity->is_active) ?></td>
                    <td><?= h($equipmentEntity->created) ?></td>
                    <td><?= h($equipmentEntity->modified) ?></td>
                    <td class="actions">
                        <?= $this->Html->link(__('View'), ['action' => 'view', $equipmentEntity->equipment_id]) ?>
                        <?= $this->Html->link(__('Edit'), ['action' => 'edit', $equipmentEntity->equipment_id]) ?>
                        <?= $this->Form->postLink(
                            __('Delete'),
                            ['action' => 'delete', $equipmentEntity->equipment_id],
                            [
                                'method' => 'delete',
                                'confirm' => __('Are you sure you want to delete # {0}?', $equipmentEntity->equipment_id),
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