<?php
declare(strict_types=1);

use Cake\Datasource\ConnectionManager;
use Migrations\AbstractSeed;

/**
 * Profiles seed.
 */
class AbProfilesSeed extends AbstractSeed
{
    /**
     * Run Method.
     *
     * Write your database seeder using this method.
     *
     * More information on writing seeds is available here:
     * https://book.cakephp.org/phinx/0/en/seeding.html
     *
     * @return void
     */
    public function run(): void
    {
        $datetime = date('Y-m-d H:i:s');
        // 右端 3桁不足している UUID
        $uuidBase = '4a90fd6e-1784-4a60-83ed-be37b3bfa';
        $userUuidBase = '01509588-3882-42dd-9ab2-485e8e579';
        $data = [
            [
                'id' => $uuidBase . sprintf('%03d', 1),
                'user_id' => $userUuidBase . sprintf('%03d', 1),
                'first_name' => 'admin',
                'last_name' => '管理者',
                'first_name_kana' => 'あどみん',
                'last_name_kana' => 'かんりしゃ',
                'sex' => '1',
                'birth_day' => '1990-01-01',
                'cell_phone_number' => '09012345678',
                'remarks' => '管理者メモ',
                'created' => $datetime,
                'modified' => $datetime,
            ],
            [
                'id' => $uuidBase . sprintf('%03d', 2),
                'user_id' => $userUuidBase . sprintf('%03d', 2),
                'first_name' => 'editor',
                'last_name' => '編集者',
                'first_name_kana' => 'えでぃたー',
                'last_name_kana' => 'へんしゅうしゃ',
                'sex' => '2',
                'birth_day' => '1990-01-01',
                'cell_phone_number' => '0901234568',
                'remarks' => '編集者メモ',
                'created' => $datetime,
                'modified' => $datetime,
            ],
            [
                'id' => $uuidBase . sprintf('%03d', 3),
                'user_id' => $userUuidBase . sprintf('%03d', 3),
                'first_name' => 'viewer',
                'last_name' => '閲覧者',
                'first_name_kana' => 'びゅわー',
                'last_name_kana' => 'えつらんしゃ',
                'sex' => '1',
                'birth_day' => '1990-01-01',
                'cell_phone_number' => '09012345679',
                'remarks' => '閲覧者メモ',
                'created' => $datetime,
                'modified' => $datetime,
            ],
        ];

        // 右端 3桁不足している UUID
        $uuidBase = '99999999-1784-4a60-83ed-be37b3bfa';
        $userUuidBase = '99999999-3882-42dd-9ab2-485e8e579';
        for ($i = 0; $i < 100; $i++) {
            $user = [
                'id' => $uuidBase . sprintf('%03d', $i),
                'user_id' => $userUuidBase . sprintf('%03d', $i),
                'first_name' => '太郎' . $i,
                'last_name' => 'テスト',
                'first_name_kana' => 'たろう' . $i,
                'last_name_kana' => 'てすと',
                'created' => $datetime,
                'modified' => $datetime,
            ];

            $data[] = $user;
        }

        // 外部キー制約を一時的に OFF
        $connection = ConnectionManager::get('default');
        $connection->execute('SET FOREIGN_KEY_CHECKS = 0');

        $table = $this->table('profiles');

        // delete insert
        $table->truncate();
        $table->insert($data)->save();

        $connection->execute('SET FOREIGN_KEY_CHECKS = 1');
    }
}
