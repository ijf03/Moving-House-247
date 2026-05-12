<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\StorageUnit $storageUnit
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('Edit Storage Unit'), ['action' => 'edit', $storageUnit->storage_unit_id], ['class' => 'side-nav-item']) ?>
            <?= $this->Form->postLink(__('Delete Storage Unit'), ['action' => 'delete', $storageUnit->storage_unit_id], ['confirm' => __('Are you sure you want to delete # {0}?', $storageUnit->storage_unit_id), 'class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('List Storage Units'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('New Storage Unit'), ['action' => 'add'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column column-80">
        <div class="storageUnits view content">
            <h3><?= h($storageUnit->unit_code) ?></h3>
            <table>
                <tr>
                    <th><?= __('Unit Code') ?></th>
                    <td><?= h($storageUnit->unit_code) ?></td>
                </tr>
                <tr>
                    <th><?= __('Facility Name') ?></th>
                    <td><?= h($storageUnit->facility_name) ?></td>
                </tr>
                <tr>
                    <th><?= __('Status') ?></th>
                    <td><?= h($storageUnit->status) ?></td>
                </tr>
                <tr>
                    <th><?= __('Security Level') ?></th>
                    <td><?= h($storageUnit->security_level) ?></td>
                </tr>
                <tr>
                    <th><?= __('Storage Unit Id') ?></th>
                    <td><?= $this->Number->format($storageUnit->storage_unit_id) ?></td>
                </tr>
                <tr>
                    <th><?= __('Unit Size M3') ?></th>
                    <td><?= $storageUnit->unit_size_m3 === null ? '' : $this->Number->format($storageUnit->unit_size_m3) ?></td>
                </tr>
                <tr>
                    <th><?= __('Created') ?></th>
                    <td><?= h($storageUnit->created) ?></td>
                </tr>
                <tr>
                    <th><?= __('Modified') ?></th>
                    <td><?= h($storageUnit->modified) ?></td>
                </tr>
                <tr>
                    <th><?= __('Is Climate Controlled') ?></th>
                    <td><?= $storageUnit->is_climate_controlled ? __('Yes') : __('No'); ?></td>
                </tr>
                <tr>
                    <th><?= __('Is Active') ?></th>
                    <td><?= $storageUnit->is_active ? __('Yes') : __('No'); ?></td>
                </tr>
            </table>
        </div>
    </div>
</div>