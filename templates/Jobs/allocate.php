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
                        <?= $this->Html->link(__('← Back to Jobs'), ['action' => 'index']) ?>
                    </div>

                </div>

                <div class="col-lg-9">
                    <?= $this->Form->create($job) ?>

                    <div class="admin-table-card">
                        <div class="admin-table-header">
                            <h2><?= __('Job #') . h($job->job_id) ?></h2>
                            <p><?= h($job->description) ?></p>
                        </div>

                        <div class="row g-3">
                            <div class="col-md-6">
                                <div class="mh-info-card">
                                    <div>
                                        <h3><?= __('Pickup') ?></h3>
                                        <p><?= h($job->pickup_address) ?></p>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="mh-info-card">
                                    <div>
                                        <h3><?= __('Dropoff') ?></h3>
                                        <p><?= h($job->dropoff_address) ?></p>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="mh-info-card">
                                    <div>
                                        <h3><?= __('Date') ?></h3>
                                        <p><?= h($job->job_date) ?></p>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="mh-info-card">
                                    <div>
                                        <h3><?= __('Time') ?></h3>
                                        <p><?= h($job->job_time) ?></p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="admin-table-header" style="margin-top: 2rem;">
                            <h2><?= __('Resource Requirements') ?></h2>
                            <p><?= __('Use the controls below to set required staff and trucks.') ?></p>
                        </div>

                        <div class="row g-3">
                            <div class="col-md-6">
                                <div class="mh-info-card">
                                    <div>
                                        <h3><?= __('Number of Staff Required') ?></h3>
                                        <div class="d-flex align-items-center gap-3 mt-2">
                                            <button type="button" class="btn btn-outline-secondary" onclick="changeValue('staff_required', -1)">−</button>

                                            <input type="number"
                                                   name="staff_required"
                                                   id="staff_required"
                                                   value="1"
                                                   min="1"
                                                   max="10"
                                                   required
                                                   class="form-control text-center"
                                                   style="max-width: 100px;">

                                            <button type="button" class="btn btn-outline-secondary" onclick="changeValue('staff_required', 1)">+</button>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="mh-info-card">
                                    <div>
                                        <h3><?= __('Number of Trucks Required') ?></h3>
                                        <div class="d-flex align-items-center gap-3 mt-2">
                                            <button type="button" class="btn btn-outline-secondary" onclick="changeTruck(-1)">−</button>

                                            <input type="number"
                                                   name="truck_required"
                                                   id="truck-required"
                                                   value="1"
                                                   min="1"
                                                   max="5"
                                                   required
                                                   class="form-control text-center"
                                                   style="max-width: 100px;">

                                            <button type="button" class="btn btn-outline-secondary" onclick="changeTruck(1)">+</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="admin-table-header" style="margin-top: 2rem;">
                            <h2><?= __('Truck Selection') ?></h2>
                            <p><?= __('Choose the specific truck or trucks required for this job.') ?></p>
                        </div>

                        <div id="truck-select-area" class="row g-3"></div>

                        <div class="mt-4 text-center">
                            <?= $this->Form->button(__('Submit Allocation'), [
                                'class' => 'admin-action-link admin-action-link-success px-5 py-3 fs-4'
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
    function changeValue(id, delta) {
        const input = document.getElementById(id);
        let value = parseInt(input.value) || 1;

        value += delta;

        if (value < parseInt(input.min)) value = parseInt(input.min);
        if (value > parseInt(input.max)) value = parseInt(input.max);

        input.value = value;
    }

    const truckOptions = <?= json_encode($truckList) ?>;

    function changeTruck(delta) {
        const input = document.getElementById('truck-required');
        let value = parseInt(input.value) || 1;

        value += delta;

        if (value < 1) value = 1;
        if (value > 5) value = 5;

        input.value = value;
        renderTruckSelects(value);
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
                if (selectedValues.includes(id) && id !== currentValue) return;

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
        renderTruckSelects(1);
    });
</script>
