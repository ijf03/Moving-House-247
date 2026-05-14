<?php
/**
 * @var \App\View\AppView $this
 * @var iterable<\ContentBlocks\Model\Entity\ContentBlock> $contentBlocksGrouped
 */

$this->assign('title', 'Content Blocks');

$this->Html->css('ContentBlocks.content-blocks', ['block' => true]);

$slugify = function ($text) {
    return strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $text), '-'));
};
?>

<div class="contentBlocks index content mh-page-soft">

    <section class="admin-hero">
        <div class="container">
            <div class="admin-hero-shell">
                <div class="admin-hero-content">
                    <span class="admin-eyebrow"><?= __('Admin') ?></span>
                    <h1><?= __('Content Blocks') ?></h1>
                    <p class="admin-hero-text">
                        <?= __('Manage editable website text, page sections, and reusable content blocks.') ?>
                    </p>
                </div>
            </div>
        </div>
    </section>

    <section class="admin-section">
        <div class="container">

            <?php if (!empty($contentBlocksGrouped)) : ?>

                <div class="admin-table-card mb-4">
                    <div class="admin-table-header">
                        <h2><?= __('Quick Links') ?></h2>
                        <p><?= __('Jump to a content block category.') ?></p>
                    </div>

                    <div class="p-3">
                        <div class="d-flex gap-2 flex-wrap">
                            <?php foreach (array_keys($contentBlocksGrouped) as $parent) : ?>
                                <a
                                    href="#<?= h($slugify($parent)) ?>"
                                    class="btn btn-outline-primary btn-sm"
                                >
                                    <?= h($parent) ?>
                                </a>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>

                <div class="row g-4">
                    <?php foreach ($contentBlocksGrouped as $parent => $contentBlocks) : ?>

                        <div class="col-12">
                            <div class="admin-table-card">
                                <div class="admin-table-header d-flex justify-content-between align-items-center">
                                    <div>
                                        <h2 id="<?= h($slugify($parent)) ?>">
                                            <?= h($parent) ?>
                                        </h2>
                                        <p>
                                            <?= __('Edit or restore content blocks in this section.') ?>
                                        </p>
                                    </div>
                                </div>

                                <div class="table-responsive">
                                    <table class="table admin-table mb-0">
                                        <thead>
                                        <tr>
                                            <th><?= __('Content Block') ?></th>
                                            <th><?= __('Description') ?></th>
                                            <th class="actions"><?= __('Actions') ?></th>
                                        </tr>
                                        </thead>

                                        <tbody>
                                        <?php if (empty($contentBlocks)) : ?>
                                            <tr>
                                                <td colspan="3">
                                                    <?= __('No content blocks found in this section.') ?>
                                                </td>
                                            </tr>
                                        <?php else : ?>
                                            <?php foreach ($contentBlocks as $contentBlock) : ?>
                                                <tr>
                                                    <td>
                                                        <strong><?= h($contentBlock['label']) ?></strong>
                                                    </td>

                                                    <td>
                                                        <?php if (!empty($contentBlock['description'])) : ?>
                                                            <?= h($contentBlock['description']) ?>
                                                        <?php else : ?>
                                                            <span class="text-muted">
                                                                <?= __('No description provided.') ?>
                                                            </span>
                                                        <?php endif; ?>
                                                    </td>

                                                    <td class="actions">
                                                        <div class="admin-action-stack">
                                                            <?= $this->Html->link(
                                                                __('Edit'),
                                                                ['action' => 'edit', $contentBlock->id],
                                                                ['class' => 'admin-action-link']
                                                            ) ?>

                                                            <?php if (!empty($contentBlock->previous_value)) : ?>
                                                                <?= $this->Form->postLink(
                                                                    __('Restore'),
                                                                    ['action' => 'restore', $contentBlock->id],
                                                                    [
                                                                        'class' => 'admin-action-link',
                                                                        'confirm' => __(
                                                                            "Are you sure you want to restore the previous version for this item?\n{0}/{1}\nNote: You cannot cancel this action!",
                                                                            $contentBlock->parent,
                                                                            $contentBlock->slug
                                                                        )
                                                                    ]
                                                                ) ?>
                                                            <?php endif; ?>
                                                        </div>
                                                    </td>
                                                </tr>
                                            <?php endforeach; ?>
                                        <?php endif; ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>

                    <?php endforeach; ?>
                </div>

            <?php else : ?>

                <div class="admin-table-card">
                    <div class="admin-table-header">
                        <h2><?= __('No Content Blocks Found') ?></h2>
                        <p><?= __('There are currently no editable content blocks available.') ?></p>
                    </div>

                    <div class="p-3">
                        <p class="mb-0">
                            <?= __('Once content blocks are added, they will appear here for editing.') ?>
                        </p>
                    </div>
                </div>

            <?php endif; ?>

        </div>
    </section>

</div>
