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
                                Moves done right,<br>
                                <span class="accent">any time of day.</span>
                            </h1>

                            <p>
                                Trusted local removals and storage solutions. Get a fast online quote
                                and book your move in minutes. No hold music, no guesswork.
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
                                <span>On-time arrival</span>
                                <strong>98%</strong>
                            </div>

                            <div class="hero-stat-card">
                                <span>5-star reviews</span>
                                <strong>4.9/5</strong>
                            </div>

                            <div class="hero-stat-card">
                                <span>Moves completed</span>
                                <strong>10,000+</strong>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section id="services" class="services">
            <div class="container-fluid services-shell">
                <h2>Our Services</h2>
                <p class="section-intro">
                    Whatever your move looks like, we have a solution to fit.
                </p>

                <div class="services-grid">
                    <div class="service-card">
                        <span class="service-tag">Removals</span>
                        <h3>Relocation</h3>
                        <p>Full-service home and apartment moves, planned and executed by trained crews.</p>
                    </div>

                    <div class="service-card">
                        <span class="service-tag">Transport</span>
                        <h3>Moving Your Belongings</h3>
                        <p>Careful handling of your possessions from packing to delivery, every step covered.</p>
                    </div>

                    <div class="service-card">
                        <span class="service-tag">Storage</span>
                        <h3>Storage Solutions</h3>
                        <p>Short and long-term secure storage when you need extra time between properties.</p>
                    </div>

                    <div class="service-card">
                        <span class="service-tag">Furniture</span>
                        <h3>Furniture &amp; Item Removal</h3>
                        <p>Single items, large furniture, or full clear-outs, we handle the heavy lifting.</p>
                    </div>
                </div>
            </div>
        </section>

        <section class="how-it-works">
            <div class="container-fluid how-shell">
                <p class="section-kicker">HOW IT WORKS</p>
                <h2>Booking is simple</h2>
                <p class="section-intro">
                    Three straightforward steps from quote to move-in day.
                </p>

                <div class="steps">
                    <div class="step-card">
                        <div class="step-top">
                            <div class="step-number">01</div>
                            <div class="step-line"></div>
                        </div>
                        <h3>Request a quote</h3>
                        <p>Tell us about your move with our quick online form. No phone calls needed.</p>
                    </div>

                    <div class="step-card">
                        <div class="step-top">
                            <div class="step-number">02</div>
                            <div class="step-line"></div>
                        </div>
                        <h3>Confirm your booking</h3>
                        <p>We confirm date, time, crew size and pricing all in writing, no surprises.</p>
                    </div>

                    <div class="step-card">
                        <div class="step-top">
                            <div class="step-number">03</div>
                            <div class="step-line"></div>
                        </div>
                        <h3>Move with ease</h3>
                        <p>Our team arrives on time, handles the work, and gets you settled in stress-free.</p>
                    </div>
                </div>
            </div>
        </section>
    </div>
