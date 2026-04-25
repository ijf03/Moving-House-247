<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Booking $booking
 * @var \Cake\Collection\CollectionInterface|string[] $customers
 * @var \Cake\Collection\CollectionInterface|string[] $jobTypes
 */
?>

<div class="booking-page">
    <section class="booking-hero">
        <div class="container">
            <div class="booking-hero-shell">
                <div class="booking-hero-content">
                    <p class="booking-eyebrow">Moving House 24/7</p>
                    <h1>Book a Service</h1>
                    <p class="booking-hero-text">
                        Tell us the details of your move and we will get your booking into the system.
                    </p>
                </div>
            </div>
        </div>
    </section>

    <section class="booking-section">
        <div class="container">
            <div class="row g-4 align-items-start">
                <div class="col-lg-4">
                    <div class="booking-info-stack">
                        <div class="mh-info-card">
                            <div class="booking-info-icon">📦</div>
                            <div>
                                <h3>Simple Booking</h3>
                                <p>
                                    Fill in your service type, addresses, and preferred job schedule.
                                </p>
                            </div>
                        </div>

                        <div class="mh-info-card">
                            <div class="booking-info-icon">🚚</div>
                            <div>
                                <h3>Removal, Storage, or Transfer</h3>
                                <p>
                                    Choose the service that best fits your moving needs.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-8">
                    <div class="mh-form-card">
                        <div class="booking-form-header">
                            <h2>Booking Details</h2>
                            <p>Complete the form below to submit your booking request.</p>
                        </div>

                        <?= $this->Form->create($booking, ['class' => 'booking-form']) ?>

                        <div class="row g-3">
                            <div class="col-md-6">
                                <?=
                                $this->Form->control('job_type_id', [
                                    'type' => 'select',
                                    'label' => 'Service Type',
                                    'options' => $jobTypes,
                                    'class' => 'booking-input',
                                    'templates' => [
                                        'inputContainer' => '<div class="input booking-form-group {{type}}{{required}}">{{content}}</div>',
                                    ],
                                ])
                                ?>
                            </div>

                            <div class="col-md-6">
                                <?=
                                $this->Form->control('job_date', [
                                    'type' => 'date',
                                    'min' => date('Y-m-d'),
                                    'class' => 'booking-input',
                                    'templates' => [
                                        'inputContainer' => '<div class="input booking-form-group {{type}}{{required}}">{{content}}</div>',
                                    ],
                                ])
                                ?>
                            </div>

                            <div class="col-12">
                                <?=
                                $this->Form->control('pickup_address', [
                                    'class' => 'booking-input',
                                    'templates' => [
                                        'inputContainer' => '<div class="input booking-form-group {{type}}{{required}}">{{content}}</div>',
                                    ],
                                ])
                                ?>
                            </div>

                            <div class="col-12">
                                <?=
                                $this->Form->control('dropoff_address', [
                                    'class' => 'booking-input',
                                    'templates' => [
                                        'inputContainer' => '<div class="input booking-form-group {{type}}{{required}}">{{content}}</div>',
                                    ],
                                ])
                                ?>
                            </div>

                            <div class="col-md-6">
                                <?=
                                $this->Form->control('job_time', [
                                    'type' => 'time',
                                    'class' => 'booking-input',
                                    'templates' => [
                                        'inputContainer' => '<div class="input booking-form-group {{type}}{{required}}">{{content}}</div>',
                                    ],
                                ])
                                ?>
                            </div>

                            <div class="col-12">
                                <?= $this->Form->control('message', [
                                    'type' => 'textarea',
                                    'label' => 'Additional Message',
                                    'class' => 'booking-input',
                                    'templates' => [
                                        'inputContainer' => '<div class="input booking-form-group {{type}}{{required}}">{{content}}</div>',
                                    ],
                                ]) ?>
                            </div>
                        </div>

                        <div class="booking-form-actions">
                            <?= $this->Form->button(__('Submit Booking'), ['class' => 'booking-submit-btn']) ?>
                        </div>

                        <?= $this->Form->end() ?>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
