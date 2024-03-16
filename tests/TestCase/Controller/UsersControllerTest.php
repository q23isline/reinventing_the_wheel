<?php
declare(strict_types=1);

namespace App\Test\TestCase\Controller;

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
     * @var list<string>
     */
    protected array $fixtures = [
        'app.Users',
        'app.Profiles',
    ];

    /**
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();

        $this->enableCsrfToken();

        // 管理者でログイン
        $this->session([
            'Auth' => [
                'User' => [
                    'id' => '41559b8b-e831-4972-8afa-21ee8b952d85',
                    'mail_address' => 'admin@example.com',
                    'role' => 'admin',
                    'created' => '2020-01-01 00:00:00',
                    'modified' => '2020-01-02 00:00:00',
                ],
            ],
        ]);
    }

    /**
     * @return void
     */
    protected function tearDown(): void
    {
        parent::tearDown();
        $this->getTableLocator()->clear();
    }

    /**
     * Test not login access NG
     *
     * @return void
     * @uses \App\Controller\UsersController::index()
     */
    public function testNotLoginAccessNg(): void
    {
        // Arrange
        // 未ログイン
        $this->session(['Auth' => null]);

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
     * @uses \App\Controller\UsersController::index()
     */
    public function testIndex(): void
    {
        // Arrange
        $expectUser = [
            'id' => '41559b8b-e831-4972-8afa-21ee8b952d85',
            'mail_address' => 'admin@example.com',
            'role' => 'admin',
            'created' => '2020-01-01 00:00:00',
            'modified' => '2020-01-02 00:00:00',
        ];
        $expectUser['password'] = 'password';
        $expectUsers = [$expectUser];

        // Act
        $this->get('/users');

        // Assert
        // 正常にアクセスできること
        $this->assertResponseCode(200);
        // ユーザー情報を返却すること
        $users = $this->viewVariable('users')->toArray();
        $this->assertEquals($expectUsers[0]['mail_address'], $users[0]->mail_address);
    }

    /**
     * Test view method
     *
     * @return void
     * @uses \App\Controller\UsersController::view()
     */
    public function testView(): void
    {
        // Arrange
        $id = '41559b8b-e831-4972-8afa-21ee8b952d85';
        $expectUser = [
            'id' => $id,
            'mail_address' => 'admin@example.com',
            'role' => 'admin',
            'created' => '2020-01-01 00:00:00',
            'modified' => '2020-01-02 00:00:00',
        ];
        $expectUser['password'] = 'password';

        // Act
        $this->get("/users/view/{$id}");

        // Assert
        // 正常にアクセスできること
        $this->assertResponseCode(200);
        // ユーザー情報を返却すること
        $user = $this->viewVariable('user');
        $this->assertEquals($expectUser['mail_address'], $user->mail_address);
    }

    /**
     * Test add method success
     *
     * @return void
     * @uses \App\Controller\UsersController::add()
     */
    public function testAddSuccess(): void
    {
        // Arrange
        $requestData = [
            'mail_address' => 'saito@example.com',
            'password' => 'password',
            'role' => 'viewer',
        ];

        // Act
        $this->post('/users/add', $requestData);

        // Assert
        // 一覧に遷移すること
        $this->assertRedirectContains('/users');
        // 保存されていること
        $users = $this->getTableLocator()->get('Users');
        $query = $users->find()->where(['mail_address' => $requestData['mail_address']]);
        $this->assertEquals(1, $query->count());
    }

    /**
     * Test add method failed
     *
     * @return void
     * @uses \App\Controller\UsersController::add()
     */
    public function testAddFailed(): void
    {
        // Arrange
        $requestData = [
            'mail_address' => 'saito6@example.com',
            'password' => '',
            'role' => 'viewer',
        ];

        // Act
        $this->post('/users/add', $requestData);

        // Assert
        // 正常にアクセスできること
        $this->assertResponseCode(200);
        // バリデーションエラーになること
        $this->assertResponseContains('The user could not be saved. Please, try again.');
    }

    /**
     * Test edit method success
     *
     * @return void
     * @uses \App\Controller\UsersController::edit()
     */
    public function testEditSuccess(): void
    {
        // Arrange
        $id = '41559b8b-e831-4972-8afa-21ee8b952d85';
        $requestData = [
            'mail_address' => 'saito@example.com',
            'password' => 'password',
            'role' => 'viewer',
        ];

        // Act
        $this->put("/users/edit/{$id}", $requestData);

        // Assert
        // 一覧に遷移すること
        $this->assertRedirectContains('/users');
        // 保存されていること
        $users = $this->getTableLocator()->get('Users');
        $query = $users->find()->where(['mail_address' => $requestData['mail_address']]);
        $this->assertEquals(1, $query->count());
    }

    /**
     * Test edit method failed
     *
     * @return void
     * @uses \App\Controller\UsersController::edit()
     */
    public function testEditFailed(): void
    {
        // Arrange
        $id = '41559b8b-e831-4972-8afa-21ee8b952d85';
        $requestData = [
            'mail_address' => 'saito6@example.com',
            'password' => '',
            'role' => 'viewer',
        ];

        // Act
        $this->put("/users/edit/{$id}", $requestData);

        // Assert
        // 正常にアクセスできること
        $this->assertResponseCode(200);
        // バリデーションエラーになること
        $this->assertResponseContains('The user could not be saved. Please, try again.');
    }

    /**
     * Test delete method
     *
     * @return void
     * @uses \App\Controller\UsersController::delete()
     */
    public function testDeleteSuccess(): void
    {
        // Arrange
        $id = '41559b8b-e831-4972-8afa-21ee8b952d85';

        // Act
        $this->delete("/users/delete/{$id}");

        // Assert
        // 一覧に遷移すること
        $this->assertRedirectContains('/users');
        // 削除されていること
        $users = $this->getTableLocator()->get('Users');
        $query = $users->find()->where(['id' => $id]);
        $this->assertEquals(0, $query->count());
    }

    /**
     * Test delete method
     *
     * @return void
     * @uses \App\Controller\UsersController::delete()
     */
    public function testDeleteFailed(): void
    {
        // Arrange
        $id = '41559b8b-e831-4972-8afa-21ee8b952d85';
        $model = $this->getMockForModel('Users', ['delete']);
        $model->expects($this->once())
            ->method('delete')
            ->willReturn(false);

        // Act
        $this->delete("/users/delete/{$id}");

        // Assert
        // リダイレクトすること
        $this->assertResponseCode(302);
        // エラーになること
        $this->assertFlashMessage('The user could not be deleted. Please, try again.', 'flash');
    }

    /**
     * Test login method Already
     *
     * @return void
     * @uses \App\Controller\UsersController::login()
     */
    public function testLoginAlready(): void
    {
        // Arrange

        // Act
        $this->post('/users/login');

        // Assert
        // 一覧に遷移すること
        $this->assertRedirectContains('/users');
    }

    /**
     * Test login method failed
     *
     * @return void
     * @uses \App\Controller\UsersController::login()
     */
    public function testLoginFailed(): void
    {
        // Arrange
        $this->session(['Auth' => null]);
        $requestData = [
            'mail_address' => 'admin@example.com',
            'password' => 'p@ssw0rd',
        ];

        // Act
        $this->post('/users/login', $requestData);

        // Assert
        // 正常にアクセスできること
        $this->assertResponseCode(200);
        // バリデーションエラーになること
        $this->assertResponseContains('Invalid mail address or password');
    }

    /**
     * Test logout method
     *
     * @return void
     * @uses \App\Controller\UsersController::logout()
     */
    public function testLogout(): void
    {
        // Arrange

        // Act
        $this->get('/users/logout');

        // Assert
        // ログイン画面に遷移すること
        $this->assertRedirectContains('/');
    }
}
