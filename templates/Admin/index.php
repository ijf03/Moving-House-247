<?php
/**
 * @var \App\View\AppView $this
 */
$this->assign('title', 'Admin Dashboard');
?>

<section class="admin-hero">
    <div class="container">
        <div class="admin-hero-shell">
            <div class="admin-hero-content">
                <span class="admin-eyebrow">Admin Dashboard</span>

                <h1>Manage Moving House 24/7</h1>

                <p class="admin-hero-text">
                    Quickly access the main admin tools for bookings, inquiries,
                    invoices, users, resources, and website management.
                </p>
            </div>
        </div>
    </div>
</section>

<section class="admin-section">
    <div class="container">

        <div class="admin-table-card">

            <div class="admin-table-header">
                <h2>Admin Actions</h2>

                <p>
                    Select a section below to manage different areas of the system.
                </p>
            </div>

            <div class="row g-4 mt-1">

                <div class="col-md-6 col-xl-4">
                    <?= $this->Html->link(
                        '
                        <div class="mh-info-card h-100">
                            <div>
                                <h3>Manage Bookings</h3>

                                <p>
                                    View, approve, update, and manage customer
                                    moving bookings and requests.
                                </p>
                            </div>
                        </div>
                        ',
                        ['controller' => 'Bookings', 'action' => 'index'],
                        [
                            'escape' => false,
                            'class' => 'admin-dashboard-card'
                        ]
                    ) ?>
                </div>

                <div class="col-md-6 col-xl-4">
                    <?= $this->Html->link(
                        '
                        <div class="mh-info-card h-100">
                            <div>
                                <h3>Manage Inquiries</h3>

                                <p>
                                    Respond to customer inquiries, feedback,
                                    and support concerns submitted through the website.
                                </p>
                            </div>
                        </div>
                        ',
                        ['controller' => 'ContactForms', 'action' => 'index'],
                        [
                            'escape' => false,
                            'class' => 'admin-dashboard-card'
                        ]
                    ) ?>
                </div>

                <div class="col-md-6 col-xl-4">
                    <?= $this->Html->link(
                        '
                        <div class="mh-info-card h-100">
                            <div>
                                <h3>Manage Invoices</h3>

                                <p>
                                    Create, update, finalise, and track invoices
                                    and payment statuses.
                                </p>
                            </div>
                        </div>
                        ',
                        ['controller' => 'Invoices', 'action' => 'index'],
                        [
                            'escape' => false,
                            'class' => 'admin-dashboard-card'
                        ]
                    ) ?>
                </div>

                <div class="col-md-6 col-xl-4">
                    <?= $this->Html->link(
                        '
                        <div class="mh-info-card h-100">
                            <div>
                                <h3>Manage Users</h3>

                                <p>
                                    Manage customer and staff accounts,
                                    permissions, and account details.
                                </p>
                            </div>
                        </div>
                        ',
                        ['controller' => 'Users', 'action' => 'index'],
                        [
                            'escape' => false,
                            'class' => 'admin-dashboard-card'
                        ]
                    ) ?>
                </div>

                <div class="col-md-6 col-xl-4">
                    <?= $this->Html->link(
                        '
                        <div class="mh-info-card h-100">
                            <div>
                                <h3>Resource Management</h3>

                                <p>
                                    Manage moving equipment, vehicles,
                                    storage resources, and operational assets.
                                </p>
                            </div>
                        </div>
                        ',
                        ['controller' => 'Resources', 'action' => 'index'],
                        [
                            'escape' => false,
                            'class' => 'admin-dashboard-card'
                        ]
                    ) ?>
                </div>

                <div class="col-md-6 col-xl-4">
                    <?= $this->Html->link(
                        '
                        <div class="mh-info-card h-100">
                            <div>
                                <h3>Job Allocation</h3>

                                <p>
                                    Assign staff, organise schedules,
                                    and manage moving job allocations.
                                </p>
                            </div>
                        </div>
                        ',
                        ['controller' => 'Jobs', 'action' => 'index'],
                        [
                            'escape' => false,
                            'class' => 'admin-dashboard-card'
                        ]
                    ) ?>
                </div>

                <div class="col-md-6 col-xl-4">
                    <?= $this->Html->link(
                        '
                        <div class="mh-info-card h-100">
                            <div>
                                <h3>Website Content</h3>

                                <p>
                                    Update homepage sections, website text,
                                    and CMS-managed content.
                                </p>
                            </div>
                        </div>
                        ',
                        ['controller' => 'ContentBlocks', 'action' => 'index'],
                        [
                            'escape' => false,
                            'class' => 'admin-dashboard-card'
                        ]
                    ) ?>
                </div>

            </div>

        </div>

    </div>
</section>
