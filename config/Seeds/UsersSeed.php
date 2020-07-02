<?php
declare(strict_types=1);

use Cake\Auth\DefaultPasswordHasher;
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
                'username' => 'admin',
                'password' => $this->_setPassword('admin00'),
                'role' => 'admin',
                'created' => $datetime,
                'modified' => $datetime,
                'first_name' => 'admin',
                'last_name' => '管理者',
            ],
            [
                'username' => 'editor',
                'password' => $this->_setPassword('editor00'),
                'role' => 'editor',
                'created' => $datetime,
                'modified' => $datetime,
                'first_name' => 'editor',
                'last_name' => '編集者',
            ],
            [
                'username' => 'viewer',
                'password' => $this->_setPassword('viewer00'),
                'role' => 'viewer',
                'created' => $datetime,
                'modified' => $datetime,
                'first_name' => 'viewer',
                'last_name' => '閲覧者',
            ],
        ];

        for ($i = 0; $i < 1000; $i++) {
            $user = [
                'username' => 'test' . $i,
                'password' => $this->_setPassword('test' . $i),
                'role' => 'viewer',
                'created' => $datetime,
                'modified' => $datetime,
                'first_name' => '太郎' . $i,
                'last_name' => 'テスト',
            ];

            $data[] = $user;
        }

        $table = $this->table('users');

        // delete insert
        $table->truncate();
        $table->insert($data)->save();
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
