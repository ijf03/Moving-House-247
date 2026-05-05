<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Truck $truck
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('Edit Truck'), ['action' => 'edit', $truck->truck_id], ['class' => 'side-nav-item']) ?>
            <?= $this->Form->postLink(__('Delete Truck'), ['action' => 'delete', $truck->truck_id], ['confirm' => __('Are you sure you want to delete # {0}?', $truck->truck_id), 'class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('List Trucks'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('New Truck'), ['action' => 'add'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column column-80">
        <div class="trucks view content">
            <h3><?= h($truck->name) ?></h3>
            <table>
                <tr>
                    <th><?= __('Name') ?></th>
                    <td><?= h($truck->name) ?></td>
                </tr>
                <tr>
                    <th><?= __('Rego') ?></th>
                    <td><?= h($truck->rego) ?></td>
                </tr>
                <tr>
                    <th><?= __('Truck Size') ?></th>
                    <td><?= h($truck->truck_size) ?></td>
                </tr>
                <tr>
                    <th><?= __('Status') ?></th>
                    <td><?= h($truck->status) ?></td>
                </tr>
                <tr>
                    <th><?= __('Current Location') ?></th>
                    <td><?= h($truck->current_location) ?></td>
                </tr>
                <tr>
                    <th><?= __('Truck Id') ?></th>
                    <td><?= $this->Number->format($truck->truck_id) ?></td>
                </tr>
                <tr>
                    <th><?= __('Capacity M3') ?></th>
                    <td><?= $truck->capacity_m3 === null ? '' : $this->Number->format($truck->capacity_m3) ?></td>
                </tr>
                <tr>
                    <th><?= __('Max Payload Kg') ?></th>
                    <td><?= $truck->max_payload_kg === null ? '' : $this->Number->format($truck->max_payload_kg) ?></td>
                </tr>
                <tr>
                    <th><?= __('Next Service Date') ?></th>
                    <td><?= h($truck->next_service_date) ?></td>
                </tr>
                <tr>
                    <th><?= __('Created') ?></th>
                    <td><?= h($truck->created) ?></td>
                </tr>
                <tr>
                    <th><?= __('Modified') ?></th>
                    <td><?= h($truck->modified) ?></td>
                </tr>
                <tr>
                    <th><?= __('Is Active') ?></th>
                    <td><?= $truck->is_active ? __('Yes') : __('No'); ?></td>
                </tr>
            </table>
        </div>
    </div>
</div>