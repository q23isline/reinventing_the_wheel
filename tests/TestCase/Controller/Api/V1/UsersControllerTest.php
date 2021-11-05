<?php
declare(strict_types=1);

namespace App\Test\TestCase\Controller\Api\V1;

use App\Domain\Models\User\Type\BirthDay;
use App\Domain\Models\User\Type\CellPhoneNumber;
use App\Domain\Models\User\Type\FirstName;
use App\Domain\Models\User\Type\FirstNameKana;
use App\Domain\Models\User\Type\LastName;
use App\Domain\Models\User\Type\LastNameKana;
use App\Domain\Models\User\Type\LoginId;
use App\Domain\Models\User\Type\MailAddress;
use App\Domain\Models\User\Type\Password;
use App\Domain\Models\User\Type\RoleName;
use App\Domain\Models\User\Type\Sex;
use App\Domain\Models\User\Type\UserId;
use App\Domain\Models\User\User;
use App\UseCase\Users\UserAddUseCase;
use App\UseCase\Users\UserData;
use App\UseCase\Users\UserDeleteUseCase;
use App\UseCase\Users\UserGetUseCase;
use App\UseCase\Users\UserListUseCase;
use App\UseCase\Users\UserUpdateUseCase;
use Cake\Datasource\Exception\RecordNotFoundException;
use Cake\Event\EventInterface;
use Cake\Event\EventManager;
use Cake\TestSuite\IntegrationTestTrait;
use Cake\TestSuite\TestCase;
use PHPUnit\Framework\MockObject\MockObject;
use ReflectionClass;

/**
 * App\Test\TestCase\Controller\Api\V1\UsersControllerTest Test Case
 *
 * @uses \App\Test\TestCase\Controller\Api\V1\UsersControllerTest
 */
class UsersControllerTest extends TestCase
{
    use IntegrationTestTrait;

    /**
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp();

        // CSRF コンポーネントのトークンミスマッチによるテスト失敗を防ぐ
        // <https://book.cakephp.org/4/ja/development/testing.html#csrfcomponent-securitycomponent>
        $this->enableCsrfToken();

        // 管理者でログイン
        $this->session([
            'Auth' => [
                'User' => [
                    'id' => 'dbdc8d4c-cf7d-4833-b755-4b69e97561f3',
                    'role' => 'admin',
                ],
            ],
        ]);

        // JSON形式でアクセス
        $this->configRequest([
            'headers' => ['Accept' => 'application/json'],
        ]);
    }

    /**
     * Test index method
     *
     * @return void
     */
    public function test_ユーザー一覧をレスポンスすること(): void
    {
        // Arrange
        $userDtos = [
            new UserData(
                User::reconstruct(
                    new UserId('00676011-5447-4eb1-bde1-001880663af3'),
                    new LoginId('test1018'),
                    new Password('password'),
                    new RoleName('viewer'),
                    new FirstName('斉藤'),
                    new LastName('太郎'),
                    new FirstNameKana('サイトウ'),
                    new LastNameKana('タロウ'),
                    new MailAddress('saito6@example.com'),
                    new Sex('1'),
                    new BirthDay('1990-01-01'),
                    new CellPhoneNumber('09011111116'),
                )
            ),
            new UserData(
                User::reconstruct(
                    new UserId('01522f07-609a-415c-9f66-023e981a5523'),
                    new LoginId('test80'),
                    new Password('password'),
                    new RoleName('viewer'),
                    new FirstName('太郎80'),
                    new LastName('テスト'),
                    new FirstNameKana('タロウ80'),
                    new LastNameKana('テスト'),
                    new MailAddress('test80@example.com'),
                    new Sex('0'),
                    null,
                    null,
                )
            ),
        ];

        $mockUserListUseCase = $this->createMock(UserListUseCase::class);
        $mockUserListUseCase->expects($this->once())
            ->method('handle')
            ->will($this->returnValue($userDtos));

        $this->overridePrivatePropertyWithMock('userListUseCase', $mockUserListUseCase);

        $expected = [
            'data' => [
                [
                    'id' => '00676011-5447-4eb1-bde1-001880663af3',
                    'loginId' => 'test1018',
                    'roleName' => 'viewer',
                    'firstName' => '斉藤',
                    'lastName' => '太郎',
                    'firstNameKana' => 'サイトウ',
                    'lastNameKana' => 'タロウ',
                    'mailAddress' => 'saito6@example.com',
                    'sex' => '1',
                    'birthDay' => '1990-01-01',
                    'cellPhoneNumber' => '09011111116',
                ],
                [
                    'id' => '01522f07-609a-415c-9f66-023e981a5523',
                    'loginId' => 'test80',
                    'roleName' => 'viewer',
                    'firstName' => '太郎80',
                    'lastName' => 'テスト',
                    'firstNameKana' => 'タロウ80',
                    'lastNameKana' => 'テスト',
                    'mailAddress' => 'test80@example.com',
                    'sex' => '0',
                    'birthDay' => '',
                    'cellPhoneNumber' => '',
                ],
            ],
        ];

        $expected = json_encode($expected, JSON_PRETTY_PRINT);

        // Act
        $this->get('/api/v1/users');

        // Assert
        // 正常にアクセスできること
        $this->assertResponseCode(200);
        // ユーザー情報を返却すること
        $this->assertEquals($expected, (string)$this->_response->getBody());
    }

