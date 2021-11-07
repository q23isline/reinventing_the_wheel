<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\User $user
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('Edit User'), ['action' => 'edit', $user->id], ['class' => 'side-nav-item']) ?>
            <?= $this->Form->postLink(__('Delete User'), ['action' => 'delete', $user->id], ['confirm' => __('Are you sure you want to delete # {0}?', $user->id), 'class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('List Users'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('New User'), ['action' => 'add'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="users view content">
            <h3><?= h($user->id) ?></h3>
            <table>
                <tr>
                    <th><?= __('Username') ?></th>
                    <td><?= h($user->username) ?></td>
                </tr>
                <tr>
                    <th><?= __('Role') ?></th>
                    <td><?= h($user->role) ?></td>
                </tr>
                <tr>
                    <th><?= __('LastName') ?></th>
                    <td><?= h($user->last_name) ?></td>
                </tr>
                <tr>
                    <th><?= __('FirstName') ?></th>
                    <td><?= h($user->first_name) ?></td>
                </tr>
                <tr>
                    <th><?= __('LastNameKana') ?></th>
                    <td><?= h($user->last_name_kana) ?></td>
                </tr>
                <tr>
                    <th><?= __('FirstNameKana') ?></th>
                    <td><?= h($user->first_name_kana) ?></td>
                </tr>
                <tr>
                    <th><?= __('MailAddress') ?></th>
                    <td><?= h($user->mail_address) ?></td>
                </tr>
                <tr>
                    <th><?= __('Sex') ?></th>
                    <td><?= h($user->sex) ?></td>
                </tr>
                <tr>
                    <th><?= __('BirthDay') ?></th>
                    <td><?= h($user->birth_day) ?></td>
                </tr>
                <tr>
                    <th><?= __('CellPhoneNumber') ?></th>
                    <td><?= h($user->cell_phone_number) ?></td>
                </tr>
                <tr>
                    <th><?= __('Remarks') ?></th>
                    <td><?= h($user->remarks) ?></td>
                </tr>
            </table>
        </div>
    </div>
</div>
