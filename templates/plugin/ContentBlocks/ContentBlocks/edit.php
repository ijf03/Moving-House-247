<?php
/**
 * @var \App\View\AppView $this
 * @var \ContentBlocks\Model\Entity\ContentBlock $contentBlock
 */

$this->assign('title', 'Edit Content Block - Content Blocks');

$this->Html->script('ContentBlocks.ckeditor/ckeditor', ['block' => true]);
$this->Html->css('ContentBlocks.content-blocks', ['block' => true]);
?>

    <style>
        .ck-editor__editable_inline {
            min-height: 25rem;
        }

        .content-block-image-preview {
            max-width: 100%;
            max-height: 320px;
            object-fit: contain;
            display: block;
            margin-bottom: 1rem;
            border-radius: 0.5rem;
            border: 1px solid #dee2e6;
        }
    </style>

    <div class="contentBlocks form content mh-page-soft">

        <section class="admin-hero">
            <div class="container">
                <div class="admin-hero-shell">
                    <div class="admin-hero-content">
                        <span class="admin-eyebrow"><?= __('Admin') ?></span>
                        <h1><?= __('Edit Content Block') ?></h1>
                        <p class="admin-hero-text">
                            <?= __('Update website text, HTML content, or image blocks used across the site.') ?>
                        </p>
                    </div>
                </div>
            </div>
        </section>

        <section class="admin-section">
            <div class="container">

                <div class="admin-table-card">
                    <div class="admin-table-header">
                        <h2><?= h($contentBlock->label) ?></h2>

                        <?php if (!empty($contentBlock->description)) : ?>
                            <p><?= h($contentBlock->description) ?></p>
                        <?php else : ?>
                            <p><?= __('Edit this content block below.') ?></p>
                        <?php endif; ?>
                    </div>

                    <div class="p-3">
                        <?= $this->Form->create($contentBlock, ['type' => 'file']) ?>

                        <?php
                        if ($contentBlock->type === 'text') {
                            echo $this->Form->control('value', [
                                'type' => 'text',
                                'value' => html_entity_decode($contentBlock->value),
                                'label' => __('Content'),
                                'class' => 'form-control',
                            ]);
                        } elseif ($contentBlock->type === 'html') {
                            echo $this->Form->control('value', [
                                'type' => 'textarea',
                                'label' => __('Content'),
                                'id' => 'content-value-input',
                                'class' => 'form-control',
                            ]);
                        } elseif ($contentBlock->type === 'image') {
                            if (!empty($contentBlock->value)) {
                                echo $this->Html->image($contentBlock->value, [
                                    'class' => 'content-block-image-preview',
                                    'alt' => h($contentBlock->label),
                                ]);
                            }

                            echo $this->Form->control('value', [
                                'type' => 'file',
                                'accept' => 'image/*',
                                'label' => __('Upload Image'),
                                'class' => 'form-control',
                            ]);
                        }
                        ?>

                        <div class="d-flex gap-2 flex-wrap mt-4">
                            <?= $this->Form->button(__('Save'), [
                                'class' => 'btn btn-primary'
                            ]) ?>

                            <?= $this->Html->link(
                                __('Cancel'),
                                ['action' => 'index'],
                                ['class' => 'btn btn-outline-primary']
                            ) ?>
                        </div>

                        <?= $this->Form->end() ?>
                    </div>
                </div>

            </div>
        </section>

    </div>

<?php if ($contentBlock->type === 'html') : ?>
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            CKSource.Editor.create(
                document.getElementById('content-value-input'),
                {
                    toolbar: [
                        'heading', '|',
                        'bold', 'italic', 'underline', '|',
                        'bulletedList', 'numberedList', '|',
                        'alignment', 'blockQuote', '|',
                        'indent', 'outdent', '|',
                        'link', '|',
                        'insertTable', 'imageInsert', 'mediaEmbed', 'horizontalLine', '|',
                        'removeFormat', '|',
                        'sourceEditing', '|',
                        'undo', 'redo',
                    ],
                    simpleUpload: {
                        uploadUrl: <?= json_encode($this->Url->build(['action' => 'upload'])) ?>,
                        headers: {
                            'X-CSRF-TOKEN': <?= json_encode($this->request->getAttribute('csrfToken')) ?>,
                        }
                    }
                }
            );
        });
    </script>
<?php endif; ?>