    /**
     * Test view method
     *
     * @return void
     */
    public function test_ユーザー詳細をレスポンスすること(): void
    {
        // Arrange
        $id = '00676011-5447-4eb1-bde1-001880663af3';
        $userDtos = new UserData(
            User::reconstruct(
                new UserId($id),
                new LoginId('test1018'),
                new Password('password'),
                new RoleName('viewer'),
                new FirstName('斉藤'),
                new LastName('太郎'),
                new FirstNameKana('サイトウ'),
                new LastNameKana('タロウ'),
                new MailAddress('saito6@example.com'),
                new Sex('1'),
                new BirthDay('1990-01-01'),
                new CellPhoneNumber('09011111116'),
            )
        );

        $mockUserGetUseCase = $this->createMock(UserGetUseCase::class);
        $mockUserGetUseCase->expects($this->once())
            ->method('handle')
            ->will($this->returnValue($userDtos));

        $this->overridePrivatePropertyWithMock('userGetUseCase', $mockUserGetUseCase);

        $expected = [
            'data' => [
                'id' => $id,
                'loginId' => 'test1018',
                'roleName' => 'viewer',
                'firstName' => '斉藤',
                'lastName' => '太郎',
                'firstNameKana' => 'サイトウ',
                'lastNameKana' => 'タロウ',
                'mailAddress' => 'saito6@example.com',
                'sex' => '1',
                'birthDay' => '1990-01-01',
                'cellPhoneNumber' => '09011111116',
            ],
        ];

        $expected = json_encode($expected, JSON_PRETTY_PRINT);

        // Act
        $this->get("/api/v1/users/${id}");

        // Assert
        // 正常にアクセスできること
        $this->assertResponseCode(200);
        // ユーザー情報を返却すること
        $this->assertEquals($expected, (string)$this->_response->getBody());
    }

    /**
     * Test view method
     *
     * @return void
     */
    public function test_ユーザー詳細でユーザーが存在しないエラーを返すこと(): void
    {
        // Arrange
        $id = '00676011-5447-4eb1-bde1-001880663af3';

        $mockUserGetUseCase = $this->createMock(UserGetUseCase::class);
        $mockUserGetUseCase->expects($this->once())
            ->method('handle')
            ->will($this->throwException(new RecordNotFoundException()));

        $this->overridePrivatePropertyWithMock('userGetUseCase', $mockUserGetUseCase);

        $expected = [
            'error' => [
                'message' => 'Not Found',
                'errors' => [
                    [
                        'field' => 'userId',
                        'reason' => 'ユーザーは存在しません。',
                    ],
                ],
            ],
        ];

        $expected = json_encode($expected, JSON_PRETTY_PRINT);

        // Act
        $this->get("/api/v1/users/${id}");

        // Assert
        // 404エラーになること
        $this->assertResponseCode(404);
        // エラー情報を返却すること
        $this->assertEquals($expected, (string)$this->_response->getBody());
    }

    /**
     * Test add method
     *
     * @return void
     */
    public function test_ユーザー追加で追加したユーザーをレスポンスすること(): void
    {
        // Arrange
        $requestData = [
            'loginId' => 'test1018',
            'password' => 'password',
            'roleName' => 'viewer',
            'firstName' => '斉藤',
            'lastName' => '太郎',
            'firstNameKana' => 'サイトウ',
            'lastNameKana' => 'タロウ',
            'mailAddress' => 'saito6@example.com',
            'sex' => '1',
            'birthDay' => '1990-01-01',
            'cellPhoneNumber' => '09011111116',
        ];

        $id = '00676011-5447-4eb1-bde1-001880663af3';
        $mockUserAddUseCase = $this->createMock(UserAddUseCase::class);
        $mockUserAddUseCase->expects($this->once())
            ->method('handle')
            ->will($this->returnValue(new UserId($id)));

        $this->overridePrivatePropertyWithMock('userAddUseCase', $mockUserAddUseCase);

        $expected = ['userId' => $id];
        $expected = json_encode($expected, JSON_PRETTY_PRINT);

        // Act
        $this->post('/api/v1/users', $requestData);

        // Assert
        // 正常にアクセスできること
        $this->assertResponseCode(200);
        // ユーザー情報を返却すること
        $this->assertEquals($expected, (string)$this->_response->getBody());
    }

