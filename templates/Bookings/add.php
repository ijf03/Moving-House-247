<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Booking $booking
 * @var \Cake\Collection\CollectionInterface|string[] $customers
 * @var \Cake\Collection\CollectionInterface|string[] $jobTypes
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('List Bookings'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column column-80">
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
    </div>
</div>
