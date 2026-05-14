<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Equipment $equipmentEntity
 */
?>

<div class="mh-page-soft">
    <section class="admin-hero">
        <div class="container">
            <div class="admin-hero-shell">
                <div class="admin-hero-content">
                    <span class="admin-eyebrow"><?= __('Resources') ?></span>
                    <h1><?= h($equipmentEntity->name) ?></h1>
                    <p class="admin-hero-text">
                        <?= __('View equipment details, availability, storage location, and condition notes.') ?>
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
                            <p><?= __('Manage this equipment record.') ?></p>
                        </div>

                        <div class="admin-action-stack">
                            <?= $this->Html->link(__('Edit Equipment'), ['action' => 'edit', $equipmentEntity->equipment_id], ['class' => 'admin-action-link']) ?>

                            <?= $this->Html->link(__('List Equipment'), ['action' => 'index'], ['class' => 'admin-action-link']) ?>

                            <?= $this->Html->link(__('New Equipment'), ['action' => 'add'], ['class' => 'admin-action-link']) ?>

                            <?= $this->Form->postLink(
                                __('Delete Equipment'),
                                ['action' => 'delete', $equipmentEntity->equipment_id],
                                [
                                    'confirm' => __('Are you sure you want to delete # {0}?', $equipmentEntity->equipment_id),
                                    'class' => 'admin-action-link admin-action-link-danger',
                                ]
                            ) ?>
                        </div>
                    </div>
                </div>

                <div class="col-lg-9">
                    <div class="admin-table-card">
                        <div class="admin-table-header">
                            <h2><?= __('Equipment Information') ?></h2>
                            <p><?= __('Detailed information for this equipment item.') ?></p>
                        </div>

                        <div class="table-responsive">
                            <table class="table admin-table">
                                <tbody>
                                <tr>
                                    <th><?= __('Name') ?></th>
                                    <td><?= h($equipmentEntity->name) ?></td>
                                </tr>
                                <tr>
                                    <th><?= __('Category') ?></th>
                                    <td><?= h($equipmentEntity->category) ?></td>
                                </tr>
                                <tr>
                                    <th><?= __('Storage Location') ?></th>
                                    <td><?= h($equipmentEntity->storage_location) ?></td>
                                </tr>
                                <tr>
                                    <th><?= __('Equipment ID') ?></th>
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
                                    <th><?= __('Active') ?></th>
                                    <td><?= $equipmentEntity->is_active ? __('Yes') : __('No') ?></td>
                                </tr>
                                </tbody>
                            </table>
                        </div>

                        <?php if (!empty($equipmentEntity->condition_notes)): ?>
                            <div class="admin-detail-section">
                                <h3><?= __('Condition Notes') ?></h3>
                                <div class="admin-notes-box">
                                    <?= $this->Text->autoParagraph(h($equipmentEntity->condition_notes)) ?>
                                </div>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
