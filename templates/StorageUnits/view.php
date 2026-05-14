<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\StorageUnit $storageUnit
 */
?>

<div class="mh-page-soft">
    <section class="admin-hero">
        <div class="container">
            <div class="admin-hero-shell">
                <div class="admin-hero-content">
                    <span class="admin-eyebrow"><?= __('Resources') ?></span>
                    <h1><?= h($storageUnit->unit_code) ?></h1>
                    <p class="admin-hero-text">
                        <?= __('View storage unit details, facility information, and current availability status.') ?>
                    </p>
                </div>
            </div>
        </div>
    </section>

    <section class="admin-section">
        <div class="container">
            <div class="row g-4 justify-content-center">
                <div class="col-lg-3">
                    <div class="admin-table-card">
                        <div class="admin-table-header">
                            <h2><?= __('Actions') ?></h2>
                            <p><?= __('Manage this storage unit record.') ?></p>
                        </div>

                        <div class="admin-action-stack">
                            <?= $this->Html->link(__('Edit Storage Unit'), ['action' => 'edit', $storageUnit->storage_unit_id], ['class' => 'admin-action-link']) ?>

                            <?= $this->Html->link(__('List Storage Units'), ['action' => 'index'], ['class' => 'admin-action-link']) ?>

                            <?= $this->Html->link(__('New Storage Unit'), ['action' => 'add'], ['class' => 'admin-action-link']) ?>

                            <?= $this->Form->postLink(
                                __('Delete Storage Unit'),
                                ['action' => 'delete', $storageUnit->storage_unit_id],
                                [
                                    'confirm' => __('Are you sure you want to delete # {0}?', $storageUnit->storage_unit_id),
                                    'class' => 'admin-action-link admin-action-danger'
                                ]
                            ) ?>
                        </div>
                    </div>
                </div>

                <div class="col-lg-9">
                    <div class="admin-table-card">
                        <div class="admin-table-header">
                            <h2><?= __('Storage Unit Information') ?></h2>
                            <p><?= __('Detailed information for this storage unit.') ?></p>
                        </div>

                        <div class="table-responsive">
                            <table class="table admin-table">
                                <tbody>
                                <tr>
                                    <th><?= __('Unit Code') ?></th>
                                    <td><?= h($storageUnit->unit_code) ?></td>
                                </tr>
                                <tr>
                                    <th><?= __('Facility Name') ?></th>
                                    <td><?= h($storageUnit->facility_name) ?></td>
                                </tr>
                                <tr>
                                    <th><?= __('Security Level') ?></th>
                                    <td><?= h($storageUnit->security_level) ?></td>
                                </tr>
                                <tr>
                                    <th><?= __('Storage Unit ID') ?></th>
                                    <td><?= $this->Number->format($storageUnit->storage_unit_id) ?></td>
                                </tr>
                                <tr>
                                    <th><?= __('Unit Size m³') ?></th>
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
                                    <th><?= __('Climate Controlled') ?></th>
                                    <td><?= $storageUnit->is_climate_controlled ? __('Yes') : __('No') ?></td>
                                </tr>
                                <tr>
                                    <th><?= __('Active') ?></th>
                                    <td><?= $storageUnit->is_active ? __('Yes') : __('No') ?></td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
