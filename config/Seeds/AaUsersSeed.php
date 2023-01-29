<?php
declare(strict_types=1);

use Cake\Auth\DefaultPasswordHasher;
use Cake\Datasource\ConnectionManager;
use Migrations\AbstractSeed;

/**
 * Users seed.
 */
class AaUsersSeed extends AbstractSeed
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
        $uuidBase = '01509588-3882-42dd-9ab2-485e8e579';
        $data = [
            [
                'id' => $uuidBase . sprintf('%03d', 1),
                'mail_address' => 'admin@example.com',
                'password' => $this->_setPassword('admin00'),
                'role' => 'admin',
                'created' => $datetime,
                'modified' => $datetime,
            ],
            [
                'id' => $uuidBase . sprintf('%03d', 2),
                'mail_address' => 'editor@example.com',
                'password' => $this->_setPassword('editor00'),
                'role' => 'editor',
                'created' => $datetime,
                'modified' => $datetime,
            ],
            [
                'id' => $uuidBase . sprintf('%03d', 3),
                'mail_address' => 'viewer@example.com',
                'password' => $this->_setPassword('viewer00'),
                'role' => 'viewer',
                'created' => $datetime,
                'modified' => $datetime,
            ],
        ];

        // 右端 3桁不足している UUID
        $uuidBase = '99999999-3882-42dd-9ab2-485e8e579';
        for ($i = 0; $i < 100; $i++) {
            $user = [
                'id' => $uuidBase . sprintf('%03d', $i),
                'mail_address' => 'test' . $i . '@example.com',
                'password' => $this->_setPassword('test' . $i),
                'role' => 'viewer',
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
    private function _setPassword($password)
    {
        if (strlen($password) > 0) {
            return (new DefaultPasswordHasher())->hash($password);
        }
    }
}
