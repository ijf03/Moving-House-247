<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Staff $staffEntity
 */
?>
<div class="row">
    <section class="admin-section">
        <div class="container">
            <div class="row g-4 justify-content-center">
                <div class="col-lg-3">
                    <div class="mh-back-btn m-1">
                        <?= $this->Html->link(__('← Back to List'), ['action' => 'index']) ?>
                    </div>
                    <div class="admin-table-card">
                        <div class="admin-table-header">
                            <h2><?= __('Actions') ?></h2>
                            <p><?= __('Manage this user record.') ?></p>
                        </div>

                        <div class="admin-action-stack">
                            <?= $this->Html->link(__('Edit Staff'), ['action' => 'edit', $staffEntity->staff_id], ['class' => 'admin-action-link']) ?>

                            <?= $this->Form->postLink(
                                __('Delete Staff'),
                                ['action' => 'delete', $staffEntity->staff_id],
                                [
                                    'confirm' => __('Are you sure you want to delete {0}?', $staffEntity->full_name),
                                    'class' => 'admin-action-link admin-action-link-danger'
                                ]
                            ) ?>
                        </div>
                    </div>
                </div>
    <div class="col-lg-9">
        <div class="staff view content">
            <h3><?= h($staffEntity->first_name) ?></h3>
            <table>
                <tr>
                    <th><?= __('First Name') ?></th>
                    <td><?= h($staffEntity->first_name) ?></td>
                </tr>
                <tr>
                    <th><?= __('Last Name') ?></th>
                    <td><?= h($staffEntity->last_name) ?></td>
                </tr>
                <tr>
                    <th><?= __('Email') ?></th>
                    <td><?= h($staffEntity->email) ?></td>
                </tr>
                <tr>
                    <th><?= __('Phone') ?></th>
                    <td><?= h($staffEntity->phone) ?></td>
                </tr>
                <tr>
                    <th><?= __('Owns driver license') ?></th>
                    <td><?= $staffEntity->isDriver ? __('Yes') : __('No'); ?></td>
                </tr>
            </table>
        </div>
    </div>
</div>
