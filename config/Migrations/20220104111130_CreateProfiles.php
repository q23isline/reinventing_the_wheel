<?php
declare(strict_types=1);

use Migrations\AbstractMigration;

class CreateProfiles extends AbstractMigration
{
    public bool $autoId = false;

    /**
     * Change Method.
     *
     * More information on this method is available here:
     * https://book.cakephp.org/phinx/0/en/migrations.html#the-change-method
     *
     * @return void
     */
    public function change(): void
    {
        $table = $this->table('profiles');
        $table->addColumn('id', 'uuid', [
            'default' => null,
            'null' => false,
            'comment' => 'ID',
        ]);
        $table->addColumn('user_id', 'uuid', [
            'default' => null,
            'null' => false,
            'comment' => 'ユーザーID',
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
            'comment' => '名（かな）',
        ]);
        $table->addColumn('last_name_kana', 'string', [
            'default' => null,
            'limit' => 50,
            'null' => false,
            'comment' => '姓（かな）',
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
        $table->addForeignKey(
            'user_id',
            'users',
            'id',
            ['delete' => 'CASCADE', 'update' => 'NO_ACTION'],
        );
        $table->addIndex(['cell_phone_number'], ['unique' => true, 'name' => 'profiles_IDX1']);
        $table->create();

        if ($table->getAdapter()->getAdapterType() === 'mysql') {
            // マイグレーションで ngram 設定できないため、SQL 直接実行する
            // FULLTEXT INDEX は MySQL のみで実行させる（テスト実行時は sqlite のため、エラー防止）
            $this->execute('ALTER TABLE profiles ADD FULLTEXT profiles_FTIDX1 (remarks) WITH PARSER ngram');
        }
    }
}
