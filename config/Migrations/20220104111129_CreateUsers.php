<?php
declare(strict_types=1);

use Migrations\AbstractMigration;

class CreateUsers extends AbstractMigration
{
    public $autoId = false;

    /**
     * Change Method.
     *
     * More information on this method is available here:
     * https://book.cakephp.org/phinx/0/en/migrations.html#the-change-method
     *
     * @return void
     */
    public function change()
    {
        $table = $this->table('users');
        $table->addColumn('id', 'uuid', [
            'default' => null,
            'null' => false,
            'comment' => 'ID',
        ]);
        $table->addColumn('mail_address', 'string', [
            'default' => null,
            'limit' => 255,
            'null' => false,
            'comment' => 'メールアドレス',
        ]);
        $table->addColumn('password', 'string', [
            'default' => null,
            'limit' => 255,
            'null' => false,
            'comment' => 'パスワード',
        ]);
        $table->addColumn('role', 'string', [
            'default' => null,
            'limit' => 20,
            'null' => false,
            'comment' => '権限',
        ]);
        $table->addColumn('created', 'datetime', [
            'default' => null,
            'null' => false,
            'comment' => '作成日',
        ]);
        $table->addColumn('modified', 'datetime', [
            'default' => null,
            'null' => false,
            'comment' => '更新日',
        ]);
        $table->addPrimaryKey([
            'id',
        ]);
        $table->addIndex(['mail_address'], ['unique' => true, 'name' => 'users_IDX1']);
        $table->create();
    }
}
