<?php
declare(strict_types=1);

use Migrations\AbstractMigration;

class CreateFiles extends AbstractMigration
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
        $table = $this->table('files');
        $table->addColumn('id', 'uuid', [
            'default' => null,
            'null' => false,
            'comment' => 'ID',
        ]);
        $table->addColumn('name', 'string', [
            'default' => null,
            'limit' => 255,
            'null' => false,
            'comment' => 'ファイル名',
        ]);
        $table->addColumn('size', 'integer', [
            'default' => 0,
            'limit' => 11,
            'null' => false,
            'signed' => false,
            'comment' => 'ファイルサイズ',
        ]);
        $table->addColumn('content_type', 'string', [
            'default' => null,
            'limit' => 255,
            'null' => false,
            'comment' => 'コンテンツタイプ',
        ]);
        $table->addColumn('directory', 'string', [
            'default' => null,
            'limit' => 255,
            'null' => false,
            'comment' => '保存ディレクトリ',
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
        $table->create();
    }
}