    /**
     * Test add method
     *
     * @return void
     */
    public function test_ユーザー追加でバリデーションエラーをレスポンスすること(): void
    {
        // Arrange
        $requestData = [];
        $expected = [
            'error' => [
                'message' => 'Bad Request',
                'errors' => [
                    [
                        'field' => 'loginId',
                        'reason' => '必須項目が不足しています。',
                    ],
                    [
                        'field' => 'password',
                        'reason' => '必須項目が不足しています。',
                    ],
                    [
                        'field' => 'roleName',
                        'reason' => '必須項目が不足しています。',
                    ],
                    [
                        'field' => 'firstName',
                        'reason' => '必須項目が不足しています。',
                    ],
                    [
                        'field' => 'lastName',
                        'reason' => '必須項目が不足しています。',
                    ],
                    [
                        'field' => 'firstNameKana',
                        'reason' => '必須項目が不足しています。',
                    ],
                    [
                        'field' => 'lastNameKana',
                        'reason' => '必須項目が不足しています。',
                    ],
                    [
                        'field' => 'mailAddress',
                        'reason' => '必須項目が不足しています。',
                    ],
                    [
                        'field' => 'sex',
                        'reason' => '必須項目が不足しています。',
                    ],
                ],
            ],
        ];

        $expected = json_encode($expected, JSON_PRETTY_PRINT);

        // Act
        $this->post('/api/v1/users', $requestData);

        // Assert
        // 400エラーになること
        $this->assertResponseCode(400);
        // エラー情報を返却すること
        $this->assertEquals($expected, (string)$this->_response->getBody());
    }

    /**
     * Test edit method
     *
     * @return void
     */
    public function test_ユーザー編集で編集したユーザーをレスポンスすること(): void
    {
        // Arrange
        $id = '00676011-5447-4eb1-bde1-001880663af3';
        $requestData = [
            'loginId' => 'test1018',
            'password' => 'password',
            'roleName' => 'viewer',
            'firstName' => '斉藤',
            'lastName' => '太郎',
            'firstNameKana' => 'サイトウ',
            'lastNameKana' => 'タロウ',
            'mailAddress' => 'saito6@example.com',
            'sex' => '1',
            'birthDay' => '1990-01-01',
            'cellPhoneNumber' => '09011111116',
        ];

        $mockUserUpdateUseCase = $this->createMock(UserUpdateUseCase::class);
        $mockUserUpdateUseCase->expects($this->once())
            ->method('handle')
            ->will($this->returnValue(new UserId($id)));

        $this->overridePrivatePropertyWithMock('userUpdateUseCase', $mockUserUpdateUseCase);

        $expected = ['userId' => $id];
        $expected = json_encode($expected, JSON_PRETTY_PRINT);

        // Act
        $this->put("/api/v1/users/${id}", $requestData);

        // Assert
        // 正常にアクセスできること
        $this->assertResponseCode(200);
        // ユーザー情報を返却すること
        $this->assertEquals($expected, (string)$this->_response->getBody());
    }

    /**
     * Test edit method
     *
     * @return void
     */
    public function test_ユーザー編集でユーザーが存在しないエラーを返すこと(): void
    {
        // Arrange
        $id = '00676011-5447-4eb1-bde1-001880663af3';
        $requestData = [
            'loginId' => 'test1018',
            'password' => 'password',
            'roleName' => 'viewer',
            'firstName' => '斉藤',
            'lastName' => '太郎',
            'firstNameKana' => 'サイトウ',
            'lastNameKana' => 'タロウ',
            'mailAddress' => 'saito6@example.com',
            'sex' => '1',
            'birthDay' => '1990-01-01',
            'cellPhoneNumber' => '09011111116',
        ];

        $mockUserUpdateUseCase = $this->createMock(UserUpdateUseCase::class);
        $mockUserUpdateUseCase->expects($this->once())
            ->method('handle')
            ->will($this->throwException(new RecordNotFoundException()));

        $this->overridePrivatePropertyWithMock('userUpdateUseCase', $mockUserUpdateUseCase);

        $expected = [
            'error' => [
                'message' => 'Not Found',
                'errors' => [
                    [
                        'field' => 'userId',
                        'reason' => 'ユーザーは存在しません。',
                    ],
                ],
            ],
        ];

        $expected = json_encode($expected, JSON_PRETTY_PRINT);

        // Act
        $this->put("/api/v1/users/${id}", $requestData);

        // Assert
        // 404エラーになること
        $this->assertResponseCode(404);
        // エラー情報を返却すること
        $this->assertEquals($expected, (string)$this->_response->getBody());
    }

