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
            <?= $this->Html->link(__('List Users'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="users form content">
            <?= $this->Form->create($user) ?>
            <fieldset>
                <legend><?= __('Add User') ?></legend>
                    <?php
                    echo $this->Form->control('username');
                    echo $this->Form->control('password');
                    echo $this->Form->control('role', [
                        'options' => [
                            'admin' => 'admin',
                            'editor' => 'editor',
                            'viewer' => 'viewer',
                        ],
                    ]);
                    echo $this->Form->control('last_name');
                    echo $this->Form->control('first_name');
                    echo $this->Form->control('last_name_kana');
                    echo $this->Form->control('first_name_kana');
                    echo $this->Form->control('mail_address');
                    echo $this->Form->control('sex', [
                        'options' => [
                            '0' => '未選択',
                            '1' => '男性',
                            '2' => '女性',
                            '9' => 'その他',
                        ],
                    ]);
                    echo $this->Form->control('birth_day');
                    echo $this->Form->control('cell_phone_number');
                    ?>
            </fieldset>
            <?= $this->Form->button(__('Submit')) ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>
