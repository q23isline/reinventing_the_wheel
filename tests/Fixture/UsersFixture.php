<?php
declare(strict_types=1);

namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * UsersFixture
 */
class UsersFixture extends TestFixture
{
    /**
     * Fields
     *
     * @var array
     */
    // phpcs:disable
    public $fields = [
        'id' => ['type' => 'uuid', 'length' => null, 'null' => false, 'default' => null, 'comment' => 'ID', 'precision' => null],
        'username' => ['type' => 'string', 'length' => 50, 'null' => false, 'default' => null, 'collate' => 'utf8mb4_general_ci', 'comment' => 'ログインID', 'precision' => null],
        'password' => ['type' => 'string', 'length' => 255, 'null' => false, 'default' => null, 'collate' => 'utf8mb4_general_ci', 'comment' => 'パスワード', 'precision' => null],
        'role' => ['type' => 'string', 'length' => 20, 'null' => false, 'default' => null, 'collate' => 'utf8mb4_general_ci', 'comment' => 'ロール名', 'precision' => null],
        'first_name' => ['type' => 'string', 'length' => 50, 'null' => false, 'default' => null, 'collate' => 'utf8mb4_general_ci', 'comment' => '名', 'precision' => null],
        'last_name' => ['type' => 'string', 'length' => 50, 'null' => false, 'default' => null, 'collate' => 'utf8mb4_general_ci', 'comment' => '姓', 'precision' => null],
        'first_name_kana' => ['type' => 'string', 'length' => 50, 'null' => false, 'default' => null, 'collate' => 'utf8mb4_general_ci', 'comment' => 'メイ', 'precision' => null],
        'last_name_kana' => ['type' => 'string', 'length' => 50, 'null' => false, 'default' => null, 'collate' => 'utf8mb4_general_ci', 'comment' => 'セイ', 'precision' => null],
        'mail_address' => ['type' => 'string', 'length' => 255, 'null' => false, 'default' => null, 'collate' => 'utf8mb4_general_ci', 'comment' => 'メールアドレス', 'precision' => null],
        'sex' => ['type' => 'string', 'length' => 1, 'null' => false, 'default' => '0', 'collate' => 'utf8mb4_general_ci', 'comment' => '性別', 'precision' => null],
        'birth_day' => ['type' => 'date', 'length' => null, 'null' => true, 'default' => null, 'comment' => '誕生日', 'precision' => null],
        'cell_phone_number' => ['type' => 'string', 'length' => 11, 'null' => true, 'default' => null, 'collate' => 'utf8mb4_general_ci', 'comment' => '携帯電話番号', 'precision' => null],
        'created' => ['type' => 'datetime', 'length' => null, 'precision' => null, 'null' => false, 'default' => null, 'comment' => '作成日'],
        'modified' => ['type' => 'datetime', 'length' => null, 'precision' => null, 'null' => false, 'default' => null, 'comment' => '更新日'],
        '_constraints' => [
            'primary' => ['type' => 'primary', 'columns' => ['id'], 'length' => []],
            'users_IDX1' => ['type' => 'unique', 'columns' => ['username'], 'length' => []],
            'users_IDX2' => ['type' => 'unique', 'columns' => ['mail_address'], 'length' => []],
            'users_IDX3' => ['type' => 'unique', 'columns' => ['cell_phone_number'], 'length' => []],
        ],
        '_options' => [
            'engine' => 'InnoDB',
            'collation' => 'utf8mb4_general_ci'
        ],
    ];
    // phpcs:enable
    /**
     * Init method
     *
     * @return void
     */
    public function init(): void
    {
        $this->records = [
            [
                'id' => '41559b8b-e831-4972-8afa-21ee8b952d85',
                'username' => 'admin',
                'password' => 'password',
                'role' => 'admin',
                'first_name' => 'admin',
                'last_name' => '管理者',
                'first_name_kana' => 'アドミン',
                'last_name_kana' => 'カンリシャ',
                'mail_address' => 'admin@example.com',
                'sex' => '1',
                'birth_day' => '2021-10-14',
                'cell_phone_number' => '09012345678',
                'created' => '2020-01-01 00:00:00',
                'modified' => '2020-01-02 00:00:00',
            ],
            [
                'id' => '99999999-5447-4eb1-bde1-001880663af3',
                'username' => 'test1018',
                'password' => 'password',
                'role' => 'viewer',
                'first_name' => '斉藤',
                'last_name' => '太郎',
                'first_name_kana' => 'サイトウ',
                'last_name_kana' => 'タロウ',
                'mail_address' => 'saito6@example.com',
                'sex' => '1',
                'birth_day' => '1990-01-01',
                'cell_phone_number' => '09011111116',
                'created' => '2020-01-03 00:00:00',
                'modified' => '2020-01-04 00:00:00',
            ],
        ];
        parent::init();
    }
}
