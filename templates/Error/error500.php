<?php
/**
 * @var \App\View\AppView $this
 * @var string $message
 * @var string $url
 */
use Cake\Core\Configure;
use Cake\Error\Debugger;

$this->setLayout('default');

if (Configure::read('debug')) :
    $this->setLayout('dev_error');

    $this->assign('title', $message);
    $this->assign('templateName', 'error500.php');

    $this->start('file');
?>
<?php if ($error instanceof Error) : ?>
    <?php $file = $error->getFile() ?>
    <?php $line = $error->getLine() ?>
    <strong>Error in: </strong>
    <?= $this->Html->link(sprintf('%s, line %s', Debugger::trimPath($file), $line), Debugger::editorUrl($file, $line)); ?>
<?php endif; ?>
<?php
    echo $this->element('auto_table_warning');

    $this->end();
endif;
?>

<div class="mh-page-soft mh-error-page">
    <section class="admin-hero mh-error-hero">
        <div class="container">
            <div class="admin-hero-shell">
                <div class="admin-hero-content">
                    <span class="admin-eyebrow"><?= __('Oops!') ?></span>
                    <h1><?= __('500') ?></h1>
                    <p class="admin-hero-text">
                        <?= __('This server is taking a rest.') ?>
                    </p>
                </div>
            </div>
        </div>
    </section>

    <section class="admin-section">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <div class="admin-table-card mh-error-card text-center">
                        <div class="mh-error-emoji">📦🚚</div>

                        <div class="admin-table-header">
                            <h2><?= __('Internal Error') ?></h2>
                            <p>
                                <?= __('The server has left the service desk.') ?>
                            </p>
                        </div>

                        <div class="mh-info-card mh-error-message-card">
                            <div class="w-100">
                                <h3><?= __('What happened?') ?></h3>
                                <p>
                                    <?= __('An Internal Error has Occurred.', "<strong>" . h($url) . "</strong>") ?>
                                </p>
                            </div>
                        </div>

                        <div class="mh-error-actions">
                            <?= $this->Html->link(
                                __('Back to Home'),
                                '/',
                                ['class' => 'admin-primary-link']
                            ) ?>

                            <button
                                onclick="history.back()"
                                class="admin-action-link mh-back-btn"
                                type="button"
                            >
                                <?= __('Go Back') ?>
                            </button>
                        </div>

                        <p class="mh-error-note">
                            <?= __('Try using the navigation bar to head back to a valid page.') ?>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
