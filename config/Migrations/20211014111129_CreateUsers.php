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
        $table->addColumn('username', 'string', [
            'default' => null,
            'limit' => 50,
            'null' => false,
            'comment' => 'ログインID',
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
            'comment' => 'ロール名',
        ]);
        $table->addColumn('first_name', 'string', [
            'default' => null,
            'limit' => 50,
            'null' => false,
            'comment' => '名',
        ]);
        $table->addColumn('last_name', 'string', [
            'default' => null,
            'limit' => 50,
            'null' => false,
            'comment' => '姓',
        ]);
        $table->addColumn('first_name_kana', 'string', [
            'default' => null,
            'limit' => 50,
            'null' => false,
            'comment' => 'メイ',
        ]);
        $table->addColumn('last_name_kana', 'string', [
            'default' => null,
            'limit' => 50,
            'null' => false,
            'comment' => 'セイ',
        ]);
        $table->addColumn('mail_address', 'string', [
            'default' => null,
            'limit' => 255,
            'null' => false,
            'comment' => 'メールアドレス',
        ]);
        $table->addColumn('sex', 'string', [
            'default' => '0',
            'limit' => 1,
            'null' => false,
            'comment' => '性別',
        ]);
        $table->addColumn('birth_day', 'date', [
            'default' => null,
            'null' => true,
            'comment' => '誕生日',
        ]);
        $table->addColumn('cell_phone_number', 'string', [
            'default' => null,
            'limit' => 11,
            'null' => true,
            'comment' => '携帯電話番号',
        ]);
        $table->addColumn('remarks', 'text', [
            'default' => null,
            'null' => true,
            'comment' => 'メモ',
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
        $table->addIndex(['username'], ['unique' => true, 'name' => 'users_IDX1']);
        $table->addIndex(['mail_address'], ['unique' => true, 'name' => 'users_IDX2']);
        $table->addIndex(['cell_phone_number'], ['unique' => true, 'name' => 'users_IDX3']);
        $table->addIndex(['remarks'], ['type' => 'fulltext', 'name' => 'users_FTIDX1']);
        $table->create();
    }
}
