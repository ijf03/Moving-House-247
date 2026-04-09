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

    <?= $this->Html->css(['normalize.min', 'milligram.min', 'fonts', 'cake', 'home']) ?>

    <?= $this->fetch('meta') ?>
    <?= $this->fetch('css') ?>
    <?= $this->fetch('script') ?>
</head>
<body>
    <div>
        <main class="landing-page">

            <section class="hero">
                <div class="hero-content">
                    <h1>Fast, reliable removals across Melbourne</h1>
                    <h2>Moving made simple, safe, and stress-free</h2>
                    <p>
                        From small apartment moves to full house relocations,
                        Moving House 24/7 helps you move with confidence. Get a
                        fast quote, choose a time that suits you, and let our
                        experienced team handle the heavy lifting.
                    </p>

                    <div class="hero-buttons">
                        <?= $this->Html->link('Book Your Move!', ['controller' => 'ContactForms', 'action' => 'add'], ['class' => 'btn']) ?>
                        <a class="btn" href="#">View Services</a>
                    </div>
                </div>
            </section>

            <section class="how-it-works">
                <h2>How It Works</h2>

                <div class="steps">
                    <div class="step-card">
                        <h3>1. Request a quote</h3>
                        <p>
                            Tell us where you’re moving from, where you’re going,
                            and your preferred date.
                        </p>
                    </div>

                    <div class="step-card">
                        <h3>2. Confirm your booking</h3>
                        <p>
                            We’ll provide a clear quote and help lock in a moving
                            time that suits you.
                        </p>
                    </div>

                    <div class="step-card">
                        <h3>3. Move with ease</h3>
                        <p>
                            Our team arrives ready to pack, lift, transport, and
                            deliver your items safely.
                        </p>
                    </div>
                </div>
            </section>
        </main>
    </div>
</body>
</html>
