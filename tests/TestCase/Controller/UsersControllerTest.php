<?php
declare(strict_types=1);

namespace App\Test\TestCase\Controller;

use App\Controller\UsersController;
use Cake\TestSuite\IntegrationTestTrait;
use Cake\TestSuite\TestCase;

/**
 * App\Controller\UsersController Test Case
 *
 * @uses \App\Controller\UsersController
 */
class UsersControllerTest extends TestCase
{
    use IntegrationTestTrait;

    /**
     * Fixtures
     *
     * @var array
     */
    protected $fixtures = [
        'app.Users',
    ];

    /**
     * Test index method
     *
     * @return void
     */
    public function testIndexNotLoginAccessNg(): void
    {
        // Arrange
        // 未ログイン

        // Act
        $this->get('/users');

        // Assert
        // ログイン画面へ遷移すること
        $this->assertRedirectContains('/');
    }

    /**
     * Test index method
     *
     * @return void
     */
    public function testIndexAdminAccessOk(): void
    {
        // Arrange
        // 管理者でログイン
        $authUser = [
            'id' => 1,
            'username' => 'admin',
            'role' => 'admin',
            'first_name' => 'admin',
            'last_name' => '管理者',
            'created' => '2020-01-01 00:00:00',
            'modified' => '2020-01-02 00:00:00',
        ];
        $this->session([
            'Auth' => [
                'User' => $authUser,
            ],
        ]);
        // ユーザー情報を取得した場合
        // （UsersFixture->init()のデータがDBアクセス時に返却される）
        // TODO: init()をオーバーライドして動的に返却させる値を変えたい
        $expectUser = $authUser;
        $expectUser['password'] = 'password';
        $expectUsers = [$expectUser];

        // Act
        $this->get('/users');

        // Assert
        // 正常にアクセスできること
        $this->assertResponseCode(200);
        // ユーザー情報を返却すること
        $users = $this->viewVariable('users')->toArray();
        $this->assertEquals($expectUsers[0]['username'], $users[0]->username);
    }
}
