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
                                <span>Available 24/7 across Victoria</span>
                            </div>

                            <h1>
                                <h1>
                                    <?= $this->ContentBlock->html('website-title-main'); ?>
                                </h1>
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
                                <span>🛡 Fully insured</span>
                                <span>⭐ Trained crews</span>
                                <span>◷ 24/7 availability</span>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-5">
                        <div class="hero-stats-panel">
                            <div class="hero-stat-card">
                                <?= $this->ContentBlock->html('hero-stat-ontime'); ?>

                            </div>

                            <div class="hero-stat-card">
                                <?= $this->ContentBlock->html('hero-stat-reviews'); ?>
                            </div>

                            <div class="hero-stat-card">
                                <?= $this->ContentBlock->html('hero-stat-moves'); ?>

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
                        <?= $this->ContentBlock->html('removal'); ?>
                    </div>

                    <div class="service-card">
                        <?= $this->ContentBlock->html('transport'); ?>
                    </div>

                    <div class="service-card">
                        <?= $this->ContentBlock->html('storage'); ?>
                    </div>

                    <div class="service-card">
                        <?= $this->ContentBlock->html('furniture'); ?>
                    </div>
                </div>
            </div>
        </section>

        <section class="how-it-works">
            <div class="container-fluid how-shell">
                <p class="section-kicker">HOW IT WORKS</p>
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
                        <?= $this->ContentBlock->html('first-booking-card'); ?>
                    </div>

                    <div class="step-card">
                        <div class="step-top">
                            <div class="step-number">02</div>
                            <div class="step-line"></div>
                        </div>
                        <?= $this->ContentBlock->html('second-booking-card'); ?>
                    </div>

                    <div class="step-card">
                        <div class="step-top">
                            <div class="step-number">03</div>
                            <div class="step-line"></div>
                        </div>
                        <?= $this->ContentBlock->html('third-booking-card'); ?>

                    </div>
                </div>
            </div>
        </section>
    </div>
