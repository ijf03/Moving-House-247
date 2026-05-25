<?php
/**
 * @var \App\View\AppView $this
 * @var iterable<\App\Model\Entity\JobResource> $jobResources
 * @var \App\Model\Entity\Job|null $job
 */

$jobLabel = $job ? __('Job #{0}', $job->job_id) : __('Job Resources');

$customerName = '-';
$serviceType = '-';
$jobDate = '-';

if ($job) {
    if ($job->hasValue('customer')) {
        $customerName = trim(
            ($job->customer->first_name ?? '') . ' ' .
            ($job->customer->last_name ?? '')
        );

        if ($customerName === '') {
            $customerName = '-';
        }
    }

    if ($job->hasValue('job_type')) {
        $serviceType = $job->job_type->job_type_name ?? '-';
    }

    $jobDate = $job->job_date ?? '-';
}
?>

<div class="mh-page-soft">
    <section class="admin-hero">
        <div class="container">
            <div class="admin-hero-shell">
                <div class="admin-hero-content">
                    <span class="admin-eyebrow"><?= __('Resources') ?></span>
                    <h1><?= h($jobLabel) ?></h1>
                    <p class="admin-hero-text">
                        <?= __('View the detailed resource allocation for this job, including trucks, equipment, storage units, and inventory items.') ?>
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
                            <p><?= __('Manage resources for this job.') ?></p>
                        </div>

                        <div class="admin-action-stack">
                            <?= $this->Html->link(
                                __('List Job Resources'),
                                ['action' => 'index'],
                                ['class' => 'admin-action-link']
                            ) ?>

                            <?php if ($job): ?>
                                <?= $this->Html->link(
                                    __('View Job'),
                                    ['controller' => 'Jobs', 'action' => 'view', $job->job_id],
                                    ['class' => 'admin-action-link']
                                ) ?>

                                <?= $this->Html->link(
                                    __('Add Resource'),
                                    ['action' => 'add', '?' => ['job_id' => $job->job_id]],
                                    ['class' => 'admin-action-link']
                                ) ?>
                            <?php else: ?>
                                <?= $this->Html->link(
                                    __('New Job Resource'),
                                    ['action' => 'add'],
                                    ['class' => 'admin-action-link']
                                ) ?>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>

                <div class="col-lg-9">
                    <div class="admin-table-card">
                        <div class="admin-table-header">
                            <div>
                                <h2><?= __('Job Resource Details') ?></h2>
                                <p>
                                    <?= __('Customer: {0} | Service: {1} | Date: {2}', $customerName, $serviceType, $jobDate) ?>
                                </p>
                            </div>
                        </div>

                        <div class="admin-table-wrap">
                            <table class="admin-table">
                                <thead>
                                <tr>
                                    <th><?= __('No.') ?></th>
                                    <th><?= __('Resource Type') ?></th>
                                    <th><?= __('Resource') ?></th>
                                    <th><?= __('Quantity') ?></th>
                                    <th class="actions"><?= __('Actions') ?></th>
                                </tr>
                                </thead>

                                <tbody>
                                <?php if (empty($jobResources)): ?>
                                    <tr>
                                        <td colspan="5" style="text-align: center; color: gray;">
                                            <?= __('No resources have been assigned to this job.') ?>
                                        </td>
                                    </tr>
                                <?php endif; ?>

                                <?php foreach ($jobResources as $index => $jobResource): ?>
                                    <?php
                                    $resourceNumber = $index + 1;
                                    $resourceType = __('Unknown');
                                    $resourceName = '-';

                                    if (!empty($jobResource->truck_id)) {
                                        $resourceType = __('Truck');

                                        if ($jobResource->hasValue('truck')) {
                                            $truckRego = $jobResource->truck->rego ?? '';
                                            $resourceName = trim($truckRego, ' -');

                                            if ($resourceName === '') {
                                                $resourceName = __('Truck ID #{0}', $jobResource->truck_id);
                                            }
                                        } else {
                                            $resourceName = __('Truck ID #{0}', $jobResource->truck_id);
                                        }
                                    } elseif (!empty($jobResource->equipment_id)) {
                                        $resourceType = __('Equipment');

                                        if ($jobResource->hasValue('equipment')) {
                                            $resourceName = $jobResource->equipment->name
                                                ?? __('Equipment ID #{0}', $jobResource->equipment_id);
                                        } else {
                                            $resourceName = __('Equipment ID #{0}', $jobResource->equipment_id);
                                        }
                                    } elseif (!empty($jobResource->storage_unit_id)) {
                                        $resourceType = __('Storage Unit');

                                        if ($jobResource->hasValue('storage_unit')) {
                                            $unitCode = $jobResource->storage_unit->unit_code ?? '';
                                            $facilityName = $jobResource->storage_unit->facility_name ?? '';
                                            $resourceName = trim($unitCode . ' - ' . $facilityName, ' -');

                                            if ($resourceName === '') {
                                                $resourceName = __('Storage Unit ID #{0}', $jobResource->storage_unit_id);
                                            }
                                        } else {
                                            $resourceName = __('Storage Unit ID #{0}', $jobResource->storage_unit_id);
                                        }
                                    } elseif (!empty($jobResource->inventory_id)) {
                                        $resourceType = __('Inventory Item');

                                        if ($jobResource->hasValue('inventory_item')) {
                                            $resourceName = $jobResource->inventory_item->name
                                                ?? __('Inventory Item ID #{0}', $jobResource->inventory_id);
                                        } else {
                                            $resourceName = __('Inventory Item ID #{0}', $jobResource->inventory_id);
                                        }
                                    }
                                    ?>

                                    <tr>
                                        <td><?= h($resourceNumber) ?></td>

                                        <td>
                                                <span class="admin-status-badge">
                                                    <?= h($resourceType) ?>
                                                </span>
                                        </td>

                                        <td><?= h($resourceName) ?></td>

                                        <td><?= $this->Number->format($jobResource->quantity) ?></td>

                                        <td class="actions">
                                            <div class="admin-action-stack">
                                                <?= $this->Html->link(
                                                    __('Edit'),
                                                    ['action' => 'edit', $jobResource->job_resource_id],
                                                    ['class' => 'admin-action-link']
                                                ) ?>

                                                <?= $this->Form->postLink(
                                                    __('Delete'),
                                                    ['action' => 'delete', $jobResource->job_resource_id],
                                                    [
                                                        'method' => 'delete',
                                                        'confirm' => __('Are you sure you want to delete # {0}?', $jobResource->job_resource_id),
                                                        'class' => 'admin-action-link admin-action-link-danger',
                                                    ]
                                                ) ?>
                                            </div>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
