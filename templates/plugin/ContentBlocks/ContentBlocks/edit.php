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

    <div class="mh-page-soft">

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
                        <?= $this->Form->create($contentBlock, [
                            'type' => 'file',
                            'id' => 'cmsEditForm'
                        ]) ?>

                        <?php
                        if ($contentBlock->type === 'text') {
                            $maxLength = 64;
                            $isEmail = false;
                            $isPhone = false;
                            if ($contentBlock->slug === 'main-page-description') {
                                $maxLength = 512;
                            } elseif ($contentBlock->slug === 'header-description-main') {
                                $maxLength = 50;
                            } elseif ($contentBlock->slug === 'first-additional-description-main') {
                                $maxLength = 32;
                            } elseif ($contentBlock->slug === 'second-additional-description-main') {
                                $maxLength = 32;
                            } elseif ($contentBlock->slug === 'third-additional-description-main') {
                                $maxLength = 32;
                            } elseif ($contentBlock->slug === 'hero-stat-first') {
                                $maxLength = 12;
                            } elseif ($contentBlock->slug === 'hero-label-first') {
                                $maxLength = 32;
                            } elseif ($contentBlock->slug === 'hero-stat-second') {
                                $maxLength = 12;
                            } elseif ($contentBlock->slug === 'hero-label-second') {
                                $maxLength = 32;
                            } elseif ($contentBlock->slug === 'hero-stat-third') {
                                $maxLength = 12;
                            } elseif ($contentBlock->slug === 'hero-label-third') {
                                $maxLength = 32;
                            } elseif ($contentBlock->slug === 'services-title') {
                                $maxLength = 32;
                            } elseif ($contentBlock->slug === 'services-subtitle') {
                                $maxLength = 128;
                            } elseif ($contentBlock->slug === 'removal-description') {
                                $maxLength = 128;
                            } elseif ($contentBlock->slug === 'transport-description') {
                                $maxLength = 128    ;
                            } elseif ($contentBlock->slug === 'storage-description') {
                                $maxLength = 128;
                            } elseif ($contentBlock->slug === 'furniture-description') {
                                $maxLength = 128;
                            } elseif ($contentBlock->slug === 'main-page-description') {
                                $maxLength = 256;
                            } elseif ($contentBlock->slug === 'booking-title') {
                                $maxLength = 32;
                            } elseif ($contentBlock->slug === 'booking-subtitle') {
                                $maxLength = 128;
                            } elseif ($contentBlock->slug === 'first-booking-description-card') {
                                $maxLength = 128;
                            } elseif ($contentBlock->slug === 'second-booking-description-card') {
                                $maxLength = 128;
                            } elseif ($contentBlock->slug === 'third-booking-description-card') {
                                $maxLength = 128;
                            } elseif ($contentBlock->slug === 'title-footer') {
                                $maxLength = 50;
                            } elseif ($contentBlock->slug === 'subtitle-footer') {
                                $maxLength = 128;
                            } elseif ($contentBlock->slug === 'company-description-footer') {
                                $maxLength = 128;
                            } elseif ($contentBlock->slug === 'service-description-footer') {
                                $maxLength = 128;
                            } elseif ($contentBlock->slug === 'phone-contact-footer') {
                                $isPhone = true;
                                $maxLength = 10;
                            } elseif ($contentBlock->slug === 'email-contact-footer') {
                                $isEmail = true;
                                $maxLength = 100;
                            }
                            echo $this->Form->control('value', [
                                'type' => 'text',
                                'id' => 'content-block-value',
                                'data-maxlength' => $maxLength,
                                'isEmail' => $isEmail ? 'true' : 'false',
                                'isPhone' => $isPhone ? 'true' : 'false',
                                'isHTML' => 'false',
                                'value' => html_entity_decode($contentBlock->value),
                                'label' => __('Content'),
                                'class' => 'form-control',

                            ]);

                            echo '<div id="char-counter" style="font-size: 13px; margin-top: 5px; color: #666;">0 / 32 characters</div>';
                            echo '<div id="html-tag-error" style="font-size: 13px; margin-top: 5px; color: red; display: none;">HTML code tags are not permitted in plain text fields.</div>';
                            if ($isEmail) {
                                echo '<div id="email-error" style="font-size: 13px; margin-top: 5px; color: red; display: none;">Please enter a valid email address (must include @ and a domain extension).</div>';
                            }
                            if ($isPhone) {
                                echo '<div id="phone-error" style="font-size: 13px; margin-top: 5px; color: red; display: none;">Phone number must be exactly 10 digits.</div>';
                            }


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
                                'type' => 'button',
                                'class' => 'btn btn-primary',
                                'onclick' => 'openCmsConfirmModal()'
                            ]) ?>

                            <?= $this->Html->link(
                                __('Cancel'),
                                ['action' => 'index'],
                                ['class' => 'btn btn-outline-primary']
                            ) ?>
                        </div>
                        <div id="cmsConfirmModal" class="cms-modal-overlay" style="display: none;">
                            <div class="cms-modal-box">
                                <h3><?= __('Confirm Content Block Update') ?></h3>

                                <p>
                                    <?= __('Are you sure you want to update this content block?') ?>
                                </p>

                                <div class="cms-modal-actions">
                                    <button
                                        type="button"
                                        class="btn btn-outline-primary"
                                        onclick="closeCmsConfirmModal()"
                                    >
                                        <?= __('Dismiss') ?>
                                    </button>

                                    <button
                                        type="button"
                                        class="btn btn-primary"
                                        onclick="submitCmsForm()"
                                    >
                                        <?= __('Confirm') ?>
                                    </button>
                                </div>
                            </div>
                        </div>

                        <script>
                            function openCmsConfirmModal() {
                                document.getElementById('cmsConfirmModal').style.display = 'flex';
                            }

                            function closeCmsConfirmModal() {
                                document.getElementById('cmsConfirmModal').style.display = 'none';
                            }

                            function submitCmsForm() {
                                document.getElementById('cmsEditForm').requestSubmit();
                            }
                        </script>
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
<?= $this->Html->script('content-blocks-validation', ['block' => true]); ?>