    /**
     * Test edit method
     *
     * @return void
     */
    public function test_ユーザー編集でバリデーションエラーをレスポンスすること(): void
    {
        // Arrange
        $id = '00676011-5447-4eb1-bde1-001880663af3';
        $requestData = [];
        $expected = [
            'error' => [
                'message' => 'Bad Request',
                'errors' => [
                    [
                        'field' => 'loginId',
                        'reason' => '必須項目が不足しています。',
                    ],
                    [
                        'field' => 'password',
                        'reason' => '必須項目が不足しています。',
                    ],
                    [
                        'field' => 'roleName',
                        'reason' => '必須項目が不足しています。',
                    ],
                    [
                        'field' => 'firstName',
                        'reason' => '必須項目が不足しています。',
                    ],
                    [
                        'field' => 'lastName',
                        'reason' => '必須項目が不足しています。',
                    ],
                    [
                        'field' => 'firstNameKana',
                        'reason' => '必須項目が不足しています。',
                    ],
                    [
                        'field' => 'lastNameKana',
                        'reason' => '必須項目が不足しています。',
                    ],
                    [
                        'field' => 'mailAddress',
                        'reason' => '必須項目が不足しています。',
                    ],
                    [
                        'field' => 'sex',
                        'reason' => '必須項目が不足しています。',
                    ],
                ],
            ],
        ];

        $expected = json_encode($expected, JSON_PRETTY_PRINT);

        // Act
        $this->put("/api/v1/users/${id}", $requestData);

        // Assert
        // 400エラーになること
        $this->assertResponseCode(400);
        // エラー情報を返却すること
        $this->assertEquals($expected, (string)$this->_response->getBody());
    }

    /**
     * Test delete method
     *
     * @return void
     */
    public function test_ユーザー削除でエラーにならないこと(): void
    {
        // Arrange
        $id = '00676011-5447-4eb1-bde1-001880663af3';
        $mockUserDeleteUseCase = $this->createMock(UserDeleteUseCase::class);
        $mockUserDeleteUseCase->expects($this->once())
            ->method('handle')
            ->will($this->returnValue(new UserId($id)));

        $this->overridePrivatePropertyWithMock('userDeleteUseCase', $mockUserDeleteUseCase);

        // Act
        $this->delete("/api/v1/users/${id}");

        // Assert
        // 正常にアクセスできること
        $this->assertResponseCode(200);
        // null を返却すること
        $this->assertEquals('null', (string)$this->_response->getBody());
    }

    /**
     * Test delete method
     *
     * @return void
     */
    public function test_ユーザー削除でユーザーが存在しないエラーを返すこと(): void
    {
        // Arrange
        $id = '00676011-5447-4eb1-bde1-001880663af3';
        $mockUserDeleteUseCase = $this->createMock(UserDeleteUseCase::class);
        $mockUserDeleteUseCase->expects($this->once())
            ->method('handle')
            ->will($this->throwException(new RecordNotFoundException()));

        $this->overridePrivatePropertyWithMock('userDeleteUseCase', $mockUserDeleteUseCase);

        $expected = [
            'error' => [
                'message' => 'Not Found',
                'errors' => [
                    [
                        'field' => 'userId',
                        'reason' => 'ユーザーは存在しません。',
                    ],
                ],
            ],
        ];

        $expected = json_encode($expected, JSON_PRETTY_PRINT);

        // Act
        $this->delete("/api/v1/users/${id}");

        // Assert
        // 404エラーになること
        $this->assertResponseCode(404);
        // エラー情報を返却すること
        $this->assertEquals($expected, (string)$this->_response->getBody());
    }

    /**
     * プライベートプロパティをモックで上書きする
     *
     * @param string $propertyName propertyName
     * @param \PHPUnit\Framework\MockObject\MockObject $mockObject mockObject
     * @return void
     */
    private function overridePrivatePropertyWithMock(string $propertyName, MockObject $mockObject): void
    {
        // グローバルイベントマネージャーで Controller->initialize() を検知
        // <https://book.cakephp.org/4/ja/core-libraries/events.html#id4>
        EventManager::instance()->on(
            'Controller.initialize',
            function (EventInterface $event) use ($propertyName, $mockObject) {
                // コントローラのオブジェクト取得
                // <https://book.cakephp.org/4/ja/core-libraries/events.html#id12>
                $controller = $event->getSubject();

                // Reflection クラスから Controller クラスのプロパティ情報を取得
                $property = (new ReflectionClass($controller))->getProperty($propertyName);

                // privateプロパティへのアクセスを許可
                $property->setAccessible(true);

                // プロパティの値をモックで上書き
                $property->setValue($controller, $mockObject);
            }
        );
    }
}
