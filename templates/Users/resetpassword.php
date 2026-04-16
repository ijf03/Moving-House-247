<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\User $user
 */
?>

<script src="https://www.google.com/recaptcha/api.js?hl=en" async defer></script>

<div class="row">
    <div class="column column-80">
        <div class="users form content">
            <?= $this->Flash->render() ?>

            <?= $this->Form->create(null, ['class' => 'password-reset-form']) ?>
            <fieldset>
                <?php
                echo $this->Form->control('email');
                ?>
                <div class="g-recaptcha" data-sitekey="<?= h($siteKey ?? '') ?>"></div>
            </fieldset>
            <?= $this->Form->button(__('Submit')) ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>
