<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Booking $booking
 */
?>

<div class="mh-page-soft">
    <section class="admin-hero">
        <div class="container">
            <div class="admin-hero-shell">
                <div class="admin-hero-content">
                    <span class="admin-eyebrow"><?= __('Booking') ?></span>
                    <h1><?= __('Booking Details') ?></h1>
                    <p class="admin-hero-text">
                        <?= __('Review all details for this booking.') ?>
                    </p>
                </div>
            </div>
        </div>
    </section>

    <?php
$identity = $this->request->getAttribute('identity');
?>

    <section class="admin-section">
        <div class="container">
            <div class="row g-4 align-items-start">

                <div class="col-lg-3">
                    <div class="mh-back-btn m-1">
                        <?= $this->Html->link(__('← Back to List'), ['action' => 'index']) ?>
                    </div>
<!--                    <div class="admin-table-card">-->
<!--                        <div class="admin-table-header">-->
<!--                            <h2>--><?php //= __('Actions') ?><!--</h2>-->
<!--                        </div>-->
<!---->
<!--                        <div class="admin-action-stack">-->
<!--                            --><?php //= $this->Html->link(
//                                __('Edit Booking'),
//                                ['action' => 'edit', $booking->booking_id],
//                                ['class' => 'admin-action-link']
//                            ) ?>
<!--                            -->
<!--                        </div>-->
<!--                    </div>-->
                </div>

                <div class="col-lg-9">
                    <div class="admin-table-card">
                        <div class="admin-table-header">
                            <h2><?= __('Customer Details') ?></h2>
                            <p><?= __('Contact information for this booking') ?></p>
                        </div>

                        <div class="row g-3">
                            <div class="col-md-6">
                                <div class="mh-info-card">
                                    <div>
                                        <h3><?= __('First Name') ?></h3>
                                        <p><?= h($booking->customer->first_name ?? '') ?></p>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="mh-info-card">
                                    <div>
                                        <h3><?= __('Last Name') ?></h3>
                                        <p><?= h($booking->customer->last_name ?? '') ?></p>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="mh-info-card">
                                    <div>
                                        <h3><?= __('Email') ?></h3>
                                        <p><?= h($booking->customer->email ?? '') ?></p>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="mh-info-card">
                                    <div>
                                        <h3><?= __('Phone') ?></h3>
                                        <p><?= h($booking->customer->phone ?? '') ?></p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="admin-table-header" style="margin-top: 2rem;">
                            <h2><?= __('Booking #') . h($booking->booking_id) ?></h2>
                            <p><?= __('Summary of your move') ?></p>
                        </div>

                        <div class="row g-3">
                            <div class="col-md-6">
                                <div class="mh-info-card">
                                    <div>
                                        <h3><?= __('Service Type') ?></h3>
                                        <p><?= h($booking->job_type->job_type_name ?? '') ?></p>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="mh-info-card">
                                    <div>
                                        <h3><?= __('Status') ?></h3>
                                        <p>
                                            <span class="admin-status-badge admin-status-replied">
                                                <?= h($booking->status) ?>
                                            </span>
                                        </p>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="mh-info-card">
                                    <div>
                                        <h3><?= __('Pickup Address') ?></h3>
                                        <p><?= h($booking->pickup_address) ?></p>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="mh-info-card">
                                    <div>
                                        <h3><?= __('Dropoff Address') ?></h3>
                                        <p><?= h($booking->dropoff_address) ?></p>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="mh-info-card">
                                    <div>
                                        <h3><?= __('Date') ?></h3>
                                        <p><?= h($booking->job_date) ?></p>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="mh-info-card">
                                    <div>
                                        <h3><?= __('Time') ?></h3>
                                        <p><?= h($booking->job_time) ?></p>
                                    </div>
                                </div>
                            </div>
                        </div>


                        <?php if (!empty($booking->message)): ?>
                            <div class="admin-table-header" style="margin-top: 2rem;">
                                <h2><?= __('Customer Message') ?></h2>
                                <p><?= __('Additional notes submitted with the booking') ?></p>
                            </div>

                            <?php if (!empty($booking->notes)): ?>
                                <div class="col-12">
                                    <div class="mh-info-card">
                                        <div>
                                            <h3><?= __('Notes') ?></h3>
                                            <p><?= h($booking->notes) ?></p>
                                </div>
                                    <p><?= $this->Text->autoParagraph(h($booking->message)) ?></p>
                                </div>
                            </div>
                        <?php endif; ?>

                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>
</div>
