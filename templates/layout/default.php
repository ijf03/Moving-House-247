<?php
/**
 * CakePHP(tm) : Rapid Development Framework (https://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 * @link          https://cakephp.org CakePHP(tm) Project
 * @since         0.10.0
 * @license       https://opensource.org/licenses/mit-license.php MIT License
 * @var \App\View\AppView $this
 */
$identity = $this->request->getAttribute('identity');
$role = $identity ? $identity->get('user_type') : null;
$isAdmin = ($identity && (int)$role === 1);
$isUser = ($identity && (int)$role === 3);
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

    <?= $this->Html->css('https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css') ?>
    <?= $this->Html->css(['normalize.min', 'milligram.min', 'cake', 'fonts', 'site', 'home']) ?>

    <?= $this->fetch('meta') ?>
    <?= $this->fetch('css') ?>
</head>
<body class="mh-site">

<header class="mh-header sticky-top">
    <nav class="navbar navbar-expand-lg mh-navbar">
        <div class="container-fluid px-3 px-lg-5">
            <a class="navbar-brand mh-brand" href="<?= $this->Url->build('/') ?>">
                <span class="mh-brand-icon">🚚</span>
                <span class="mh-brand-text">
                    Moving House <span class="mh-accent">24/7</span>
                </span>
            </a>

            <button class="navbar-toggler mh-toggler" type="button" data-bs-toggle="collapse"
                    data-bs-target="#mainNavbar" aria-controls="mainNavbar" aria-expanded="false"
                    aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="mainNavbar">
                <div class="navbar-nav ms-auto align-items-lg-center gap-lg-2">

                    <?= $this->Html->link(
                        'Home',
                        ['controller' => 'Pages', 'action' => 'display', 'home'],
                        ['class' => 'nav-link mh-nav-link'],
                    ) ?>

                    <?php if ($isAdmin) : ?>
                        <?= $this->Html->link(
                            'Users',
                            ['controller' => 'Users', 'action' => 'index'],
                            ['class' => 'nav-link mh-nav-link'],
                        ) ?>

                        <?= $this->Html->link(
                            'Contact Forms',
                            ['controller' => 'ContactForms', 'action' => 'index'],
                            ['class' => 'nav-link mh-nav-link'],
                        ) ?>

                        <?= $this->Html->link(
                            'Manage Bookings',
                            ['controller' => 'Bookings', 'action' => 'index'],
                            ['class' => 'nav-link mh-nav-link'],
                        ) ?>

                        <?= $this->Html->link(
                            'Manage Invoices',
                            ['controller' => 'Invoices', 'action' => 'index'],
                            ['class' => 'nav-link mh-nav-link'],
                        ) ?>

                    <?php elseif ($isUser) : ?>
                        <?= $this->Html->link(
                            'Book a Service',
                            ['controller' => 'Bookings', 'action' => 'add'],
                            ['class' => 'nav-link mh-nav-link'],
                        ) ?>

                        <?= $this->Html->link(
                            'Contact Us',
                            ['controller' => 'ContactForms', 'action' => 'add'],
                            ['class' => 'nav-link mh-nav-link'],
                        ) ?>

                        <?= $this->Html->link(
                            'My Bookings',
                            ['controller' => 'Bookings', 'action' => 'myBookings'],
                            ['class' => 'nav-link mh-nav-link'],
                        ) ?>

                    <?php else : ?>
                        <?= $this->Html->link(
                            'Services',
                            ['controller' => 'Pages', 'action' => 'display', 'home', '#' => 'services'],
                            ['class' => 'nav-link mh-nav-link'],
                        ) ?>

                        <?= $this->Html->link(
                            'Contact Us',
                            ['controller' => 'ContactForms', 'action' => 'add'],
                            ['class' => 'nav-link mh-nav-link'],
                        ) ?>

                        <?= $this->Html->link(
                            'Book a Service',
                            ['controller' => 'Bookings', 'action' => 'add'],
                            ['class' => 'nav-link mh-nav-link'],
                        ) ?>

                    <?php endif; ?>

                    <?php if ($identity) : ?>
                        <?= $this->Html->link(
                            'Log Out',
                            ['controller' => 'Users', 'action' => 'logout'],
                            ['class' => 'nav-link mh-nav-link'],
                        ) ?>

                    <?php else : ?>
                        <?= $this->Html->link(
                            'Log In',
                            ['controller' => 'Users', 'action' => 'login'],
                            ['class' => 'btn mh-quote-btn ms-lg-3 mt-3 mt-lg-0'],
                        ) ?>

                    <?php endif; ?>

                </div>
            </div>
        </div>
    </nav>
