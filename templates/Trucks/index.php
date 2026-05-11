<?php
/**
 * @var \App\View\AppView $this
 * @var iterable<\App\Model\Entity\Truck> $trucks
 */
?>
<div class="trucks index content">
    <?= $this->Html->link(__('New Truck'), ['action' => 'add'], ['class' => 'button float-right']) ?>
    <h3><?= __('Trucks') ?></h3>
    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th><?= $this->Paginator->sort('truck_id') ?></th>
                    <th><?= $this->Paginator->sort('name') ?></th>
                    <th><?= $this->Paginator->sort('rego') ?></th>
                    <th><?= $this->Paginator->sort('truck_size') ?></th>
                    <th><?= $this->Paginator->sort('capacity_m3') ?></th>
                    <th><?= $this->Paginator->sort('max_payload_kg') ?></th>
                    <th><?= $this->Paginator->sort('status') ?></th>
                    <th><?= $this->Paginator->sort('current_location') ?></th>
                    <th><?= $this->Paginator->sort('next_service_date') ?></th>
                    <th><?= $this->Paginator->sort('is_active') ?></th>
                    <th><?= $this->Paginator->sort('created') ?></th>
                    <th><?= $this->Paginator->sort('modified') ?></th>
                    <th class="actions"><?= __('Actions') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($trucks as $truck): ?>
                <tr>
                    <td><?= $this->Number->format($truck->truck_id) ?></td>
                    <td><?= h($truck->name) ?></td>
                    <td><?= h($truck->rego) ?></td>
                    <td><?= h($truck->truck_size) ?></td>
                    <td><?= $truck->capacity_m3 === null ? '' : $this->Number->format($truck->capacity_m3) ?></td>
                    <td><?= $truck->max_payload_kg === null ? '' : $this->Number->format($truck->max_payload_kg) ?></td>
                    <td><?= h($truck->status) ?></td>
                    <td><?= h($truck->current_location) ?></td>
                    <td><?= h($truck->next_service_date) ?></td>
                    <td><?= h($truck->is_active) ?></td>
                    <td><?= h($truck->created) ?></td>
                    <td><?= h($truck->modified) ?></td>
                    <td class="actions">
                        <?= $this->Html->link(__('View'), ['action' => 'view', $truck->truck_id]) ?>
                        <?= $this->Html->link(__('Edit'), ['action' => 'edit', $truck->truck_id]) ?>
                        <?= $this->Form->postLink(
                            __('Delete'),
                            ['action' => 'delete', $truck->truck_id],
                            [
                                'method' => 'delete',
                                'confirm' => __('Are you sure you want to delete # {0}?', $truck->truck_id),
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