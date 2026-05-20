<?php
/**
 * CakePHP(tm) : Rapid Development Framework (https://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 * @link      https://cakephp.org CakePHP(tm) Project
 * @since     0.10.0
 * @license   https://opensource.org/licenses/mit-license.php MIT License
 * @var \App\View\AppView $this
 */

$this->assign('title', 'Moving House 24/7');

?>
<!DOCTYPE html>
<html>
<head>
    <?= $this->Html->charset() ?>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>
        <?= $this->fetch('title') ?>
    </title>
    <?= $this->Html->meta('icon') ?>

    <div class="landing-page">
        <section class="hero">
            <div class="container-fluid hero-shell">
                <div class="row align-items-center g-5">
                    <div class="col-lg-7">
                        <div class="hero-content">
                            <div class="hero-badge">
                                <span class="hero-badge-icon">◷</span>
                                <span> <?= $this->ContentBlock->text('header-description-main'); ?></span>
                            </div>

                            <h1>
                                    <?= $this->ContentBlock->text('website-title-main'); ?>
                                    <br><span class="accent"> <?= $this->ContentBlock->text('website-title-main-coloured'); ?></span>
                            </h1>

                            <p>
                                <?= $this->ContentBlock->text('main-page-description'); ?>
                            </p>

                            <div class="hero-buttons">
                                <?= $this->Html->link(
                                    'Get a Quote',
                                    ['controller' => 'ContactForms', 'action' => 'add'],
                                    ['class' => 'btn-primary-custom']
                                ) ?>

                                <?= $this->Html->link(
                                    'View Services',
                                    '#services',
                                    ['class' => 'btn-outline-custom']
                                ) ?>
                            </div>

                            <div class="hero-features">
                                <span><?= $this->ContentBlock->text('first-additional-description-main'); ?></span>
                                <span> <?= $this->ContentBlock->text('second-additional-description-main'); ?></span>
                                <span> <?= $this->ContentBlock->text('third-additional-description-main'); ?></span>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-5">
                        <div class="hero-stats-panel">
                            <div class="hero-stat-card">
                                <span><?= $this->ContentBlock->text('hero-label-first'); ?></span>
                                <strong><?= $this->ContentBlock->text('hero-stat-first'); ?></strong>
                            </div>

                            <div class="hero-stat-card">
                                <span><?= $this->ContentBlock->text('hero-label-second'); ?></span>
                                <strong><?= $this->ContentBlock->text('hero-stat-second'); ?></strong>
                            </div>
                            <div class="hero-stat-card">
                                <span><?= $this->ContentBlock->text('hero-label-third'); ?></span>
                                <strong><?= $this->ContentBlock->text('hero-stat-third'); ?></strong>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section id="services" class="services">
            <div class="container-fluid services-shell">
                <h2> <?= $this->ContentBlock->text('services-title'); ?></h2>
                <p class="section-intro">
                    <?= $this->ContentBlock->text('services-subtitle'); ?>
                </p>

                <div class="services-grid">
                    <div class="service-card">
                        <span class="service-tag"><?= $this->ContentBlock->text('removal-tag'); ?></span>
                        <h3><?= $this->ContentBlock->text('removal-name'); ?></h3>
                        <p><?= $this->ContentBlock->text('removal-description'); ?></p>
                    </div>

                    <div class="service-card">
                        <span class="service-tag"><?= $this->ContentBlock->text('transport-tag'); ?></span>
                        <h3><?= $this->ContentBlock->text('transport-name'); ?></h3>
                        <p><?= $this->ContentBlock->text('transport-description'); ?></p>
                    </div>

                    <div class="service-card">
                        <span class="service-tag"><?= $this->ContentBlock->text('storage-tag'); ?></span>
                        <h3><?= $this->ContentBlock->text('storage-name'); ?></h3>
                        <p><?= $this->ContentBlock->text('storage-description'); ?></p>
                    </div>

                    <div class="service-card">
                        <span class="service-tag"><?= $this->ContentBlock->text('furniture-tag'); ?></span>
                        <h3><?= $this->ContentBlock->text('furniture-name'); ?></h3>
                        <p><?= $this->ContentBlock->text('furniture-description'); ?></p>
                    </div>
                </div>
            </div>
        </section>

        <section class="how-it-works">
            <div class="container-fluid how-shell">
                <p class="section-kicker"> <?= $this->ContentBlock->text('booking-tag');?></p>
                <h2><?= $this->ContentBlock->text('booking-title'); ?></h2>
                <p class="section-intro">
                    <?= $this->ContentBlock->text('booking-subtitle'); ?>
                </p>

                <div class="steps">
                    <div class="step-card">
                        <div class="step-top">
                            <div class="step-number">01</div>
                            <div class="step-line"></div>
                        </div>
                        <h3><?= $this->ContentBlock->text('first-booking-title-card'); ?></h3>
                        <p><?= $this->ContentBlock->text('first-booking-description-card'); ?> </p>
                    </div>

                    <div class="step-card">
                        <div class="step-top">
                            <div class="step-number">02</div>
                            <div class="step-line"></div>
                        </div>
                        <h3><?= $this->ContentBlock->text('second-booking-title-card'); ?></h3>
                        <p><?= $this->ContentBlock->text('second-booking-description-card'); ?> </p>
                    </div>

                    <div class="step-card">
                        <div class="step-top">
                            <div class="step-number">03</div>
                            <div class="step-line"></div>
                        </div>
                        <h3><?= $this->ContentBlock->text('third-booking-title-card'); ?></h3>
                        <p><?= $this->ContentBlock->text('third-booking-description-card'); ?> </p>
                    </div>
                </div>
            </div>
        </section>
    </div>