</header>

<main class="mh-main">
    <?= $this->Flash->render() ?>
    <?= $this->fetch('content') ?>
</main>

<footer class="mh-footer">
    <div class="mh-footer-cta">
        <div class="container-fluid px-4 px-lg-5">
            <div class="row align-items-center gy-4">
                <div class="col-lg-8">
                    <h2 class="mh-footer-title">Get your free quote today</h2>
                    <p class="mh-footer-subtitle mb-0">Most quotes returned within the same day.</p>
                </div>
                <div class="col-lg-4 text-lg-end">
                    <?= $this->Html->link(
                        'Start Your Quote →',
                        ['controller' => 'ContactForms', 'action' => 'add'],
                        ['class' => 'btn mh-footer-cta-btn'],
                    ) ?>
                </div>
            </div>
        </div>
    </div>

    <div class="mh-footer-main">
        <div class="container-fluid px-4 px-lg-5">
            <div class="row gy-5">
                <div class="col-lg-4">
                    <div class="d-flex align-items-center gap-3 mb-3">
                        <span class="mh-footer-icon">🚚</span>
                        <h3 class="mh-footer-brand mb-0">Moving House 24/7</h3>
                    </div>
                    <p class="mh-footer-text mb-0">
                        Reliable removals &amp; storage across Victoria, any time of day.
                    </p>
                </div>

                <div class="col-6 col-lg-2">
                    <h4 class="mh-footer-heading">Company</h4>
                    <ul class="list-unstyled mh-footer-links mb-0">
                        <li><?= $this->Html->link(
                            'Home',
                            ['controller' => 'Pages', 'action' => 'display', 'home'],
                        ) ?></li>
                        <li><?= $this->Html->link(
                            'Services',
                            ['controller' => 'Pages', 'action' => 'display', 'home', '#' => 'services'],
                        ) ?></li>
                        <li><?= $this->Html->link(
                            'Contact',
                            ['controller' => 'ContactForms', 'action' => 'add'],
                        ) ?></li>
                        <li><?= $this->Html->link(
                            'Get a Quote',
                            ['controller' => 'ContactForms', 'action' => 'add'],
                        ) ?></li>
                    </ul>
                </div>

                <div class="col-6 col-lg-3">
                    <h4 class="mh-footer-heading">Contact</h4>
                    <ul class="list-unstyled mh-footer-contact mb-0">
                        <li>
                            <?= $this->Html->link(
                                '0412 345 678',
                                'tel:0412345678',
                            ) ?>
                        </li>
                        <li>
                            <?= $this->Html->link(
                                'hello@movinghouse247.com.au',
                                'mailto:hello@movinghouse247.com.au',
                                ['target' => '_blank'],
                            ) ?>
                        </li>
                        <li>Victoria, Australia</li>
                    </ul>
                </div>

                <div class="col-lg-3">
                    <h4 class="mh-footer-heading">Trust</h4>
                    <p class="mh-footer-text mb-0">
                        Fully insured, professionally trained crews. Transparent quotes, no hidden fees.
                    </p>
                </div>
            </div>
        </div>
    </div>

    <div class="mh-footer-bottom text-center">
        <div class="container-fluid px-4 px-lg-5">
            <small>&copy; <?= date('Y') ?> Moving House 24/7. All rights reserved.</small>
        </div>
    </div>
</footer>

<?= $this->Html->script('https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js') ?>
<?= $this->fetch('script') ?>
</body>
</html>
