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

<main class="landing-page">
    <section class="hero py-5">
        <div class="container">
            <div class="hero-content text-center">
                <h1 class="display-4 fw-bold">Fast, reliable removals across Melbourne</h1>
                <h2 class="h4 mb-3">Moving made simple, safe, and stress-free</h2>
                <p class="lead mx-auto" style="max-width: 750px;">
                    From small apartment moves to full house relocations,
                    Moving House 24/7 helps you move with confidence. Get a
                    fast quote, choose a time that suits you, and let our
                    experienced team handle the heavy lifting.
                </p>

                <div class="hero-buttons d-flex justify-content-center gap-3 flex-wrap mt-4">
                    <?= $this->Html->link(
                        'Book Your Move!',
                        ['controller' => 'ContactForms', 'action' => 'add'],
                        ['class' => 'btn btn-primary btn-lg']
                    ) ?>
                    <a class="btn btn-outline-secondary btn-lg" href="#">View Services</a>
                </div>
            </div>
        </div>
    </section>

            <section id="services" class="services">
                <h2>Our Services</h2>
                <p class="section-intro">
                    Everything you need for a smooth and stress-free move.
                </p>

                <div class="services-grid">

                    <div class="service-card">
                        <span class="service-tag">Relocation</span>
                        <h3>Relocating</h3>
                        <p>
                            End-to-end relocation support to help you move from one
                            home to another with minimal stress.
                        </p>
                    </div>

                    <div class="service-card">
                        <span class="service-tag">Transport</span>
                        <h3>Moving Your Belongings</h3>
                        <p>
                            Safe and reliable transport for furniture, boxes,
                            and valuable items across Melbourne.
                        </p>
                    </div>

                    <div class="service-card">
                        <span class="service-tag">Storage</span>
                        <h3>Storage Solutions</h3>
                        <p>
                            Secure short-term and long-term storage when your
                            moving timeline does not align.
                        </p>
                    </div>

                    <div class="service-card">
                        <span class="service-tag">Removal</span>
                        <h3>Furniture & Item Removal</h3>
                        <p>
                            We help remove unwanted furniture and items,
                            making it easier to declutter before or after a move.
                        </p>
                    </div>

                </div>
            </section>

    <section class="how-it-works py-5 bg-light">
        <div class="container">
            <h2 class="text-center mb-5">How It Works</h2>

            <div class="row g-4">
                <div class="col-md-4">
                    <div class="card h-100 shadow-sm">
                        <div class="card-body">
                            <h3 class="h5 card-title">1. Request a quote</h3>
                            <p class="card-text">
                                Tell us where you’re moving from, where you’re going,
                                and your preferred date.
                            </p>
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="card h-100 shadow-sm">
                        <div class="card-body">
                            <h3 class="h5 card-title">2. Confirm your booking</h3>
                            <p class="card-text">
                                We’ll provide a clear quote and help lock in a moving
                                time that suits you.
                            </p>
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="card h-100 shadow-sm">
                        <div class="card-body">
                            <h3 class="h5 card-title">3. Move with ease</h3>
                            <p class="card-text">
                                Our team arrives ready to pack, lift, transport, and
                                deliver your items safely.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>
