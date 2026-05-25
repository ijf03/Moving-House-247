<?php
/**
 * @var \App\View\AppView $this
 * @var iterable<\App\Model\Entity\JobResource> $jobResources
 */

$groupedJobResources = [];

foreach ($jobResources as $jobResource) {
    $jobId = $jobResource->job_id ?? 'Unassigned';

    if (!isset($groupedJobResources[$jobId])) {
        $groupedJobResources[$jobId] = [
            'job' => $jobResource->job ?? null,
            'resources' => [],
            'truck_count' => 0,
            'equipment_count' => 0,
            'storage_unit_count' => 0,
            'inventory_count' => 0,
            'total_resources' => 0,
        ];
    }

    $groupedJobResources[$jobId]['resources'][] = $jobResource;
    $groupedJobResources[$jobId]['total_resources']++;

    if (!empty($jobResource->truck_id)) {
        $groupedJobResources[$jobId]['truck_count']++;
    }

    if (!empty($jobResource->equipment_id)) {
        $groupedJobResources[$jobId]['equipment_count']++;
    }

    if (!empty($jobResource->storage_unit_id)) {
        $groupedJobResources[$jobId]['storage_unit_count']++;
    }

    if (!empty($jobResource->inventory_id)) {
        $groupedJobResources[$jobId]['inventory_count']++;
    }
}
?>

<div class="mh-page-soft">
    <section class="admin-hero">
        <div class="container">
            <div class="admin-hero-shell">
                <div class="admin-hero-content">
                    <p class="admin-eyebrow"><?= __('Resources') ?></p>
                    <h1><?= __('Job Resources') ?></h1>
                    <p class="admin-hero-text">
                        <?= __('Review resource allocations grouped by job, including trucks, equipment, storage units, and inventory items.') ?>
                    </p>
                </div>
            </div>
        </div>
    </section>

    <section class="admin-section">
        <div class="container">
            <div class="admin-table-card">
                <div class="admin-table-header">
                    <div>
                        <h2><?= __('Resource Allocation Summary') ?></h2>
                        <p><?= __('Each row shows the resources currently assigned to a job.') ?></p>
                    </div>

<!--                    --><?php //= $this->Html->link(
//                        __('New Job Resource'),
//                        ['action' => 'add'],
//                        ['class' => 'admin-primary-link']
//                    ) ?>
                </div>

                <div class="admin-filter-card">
                    <?= $this->Form->create(null, ['type' => 'get', 'class' => 'admin-filter-form mh-form']) ?>
                    <div class="row g-3">
                        <div class="col-md-6">
                            <?= $this->Form->control('search', [
                                'label' => 'Search',
                                'placeholder' => 'Job, customer, service type, resource name...',
                                'value' => $search ?? '',
                            ]) ?>
                        </div>

                        <div class="col-md-6">
                            <?= $this->Form->control('resource_type', [
                                'type' => 'select',
                                'label' => 'Resource Type',
                                'empty' => 'All Resource Types',
                                'options' => [
                                    'truck' => 'Truck',
                                    'equipment' => 'Equipment',
                                    'storage_unit' => 'Storage Unit',
                                    'inventory' => 'Inventory Item',
                                ],
                                'default' => $resourceType ?? null,
                            ]) ?>
                        </div>
                    </div>

                    <div class="admin-filter-actions">
                        <?= $this->Form->button(__('Apply Filters'), ['class' => 'admin-primary-link admin-primary-button']) ?>
                        <?= $this->Html->link(__('Reset'), ['action' => 'index'], ['class' => 'admin-action-link']) ?>
                    </div>
                    <?= $this->Form->end() ?>
                </div>

                <div class="admin-table-wrap">
                    <table class="admin-table">
                        <thead>
                        <tr>
                            <th><?= $this->Paginator->sort('job_id', 'Job') ?></th>
                            <th><?= $this->Paginator->sort('Customers.first_name', 'Customer') ?></th>
                            <th><?= $this->Paginator->sort('JobTypes.job_type_name', 'Service Type') ?></th>
                            <th><?= $this->Paginator->sort('Jobs.job_date', 'Job Date') ?></th>
                            <th><?= __('Trucks') ?></th>
                            <th><?= __('Equipment') ?></th>
                            <th><?= __('Storage Units') ?></th>
                            <th><?= __('Inventory Items') ?></th>
                            <th class="actions"><?= __('Actions') ?></th>
                        </tr>
                        </thead>

                        <tbody>
                        <?php if (empty($groupedJobResources)): ?>
                            <tr>
                                <td colspan="10" style="text-align: center; color: gray;">
                                    <?= __('No job resources found.') ?>
                                </td>
                            </tr>
                        <?php endif; ?>

                        <?php foreach ($groupedJobResources as $jobId => $group): ?>
                            <?php
                            $job = $group['job'];

                            $jobLabel = __('Job #{0}', $jobId);
                            $customerName = '-';
                            $serviceType = '-';
                            $jobDate = '-';

                            if ($job) {
                                $jobLabel = __('Job #{0}', $job->job_id);

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

                            <tr>
                                <td>
                                    <?php if ($job): ?>
                                        <?= $this->Html->link(
                                            $jobLabel,
                                            ['controller' => 'Jobs', 'action' => 'view', $job->job_id],
                                            ['class' => 'admin-action-link']
                                        ) ?>
                                    <?php else: ?>
                                        <?= h($jobLabel) ?>
                                    <?php endif; ?>
                                </td>

                                <td><?= h($customerName) ?></td>
                                <td><?= h($serviceType) ?></td>
                                <td><?= h($jobDate?->format('d/m/Y')) ?></td>

                                <td>
                                        <span class="admin-status-badge">
                                            <?= h($group['truck_count']) ?>
                                        </span>
                                </td>

                                <td>
                                        <span class="admin-status-badge">
                                            <?= h($group['equipment_count']) ?>
                                        </span>
                                </td>

                                <td>
                                        <span class="admin-status-badge">
                                            <?= h($group['storage_unit_count']) ?>
                                        </span>
                                </td>

                                <td>
                                        <span class="admin-status-badge">
                                            <?= h($group['inventory_count']) ?>
                                        </span>
                                </td>

                                <td class="actions">
                                    <div class="admin-action-stack">
                                        <?= $this->Html->link(
                                            __('View Resources'),
                                            ['action' => 'view', $jobId],
                                            ['class' => 'admin-action-link']
                                        ) ?>

                                        <?= $this->Html->link(
                                            __('Add Resource'),
                                            ['action' => 'add', $jobId],
                                            ['class' => 'admin-action-link']
                                        ) ?>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>

                <div class="admin-paginator">
                    <ul class="pagination">
                        <?= $this->Paginator->first('<< ' . __('first')) ?>
                        <?= $this->Paginator->prev('< ' . __('previous')) ?>
                        <?= $this->Paginator->numbers() ?>
                        <?= $this->Paginator->next(__('next') . ' >') ?>
                        <?= $this->Paginator->last(__('last') . ' >>') ?>
                    </ul>

                    <p>
                        <?= $this->Paginator->counter(
                            __('Page {{page}} of {{pages}}, showing {{current}} record(s) out of {{count}} total')
                        ) ?>
                    </p>
                </div>
            </div>
        </div>
    </section>
</div>
