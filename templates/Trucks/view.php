<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Truck $truck
 */
?>

<div class="mh-page-soft">
    <section class="admin-hero">
        <div class="container">
            <div class="admin-hero-shell">
                <div class="admin-hero-content">
                    <span class="admin-eyebrow"><?= __('Resources') ?></span>
                    <h1><?= __('Registration: {0}', h($truck->rego)) ?></h1>
                    <p class="admin-hero-text">
                        <?= __('View truck details, capacity, location, service information, and current availability.') ?>
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
                            <p><?= __('Manage this truck record.') ?></p>
                        </div>

                        <div class="admin-action-stack">
                            <?= $this->Html->link(__('Edit Truck'), ['action' => 'edit', $truck->truck_id], ['class' => 'admin-action-link']) ?>

                            <?= $this->Html->link(__('List Trucks'), ['action' => 'index'], ['class' => 'admin-action-link']) ?>

                            <?= $this->Html->link(__('New Truck'), ['action' => 'add'], ['class' => 'admin-action-link']) ?>

                            <?= $this->Form->postLink(
                                __('Delete Truck'),
                                ['action' => 'delete', $truck->truck_id],
                                [
                                    'confirm' => __('Are you sure you want to delete # {0}?', $truck->truck_id),
                                    'class' => 'admin-action-link admin-action-danger'
                                ]
                            ) ?>
                        </div>
                    </div>
                </div>

                <div class="col-lg-9">
                    <div class="admin-table-card">
                        <div class="admin-table-header">
                            <h2><?= __('Truck Information') ?></h2>
                            <p><?= __('Detailed information for this truck resource.') ?></p>
                        </div>

                        <div class="table-responsive">
                            <table class="table admin-table">
                                <tbody>
                                <tr>
                                    <th><?= __('Registration') ?></th>
                                    <td><?= h($truck->rego) ?></td>
                                </tr>
                                <tr>
                                    <th><?= __('Current Location') ?></th>
                                    <td><?= h($truck->current_location) ?></td>
                                </tr>
                                <tr>
                                    <th><?= __('Truck ID') ?></th>
                                    <td><?= $this->Number->format($truck->truck_id) ?></td>
                                </tr>
                                <tr>
                                    <th><?= __('Capacity (m³)') ?></th>
                                    <td><?= $truck->capacity_m3 === null ? '' : $this->Number->format($truck->capacity_m3) ?></td>
                                </tr>
                                <tr>
                                    <th><?= __('Max Payload (kg)') ?></th>
                                    <td><?= $truck->max_payload_kg === null ? '' : $this->Number->format($truck->max_payload_kg) ?></td>
                                </tr>
                                <tr>
                                    <th><?= __('Next Service Date') ?></th>
                                    <td><?= h($truck->next_service_date) ?></td>
                                </tr>
                                <tr>
                                    <th><?= __('Created') ?></th>
                                    <td><?= h($truck->created?->format('d/m/Y')) ?></td>
                                </tr>
                                <tr>
                                    <th><?= __('Modified') ?></th>
                                    <td><?= h($truck->modified?->format('d/m/Y')) ?></td>
                                </tr>
                                <tr>
                                    <th><?= __('Active') ?></th>
                                    <td><?= $truck->is_active ? __('Yes') : __('No') ?></td>
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
