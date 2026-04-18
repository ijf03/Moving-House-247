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

    <!-- Bootstrap CSS -->
    <?= $this->Html->css('https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css') ?>

    <!-- Optional: keep your own custom styles -->
    <?= $this->Html->css(['fonts', 'cake']) ?>

    <?= $this->fetch('meta') ?>
    <?= $this->fetch('css') ?>
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container">
        <a class="navbar-brand" href="<?= $this->Url->build('/') ?>">Moving House 24/7</a>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mainNavbar">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="mainNavbar">
            <div class="navbar-nav ms-auto">
                <?= $this->Html->link(
                    'Home',
                    ['controller' => 'Pages', 'action' => 'display', 'home'],
                    ['class' => 'nav-link']
                ) ?>

                <?php if ($isAdmin) : ?>
                    <?= $this->Html->link(
                        'Contact Forms',
                        ['controller' => 'ContactForms', 'action' => 'index'],
                        ['class' => 'nav-link']
                    ) ?>
                    <?= $this->Html->link(
                        'Users',
                        ['controller' => 'Users', 'action' => 'index'],
                        ['class' => 'nav-link']
                    ) ?>
                <?php else : ?>
                    <?= $this->Html->link(
                        'Contact Us',
                        ['controller' => 'ContactForms', 'action' => 'add'],
                        ['class' => 'nav-link']
                    ) ?>
                <?php endif; ?>

                <?php if ($identity) : ?>
                    <?= $this->Html->link(
                        'Log Out',
                        ['controller' => 'Users', 'action' => 'logout'],
                        ['class' => 'nav-link']
                    ) ?>
                <?php else : ?>
                    <?= $this->Html->link(
                        'Log In',
                        ['controller' => 'Users', 'action' => 'login'],
                        ['class' => 'nav-link']
                    ) ?>
                <?php endif; ?>
            </div>
        </div>
    </div>
</nav>

<main class="py-4">
    <div class="container">
        <?= $this->Flash->render() ?>
        <?= $this->fetch('content') ?>
    </div>
</main>

<footer class="text-center py-3 border-top">
    <div class="container">
        <small>&copy; <?= date('Y') ?> Moving House 24/7</small>
    </div>
</footer>

<!-- Bootstrap JS Bundle -->
<?= $this->Html->script('https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js') ?>

<?= $this->fetch('script') ?>
</body>
</html>
