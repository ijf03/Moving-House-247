<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\UserType $userType
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('Edit User Type'), ['action' => 'edit', $userType->user_type_id], ['class' => 'side-nav-item']) ?>
            <?= $this->Form->postLink(__('Delete User Type'), ['action' => 'delete', $userType->user_type_id], ['confirm' => __('Are you sure you want to delete # {0}?', $userType->user_type_id), 'class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('List User Types'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('New User Type'), ['action' => 'add'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column column-80">
        <div class="userTypes view content">
            <h3><?= h($userType->name) ?></h3>
            <table>
                <tr>
                    <th><?= __('Name') ?></th>
                    <td><?= h($userType->name) ?></td>
                </tr>
                <tr>
                    <th><?= __('User Type Id') ?></th>
                    <td><?= $this->Number->format($userType->user_type_id) ?></td>
                </tr>
            </table>
            <div class="text">
                <strong><?= __('Description') ?></strong>
                <blockquote>
                    <?= $this->Text->autoParagraph(h($userType->description)); ?>
                </blockquote>
            </div>
        </div>
    </div>
</div>