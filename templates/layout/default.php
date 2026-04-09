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

    <?= $this->Html->css(['normalize.min', 'milligram.min', 'fonts', 'cake']) ?>

    <?= $this->fetch('meta') ?>
    <?= $this->fetch('css') ?>
    <?= $this->fetch('script') ?>
</head>
<body>
    <nav class="top-nav">
        <div class="top-nav-title">
            <a href="<?= $this->Url->build('/') ?>"><span>Moving House </span>24/7</a>
        </div>

        <div class="top-nav-links">
            <?= $this->Html->link('Home', ['controller' => 'Pages', 'action' => 'display', 'home']) ?>

            <?php if ($isAdmin) : ?>
                <?= $this->Html->link('Contact Forms', ['controller' => 'ContactForms', 'action' => 'index']) ?>
                <?= $this->Html->link('Users', ['controller' => 'Users', 'action' => 'index']) ?>
            <?php else : ?>
                <?= $this->Html->link('Contact Us', ['controller' => 'ContactForms', 'action' => 'add']) ?>
            <?php endif; ?>

            <?php if ($identity) : ?>
                <?= $this->Html->link('Log Out', ['controller' => 'Users', 'action' => 'logout']) ?>
            <?php else : ?>
                <?= $this->Html->link('Log In', ['controller' => 'Users', 'action' => 'login']) ?>
            <?php endif; ?>
        </div>
    </nav>
    <main class="main">
        <div class="container">
            <?= $this->Flash->render() ?>
            <?= $this->fetch('content') ?>
        </div>
    </main>
    <footer>
    </footer>
</body>
</html>
