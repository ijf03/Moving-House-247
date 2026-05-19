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
<div class="admin-layout" id="adminLayout">
    <aside class="admin-sidebar" id="adminSidebar">
        <div class="admin-sidebar-top">
            <div class="admin-sidebar-brand-row">
                <a class="admin-sidebar-brand"
                   href="<?= $this->Url->build(['plugin' => false,'controller' => 'Users', 'action' => 'index']) ?>">
                    <span class="admin-sidebar-brand-text">
                        Moving House <span class="mh-accent">24/7</span>
                    </span>
                </a>

                <button type="button" class="admin-sidebar-toggle" id="adminSidebarToggle">
                    ☰
                </button>
            </div>
        </div>

        <nav class="admin-sidebar-nav">
            <?= $this->Html->link('Dashboard', ['plugin' => false, 'controller' => 'Admin', 'action' => 'index'], ['class' => 'admin-sidebar-link']) ?>
            <?= $this->Html->link('Manage Bookings', ['plugin' => false, 'controller' => 'Bookings', 'action' => 'index'], ['class' => 'admin-sidebar-link']) ?>
            <?= $this->Html->link('Manage Inquiries', ['plugin' => false, 'controller' => 'ContactForms', 'action' => 'index'], ['class' => 'admin-sidebar-link']) ?>
            <?= $this->Html->link('Manage Invoices', ['plugin' => false, 'controller' => 'Invoices', 'action' => 'index'], ['class' => 'admin-sidebar-link']) ?>
            <div class="admin-sidebar-group">
                <button
                    type="button"
                    class="admin-sidebar-link admin-sidebar-dropdown-toggle"
                    data-bs-toggle="collapse"
                    data-bs-target="#resourceManagementMenu"
                    aria-expanded="false"
                    aria-controls="resourceManagementMenu"
                >
                    <?= __('Resource Management') ?>
                    <span class="admin-sidebar-chevron">▾</span>
                </button>

                <div class="collapse admin-sidebar-submenu" id="resourceManagementMenu">
                    <?= $this->Html->link(
                        __('Overview'),
                        ['plugin' => false, 'controller' => 'Resources', 'action' => 'index'],
                        ['class' => 'admin-sidebar-sublink']
                    ) ?>

                    <?= $this->Html->link(
                        __('Job Requirements'),
                        ['plugin' => false, 'controller' => 'JobResources', 'action' => 'index'],
                        ['class' => 'admin-sidebar-sublink']
                    ) ?>

                    <?= $this->Html->link(
                        __('Trucks'),
                        ['plugin' => false, 'controller' => 'Trucks', 'action' => 'index'],
                        ['class' => 'admin-sidebar-sublink']
                    ) ?>

                    <?= $this->Html->link(
                        __('Storage Units'),
                        ['plugin' => false, 'controller' => 'StorageUnits', 'action' => 'index'],
                        ['class' => 'admin-sidebar-sublink']
                    ) ?>

                    <?= $this->Html->link(
                        __('Equipment'),
                        ['plugin' => false, 'controller' => 'Equipment', 'action' => 'index'],
                        ['class' => 'admin-sidebar-sublink']
                    ) ?>

                    <?= $this->Html->link(
                        __('Inventory'),
                        ['plugin' => false, 'controller' => 'InventoryItems', 'action' => 'index'],
                        ['class' => 'admin-sidebar-sublink']
                    ) ?>
                </div>
            </div>
            <?= $this->Html->link('Job Allocation', ['plugin' => false, 'controller' => 'Jobs', 'action' => 'index'], ['class' => 'admin-sidebar-link']) ?>
            <?= $this->Html->link('Manage Users', ['plugin' => false, 'controller' => 'Users', 'action' => 'index'], ['class' => 'admin-sidebar-link']) ?>
            <?= $this->Html->link(
                'Website Content',
                ['plugin' => 'ContentBlocks', 'controller' => 'ContentBlocks', 'action' => 'index'],
                ['class' => 'admin-sidebar-link'],
            ) ?>
            <?= $this->Html->link('Manage Staff', ['plugin' => false, 'controller' => 'Staff', 'action' => 'index'], ['class' => 'admin-sidebar-link']) ?>
        </nav>

        <div class="admin-sidebar-footer">
            <?= $this->Html->link('Logout', ['plugin' => false, 'controller' => 'Users', 'action' => 'logout'], ['class' => 'admin-sidebar-link admin-sidebar-logout']) ?>
            <div class="container-fluid text-center">
                <small class="tiny-text">&copy; <?= date('Y') ?> Moving House 24/7. <br> All rights reserved.</small>
            </div>
        </div>
    </aside>

    <main class="admin-content">
        <?= $this->Flash->render() ?>
        <?= $this->fetch('content') ?>
    </main>
</div>
</body>

<?= $this->Html->script('https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js') ?>
<?= $this->fetch('script') ?>

<script>
    const adminLayout = document.getElementById('adminLayout');
    const toggleButton = document.getElementById('adminSidebarToggle');

    if (localStorage.getItem('adminSidebarCollapsed') === 'true') {
        adminLayout.classList.add('admin-sidebar-collapsed');
    }

    toggleButton.addEventListener('click', function () {
        adminLayout.classList.toggle('admin-sidebar-collapsed');
        localStorage.setItem(
            'adminSidebarCollapsed',
            adminLayout.classList.contains('admin-sidebar-collapsed')
        );
    });
</script>

</body>
</html>
