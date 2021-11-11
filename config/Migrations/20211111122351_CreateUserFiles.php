<?php
declare(strict_types=1);

use Migrations\AbstractMigration;

class CreateUserFiles extends AbstractMigration
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
        $table = $this->table('user_files');
        $table->addColumn('id', 'integer', [
            'autoIncrement' => true,
            'default' => null,
            'limit' => 11,
            'null' => false,
            'comment' => 'ID',
        ]);
        $table->addColumn('user_id', 'string', [
            'default' => null,
            'limit' => 255,
            'null' => false,
            'comment' => 'ユーザーID',
        ]);
        $table->addColumn('file_id', 'string', [
            'default' => null,
            'limit' => 255,
            'null' => false,
            'comment' => 'ファイルID',
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
        $table->addForeignKey(
            'user_id',
            'users',
            'id',
            ['delete' => 'CASCADE', 'update' => 'NO_ACTION'],
        );
        $table->addForeignKey(
            'file_id',
            'files',
            'id',
            ['delete' => 'CASCADE', 'update' => 'NO_ACTION'],
        );
        $table->create();
    }
}
