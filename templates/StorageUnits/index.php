<?php
/**
 * @var \App\View\AppView $this
 * @var iterable<\App\Model\Entity\StorageUnit> $storageUnits
 */
?>
<div class="storageUnits index content">
    <?= $this->Html->link(__('New Storage Unit'), ['action' => 'add'], ['class' => 'button float-right']) ?>
    <h3><?= __('Storage Units') ?></h3>
    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th><?= $this->Paginator->sort('storage_unit_id') ?></th>
                    <th><?= $this->Paginator->sort('unit_code') ?></th>
                    <th><?= $this->Paginator->sort('facility_name') ?></th>
                    <th><?= $this->Paginator->sort('unit_size_m3') ?></th>
                    <th><?= $this->Paginator->sort('status') ?></th>
                    <th><?= $this->Paginator->sort('security_level') ?></th>
                    <th><?= $this->Paginator->sort('is_climate_controlled') ?></th>
                    <th><?= $this->Paginator->sort('is_active') ?></th>
                    <th><?= $this->Paginator->sort('created') ?></th>
                    <th><?= $this->Paginator->sort('modified') ?></th>
                    <th class="actions"><?= __('Actions') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($storageUnits as $storageUnit): ?>
                <tr>
                    <td><?= $this->Number->format($storageUnit->storage_unit_id) ?></td>
                    <td><?= h($storageUnit->unit_code) ?></td>
                    <td><?= h($storageUnit->facility_name) ?></td>
                    <td><?= $storageUnit->unit_size_m3 === null ? '' : $this->Number->format($storageUnit->unit_size_m3) ?></td>
                    <td><?= h($storageUnit->status) ?></td>
                    <td><?= h($storageUnit->security_level) ?></td>
                    <td><?= h($storageUnit->is_climate_controlled) ?></td>
                    <td><?= h($storageUnit->is_active) ?></td>
                    <td><?= h($storageUnit->created) ?></td>
                    <td><?= h($storageUnit->modified) ?></td>
                    <td class="actions">
                        <?= $this->Html->link(__('View'), ['action' => 'view', $storageUnit->storage_unit_id]) ?>
                        <?= $this->Html->link(__('Edit'), ['action' => 'edit', $storageUnit->storage_unit_id]) ?>
                        <?= $this->Form->postLink(
                            __('Delete'),
                            ['action' => 'delete', $storageUnit->storage_unit_id],
                            [
                                'method' => 'delete',
                                'confirm' => __('Are you sure you want to delete # {0}?', $storageUnit->storage_unit_id),
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