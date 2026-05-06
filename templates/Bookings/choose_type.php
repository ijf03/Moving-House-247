<?php
/**
 * @var \App\View\AppView $this
 * @var array $bookingTypes
 */
?>

<div class="booking-page">
    <section class="booking-hero">
        <div class="container">
            <div class="booking-hero-shell">
                <div class="booking-hero-content">
                    <p class="booking-eyebrow">Moving House 24/7</p>
                    <h1><?= __('Choose a Booking Type') ?></h1>
                    <p class="booking-hero-text">
                        <?= __('Select the type of service you need before completing the booking form.') ?>
                    </p>
                </div>
            </div>
        </div>
    </section>

    <section class="booking-section">
        <div class="container">
            <div class="row g-4">
                <?php foreach ($bookingTypes as $jobTypeId => $type): ?>
                    <div class="col-md-4">
                        <div class="mh-form-card h-100">
                            <div class="booking-form-header">
                                <h2><?= h($type['name']) ?></h2>
                                <p><?= h($type['description']) ?></p>
                            </div>

                            <div class="booking-form-actions">
                                <?= $this->Html->link(
                                    __('Continue'),
                                    ['action' => 'add', '?' => ['job_type_id' => $jobTypeId]],
                                    ['class' => 'booking-submit-btn']
                                ) ?>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>
</div>
