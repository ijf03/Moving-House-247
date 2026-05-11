<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Job $job
 * @var array $truckList
 */
?>

<h2>Allocate Job Resources</h2>

<p><strong>Job ID:</strong> <?= h($job->job_id) ?></p>
<p><strong>Description:</strong> <?= h($job->description) ?></p>
<p><strong>Pickup:</strong> <?= h($job->pickup_address) ?></p>
<p><strong>Dropoff:</strong> <?= h($job->dropoff_address) ?></p>
<p><strong>Date:</strong> <?= h($job->job_date) ?></p>
<p><strong>Time:</strong> <?= h($job->job_time) ?></p>

<?= $this->Form->create($job) ?>

<div class="number-input">
    <label>Number of Staff Required</label>
    <div>
        <button type="button" onclick="changeValue('staff_required', -1)">−</button>

        <input type="number"
               name="staff_required"
               id="staff_required"
               value="1"
               min="1"
               max="10"
               required>

        <button type="button" onclick="changeValue('staff_required', 1)">+</button>
    </div>
</div>

<div class="number-input">
    <label>Number of Trucks Required</label>
    <div>
        <button type="button" onclick="changeTruck(-1)">−</button>

        <input type="number"
               name="truck_required"
               id="truck-required"
               value="1"
               min="1"
               max="5"
               required>

        <button type="button" onclick="changeTruck(1)">+</button>
    </div>
</div>

<div id="truck-select-area"></div>

<?= $this->Form->button(__('Submit Allocation')) ?>
<?= $this->Form->end() ?>

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

    function renderTruckSelects(count) {
        const area = document.getElementById('truck-select-area');
        area.innerHTML = '';

        for (let i = 1; i <= count; i++) {
            const label = document.createElement('label');
            label.innerText = 'Select Truck ' + i;

            const select = document.createElement('select');
            select.name = 'truck_ids[]';
            select.required = true;

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

            area.appendChild(label);
            area.appendChild(select);
        }
    }

    document.addEventListener('DOMContentLoaded', function () {
        renderTruckSelects(1);
    });
</script>
