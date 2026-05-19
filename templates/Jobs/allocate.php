<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Job $job
 * @var array $truckList
 */
?>

<div class="mh-page-soft">
    <section class="admin-hero">
        <div class="container">
            <div class="admin-hero-shell">
                <div class="admin-hero-content">
                    <span class="admin-eyebrow"><?= __('Admin') ?></span>
                    <h1><?= __('Allocate Job Resources') ?></h1>
                    <p class="admin-hero-text">
                        <?= __('Set staff and truck requirements before making this job available to staff.') ?>
                    </p>
                </div>
            </div>
        </div>
    </section>

    <section class="admin-section">
        <div class="container">
            <div class="row g-4 align-items-start">
                <div class="col-lg-3">
                    <div class="mh-back-btn m-1">
                        <?= $this->Html->link(
                            __('← Back to List'),
                            ['action' => 'index'],
                        ) ?>
                    </div>
                    <div class="mh-form-card">
                        <div class="admin-table-header">
                            <h2><?= __('Actions') ?></h2>
                        </div>

                        <div class="admin-action-stack">

                            <?= $this->Html->link(
                                __('View Job'),
                                ['action' => 'view', $job->job_id],
                                ['class' => 'admin-action-link']
                            ) ?>

                            <?= $this->Form->postLink(
                                __('Delete Job'),
                                ['action' => 'delete', $job->job_id],
                                [
                                    'class' => 'admin-action-link admin-action-link-danger',
                                    'confirm' => __('Are you sure you want to delete job #{0}?', $job->job_id),
                                ]
                            ) ?>
                        </div>
                    </div>
                </div>

                <div class="col-lg-9">
                    <?= $this->Form->create($job, ['class' => 'mh-form']) ?>

                    <div class="admin-table-card">
                        <div class="admin-table-header">
                            <h2><?= __('Job Information') ?></h2>
                            <p><?= __('Overview of the selected moving job.') ?></p>
                        </div>

                        <div class="row g-3 mb-4">
                            <div class="col-md-6">
                                <div class="mh-info-card">
                                    <div>
                                        <h3><?= __('Customer') ?></h3>
                                        <p><?= h($job->customer->first_name . ' ' . $job->customer->last_name) ?></p>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="mh-info-card">
                                    <div>
                                        <h3><?= __('Job Type') ?></h3>
                                        <p>
                                            <?= $job->hasValue('job_type')
                                                ? h($job->job_type->job_type_name)
                                                : '' ?>
                                        </p>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="mh-info-card">
                                    <div>
                                        <h3><?= __('Pickup Address') ?></h3>
                                        <p><?= h($job->pickup_address) ?></p>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="mh-info-card">
                                    <div>
                                        <h3><?= __('Drop-off Address') ?></h3>
                                        <p><?= h($job->dropoff_address) ?></p>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="mh-info-card">
                                    <div>
                                        <h3><?= __('Job Date') ?></h3>
                                        <p><?= h($job->job_date?->format('d/m/Y')) ?></p>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="mh-info-card">
                                    <div>
                                        <h3><?= __('Job Time') ?></h3>
                                        <p><?= h($job->job_time ? date('H:i', strtotime($job->job_time)) : '')?></p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="admin-table-header">
                            <h2><?= __('Resource Requirements') ?></h2>
                            <p><?= __('Use the controls below to set required staff and trucks.') ?></p>
                        </div>

                        <div class="row g-3 mb-4">
                            <div class="col-md-4">
                                <div class="mh-info-card">
                                    <div class="w-100">
                                        <h3><?= __('Drivers Required') ?></h3>

                                        <div class="d-flex align-items-center gap-3 mt-3">
                                            <button type="button"
                                                    class="admin-action-link"
                                                    onclick="changeValue('driver_required', -1); syncTruckWithDriver();">
                                                −
                                            </button>

                                            <input type="number"
                                                   name="driver_required"
                                                   id="driver_required"
                                                   value="1"
                                                   min="1"
                                                   max="10"
                                                   required
                                                   class="form-control text-center"
                                                   style="max-width: 100px;">

                                            <button type="button"
                                                    class="admin-action-link"
                                                    onclick="changeValue('driver_required', 1); syncTruckWithDriver();">
                                                +
                                            </button>
                                        </div>

                                        <p class="text-muted mt-3 mb-0">
                                            <?= __('Each driver requires one truck.') ?>
                                        </p>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="mh-info-card">
                                    <div class="w-100">
                                        <h3><?= __('Trucks Required') ?></h3>

                                        <div class="d-flex align-items-center gap-3 mt-3">
                                            <input type="number"
                                                   name="truck_required"
                                                   id="truck-required"
                                                   value="1"
                                                   readonly
                                                   required
                                                   class="form-control text-center"
                                                   style="max-width: 100px;">
                                        </div>

                                        <p class="text-muted mt-3 mb-0">
                                            <?= __('Automatically matched to the number of drivers.') ?>
                                        </p>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="mh-info-card">
                                    <div class="w-100">
                                        <h3><?= __('Porters Required') ?></h3>

                                        <div class="d-flex align-items-center gap-3 mt-3">
                                            <button type="button"
                                                    class="admin-action-link"
                                                    onclick="changeValue('porter_required', -1)">
                                                −
                                            </button>

                                            <input type="number"
                                                   name="porter_required"
                                                   id="porter_required"
                                                   value="1"
                                                   min="0"
                                                   max="10"
                                                   required
                                                   class="form-control text-center"
                                                   style="max-width: 100px;">

                                            <button type="button"
                                                    class="admin-action-link"
                                                    onclick="changeValue('porter_required', 1)">
                                                +
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="admin-table-header mt-4">
                            <h2><?= __('Truck Selection') ?></h2>
                            <p><?= __('Choose the specific truck or trucks required for this job.') ?></p>
                        </div>

                        <div id="truck-select-area" class="row g-3"></div>

                        <div class="mt-4">
                            <?= $this->Form->button(__('Submit Allocation'), [
                                'class' => 'mh-btn-primary'
                            ]) ?>
                        </div>
                    </div>

                    <?= $this->Form->end() ?>
                </div>
            </div>
        </div>
    </section>
