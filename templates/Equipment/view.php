<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Equipment $equipmentEntity
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('Edit Equipment'), ['action' => 'edit', $equipmentEntity->equipment_id], ['class' => 'side-nav-item']) ?>
            <?= $this->Form->postLink(__('Delete Equipment'), ['action' => 'delete', $equipmentEntity->equipment_id], ['confirm' => __('Are you sure you want to delete # {0}?', $equipmentEntity->equipment_id), 'class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('List Equipment'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('New Equipment'), ['action' => 'add'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column column-80">
        <div class="equipment view content">
            <h3><?= h($equipmentEntity->name) ?></h3>
            <table>
                <tr>
                    <th><?= __('Name') ?></th>
                    <td><?= h($equipmentEntity->name) ?></td>
                </tr>
                <tr>
                    <th><?= __('Category') ?></th>
                    <td><?= h($equipmentEntity->category) ?></td>
                </tr>
                <tr>
                    <th><?= __('Status') ?></th>
                    <td><?= h($equipmentEntity->status) ?></td>
                </tr>
                <tr>
                    <th><?= __('Storage Location') ?></th>
                    <td><?= h($equipmentEntity->storage_location) ?></td>
                </tr>
                <tr>
                    <th><?= __('Equipment Id') ?></th>
                    <td><?= $this->Number->format($equipmentEntity->equipment_id) ?></td>
                </tr>
                <tr>
                    <th><?= __('Quantity Available') ?></th>
                    <td><?= $this->Number->format($equipmentEntity->quantity_available) ?></td>
                </tr>
                <tr>
                    <th><?= __('Created') ?></th>
                    <td><?= h($equipmentEntity->created) ?></td>
                </tr>
                <tr>
                    <th><?= __('Modified') ?></th>
                    <td><?= h($equipmentEntity->modified) ?></td>
                </tr>
                <tr>
                    <th><?= __('Is Active') ?></th>
                    <td><?= $equipmentEntity->is_active ? __('Yes') : __('No'); ?></td>
                </tr>
            </table>
            <div class="text">
                <strong><?= __('Condition Notes') ?></strong>
                <blockquote>
                    <?= $this->Text->autoParagraph(h($equipmentEntity->condition_notes)); ?>
                </blockquote>
            </div>
        </div>
    </div>
</div>