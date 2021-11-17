<?php
declare(strict_types=1);

use Cake\Auth\DefaultPasswordHasher;
use Cake\Datasource\ConnectionManager;
use Cake\Utility\Text;
use Migrations\AbstractSeed;

/**
 * Users seed.
 */
class UsersSeed extends AbstractSeed
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
    public function run()
    {
        $datetime = date('Y-m-d H:i:s');
        $data = [
            [
                'id' => Text::uuid(),
                'username' => 'admin',
                'password' => $this->_setPassword('admin00'),
                'role' => 'admin',
                'first_name' => 'admin',
                'last_name' => '管理者',
                'first_name_kana' => 'アドミン',
                'last_name_kana' => 'カンリシャ',
                'mail_address' => 'admin@example.com',
                'sex' => '1',
                'birth_day' => '1990-01-01',
                'cell_phone_number' => '09012345678',
                'remarks' => '管理者メモ',
                'created' => $datetime,
                'modified' => $datetime,
            ],
            [
                'id' => Text::uuid(),
                'username' => 'editor',
                'password' => $this->_setPassword('editor00'),
                'role' => 'editor',
                'first_name' => 'editor',
                'last_name' => '編集者',
                'first_name_kana' => 'エディター',
                'last_name_kana' => 'ヘンシュウシャ',
                'mail_address' => 'editor@example.com',
                'sex' => '2',
                'birth_day' => '1990-01-01',
                'cell_phone_number' => '0901234568',
                'remarks' => '編集者メモ',
                'created' => $datetime,
                'modified' => $datetime,
            ],
            [
                'id' => Text::uuid(),
                'username' => 'viewer',
                'password' => $this->_setPassword('viewer00'),
                'role' => 'viewer',
                'first_name' => 'viewer',
                'last_name' => '閲覧者',
                'first_name_kana' => 'ビュワー',
                'last_name_kana' => 'エツランシャ',
                'mail_address' => 'viewer@example.com',
                'sex' => '1',
                'birth_day' => '1990-01-01',
                'cell_phone_number' => '09012345679',
                'remarks' => '閲覧者メモ',
                'created' => $datetime,
                'modified' => $datetime,
            ],
        ];

        for ($i = 0; $i < 1000; $i++) {
            $user = [
                'id' => Text::uuid(),
                'username' => 'test' . $i,
                'password' => $this->_setPassword('test' . $i),
                'role' => 'viewer',
                'first_name' => '太郎' . $i,
                'last_name' => 'テスト',
                'first_name_kana' => 'タロウ' . $i,
                'last_name_kana' => 'テスト',
                'mail_address' => 'test' . $i . '@example.com',
                'created' => $datetime,
                'modified' => $datetime,
            ];

            $data[] = $user;
        }

        // 外部キー制約を一時的に OFF
        $connection = ConnectionManager::get('default');
        $connection->execute('SET FOREIGN_KEY_CHECKS = 0');

        $table = $this->table('users');

        // delete insert
        $table->truncate();
        $table->insert($data)->save();

        $connection->execute('SET FOREIGN_KEY_CHECKS = 1');
    }

    /**
     * パスワードを生成する
     *
     * @param string $password パスワード
     * @return string ハッシュ化されたパスワード
     */
    protected function _setPassword($password)
    {
        if (strlen($password) > 0) {
            return (new DefaultPasswordHasher())->hash($password);
        }
    }
}