</div>

<script>
    const truckOptions = <?= json_encode($truckList) ?>;

    function changeValue(id, delta) {
        const input = document.getElementById(id);
        let value = parseInt(input.value) || 1;

        value += delta;

        if (value < parseInt(input.min)) {
            value = parseInt(input.min);
        }

        if (value > parseInt(input.max)) {
            value = parseInt(input.max);
        }

        input.value = value;
    }

    function syncTruckWithDriver() {
        const driverInput = document.getElementById('driver_required');
        const truckInput = document.getElementById('truck-required');

        const count = parseInt(driverInput.value) || 1;

        truckInput.value = count;
        renderTruckSelects(count);
    }

    function updateTruckOptions() {
        const selects = document.querySelectorAll('select[name="truck_ids[]"]');

        const selectedValues = Array.from(selects)
            .map(select => select.value)
            .filter(value => value !== '');

        selects.forEach(select => {
            const currentValue = select.value;
            select.innerHTML = '';

            const empty = document.createElement('option');
            empty.value = '';
            empty.textContent = 'Select truck';
            select.appendChild(empty);

            Object.keys(truckOptions).forEach(function (id) {
                if (selectedValues.includes(id) && id !== currentValue) {
                    return;
                }

                const option = document.createElement('option');
                option.value = id;
                option.textContent = truckOptions[id];

                if (id === currentValue) {
                    option.selected = true;
                }

                select.appendChild(option);
            });
        });
    }

    function renderTruckSelects(count) {
        const area = document.getElementById('truck-select-area');
        area.innerHTML = '';

        for (let i = 1; i <= count; i++) {
            const wrapper = document.createElement('div');
            wrapper.className = 'col-md-6';

            const card = document.createElement('div');
            card.className = 'mh-info-card';

            const inner = document.createElement('div');

            const label = document.createElement('h3');
            label.innerText = 'Select Truck ' + i;

            const select = document.createElement('select');
            select.name = 'truck_ids[]';
            select.required = true;
            select.className = 'form-select mt-2';
            select.addEventListener('change', updateTruckOptions);

            const empty = document.createElement('option');
            empty.value = '';
            empty.textContent = 'Select truck';
            select.appendChild(empty);

            Object.keys(truckOptions).forEach(function (id) {
                const option = document.createElement('option');
                option.value = id;
                option.textContent = truckOptions[id];
                select.appendChild(option);
            });

            inner.appendChild(label);
            inner.appendChild(select);
            card.appendChild(inner);
            wrapper.appendChild(card);
            area.appendChild(wrapper);
        }

        updateTruckOptions();
    }

    document.addEventListener('DOMContentLoaded', function () {
        syncTruckWithDriver();
    });
</script>
