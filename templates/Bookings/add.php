<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Booking $booking
 */
?>
<div class="bookings form content">
    <?= $this->Form->create($booking) ?>
    <fieldset>
        <legend><?= __('Book a Service') ?></legend>
        <?php
        echo $this->Form->control('job_type_id', [
            'type' => 'select',
            'label' => 'Service Type',
            'options' => [
                1 => 'Removal',
                2 => 'Storage',
            ],
        ]);

        echo $this->Form->control('pickup_address');
        echo $this->Form->control('dropoff_address');
        echo $this->Form->control('job_date', ['type' => 'date']);
        echo $this->Form->control('job_time', ['type' => 'time']);
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit Booking')) ?>
    <?= $this->Form->end() ?>
</div>
