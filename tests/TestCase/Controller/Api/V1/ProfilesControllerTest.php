<?php
declare(strict_types=1);

namespace App\Test\TestCase\Controller\Api\V1;

use App\Domain\Models\Profile\Profile;
use App\Domain\Models\Profile\Type\BirthDay;
use App\Domain\Models\Profile\Type\CellPhoneNumber;
use App\Domain\Models\Profile\Type\FirstName;
use App\Domain\Models\Profile\Type\FirstNameKana;
use App\Domain\Models\Profile\Type\LastName;
use App\Domain\Models\Profile\Type\LastNameKana;
use App\Domain\Models\Profile\Type\ProfileId;
use App\Domain\Models\Profile\Type\Remarks;
use App\Domain\Models\Profile\Type\Sex;
use App\Domain\Models\User\Type\UserId;
use App\UseCase\Profiles\ProfileAddUseCase;
use App\UseCase\Profiles\ProfileData;
use App\UseCase\Profiles\ProfileDeleteUseCase;
use App\UseCase\Profiles\ProfileGetUseCase;
use App\UseCase\Profiles\ProfileListUseCase;
use App\UseCase\Profiles\ProfileUpdateUseCase;
use Cake\Datasource\Exception\RecordNotFoundException;
use Cake\Event\EventInterface;
use Cake\Event\EventManager;
use Cake\TestSuite\IntegrationTestTrait;
use Cake\TestSuite\TestCase;
use PHPUnit\Framework\MockObject\MockObject;
use ReflectionClass;

/**
 * App\Test\TestCase\Controller\Api\V1\ProfilesControllerTest Test Case
 *
 * @uses \App\Test\TestCase\Controller\Api\V1\ProfilesControllerTest
 */
class ProfilesControllerTest extends TestCase
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
    public function test_プロフィール一覧をレスポンスすること(): void
    {
        // Arrange
        $profileDtos = [
            new ProfileData(
                Profile::reconstruct(
                    new ProfileId('c2e37627-ac0a-45e0-9dfd-eb5d703d8989'),
                    new UserId('00676011-5447-4eb1-bde1-001880663af3'),
                    new FirstName('斉藤'),
                    new LastName('太郎'),
                    new FirstNameKana('サイトウ'),
                    new LastNameKana('タロウ'),
                    new Sex('1'),
                    new BirthDay('1990-01-01'),
                    new CellPhoneNumber('09011111116'),
                    new Remarks('斉藤メモ'),
                )
            ),
            new ProfileData(
                Profile::reconstruct(
                    new ProfileId('c2e37627-ac0a-45e0-9dfd-eb5d703d8990'),
                    new UserId('01522f07-609a-415c-9f66-023e981a5523'),
                    new FirstName('太郎80'),
                    new LastName('テスト'),
                    new FirstNameKana('タロウ80'),
                    new LastNameKana('テスト'),
                    new Sex('0'),
                    null,
                    null,
                    null,
                )
            ),
        ];

        $mockProfileListUseCase = $this->createMock(ProfileListUseCase::class);
        $mockProfileListUseCase->expects($this->once())
            ->method('handle')
            ->will($this->returnValue($profileDtos));

        $this->overridePrivatePropertyWithMock('profileListUseCase', $mockProfileListUseCase);

        $expected = [
            'data' => [
                [
                    'id' => 'c2e37627-ac0a-45e0-9dfd-eb5d703d8989',
                    'firstName' => '斉藤',
                    'lastName' => '太郎',
                    'firstNameKana' => 'サイトウ',
                    'lastNameKana' => 'タロウ',
                    'sex' => '1',
                    'birthDay' => '1990-01-01',
                    'cellPhoneNumber' => '09011111116',
                    'remarks' => '斉藤メモ',
                ],
                [
                    'id' => 'c2e37627-ac0a-45e0-9dfd-eb5d703d8990',
                    'firstName' => '太郎80',
                    'lastName' => 'テスト',
                    'firstNameKana' => 'タロウ80',
                    'lastNameKana' => 'テスト',
                    'sex' => '0',
                    'birthDay' => '',
                    'cellPhoneNumber' => '',
                    'remarks' => '',
                ],
            ],
        ];

        $expected = json_encode($expected, JSON_PRETTY_PRINT);

        // Act
        $this->get('/api/v1/users/profiles');

        // Assert
        // 正常にアクセスできること
        $this->assertResponseCode(200);
        // プロフィール情報を返却すること
        $this->assertEquals($expected, (string)$this->_response->getBody());
    }

    /**
     * Test view method
     *
     * @return void
     */
    public function test_プロフィール詳細をレスポンスすること(): void
    {
        // Arrange
        $id = 'c2e37627-ac0a-45e0-9dfd-eb5d703d8989';
        $userId = 'c2e37627-ac0a-45e0-9dfd-eb5d703d8989';
        $profileDtos = new ProfileData(
            Profile::reconstruct(
                new ProfileId($id),
                new UserId($userId),
                new FirstName('斉藤'),
                new LastName('太郎'),
                new FirstNameKana('サイトウ'),
                new LastNameKana('タロウ'),
                new Sex('1'),
                new BirthDay('1990-01-01'),
                new CellPhoneNumber('09011111116'),
                new Remarks('斉藤メモ'),
            )
        );

        $mockProfileGetUseCase = $this->createMock(ProfileGetUseCase::class);
        $mockProfileGetUseCase->expects($this->once())
            ->method('handle')
            ->will($this->returnValue($profileDtos));

        $this->overridePrivatePropertyWithMock('profileGetUseCase', $mockProfileGetUseCase);

        $expected = [
            'data' => [
                'id' => $id,
                'firstName' => '斉藤',
                'lastName' => '太郎',
                'firstNameKana' => 'サイトウ',
                'lastNameKana' => 'タロウ',
                'sex' => '1',
                'birthDay' => '1990-01-01',
                'cellPhoneNumber' => '09011111116',
                'remarks' => '斉藤メモ',
            ],
        ];

        $expected = json_encode($expected, JSON_PRETTY_PRINT);

        // Act
        $this->get("/api/v1/users/{$userId}/profiles/{$id}");

        // Assert
        // 正常にアクセスできること
        $this->assertResponseCode(200);
        // プロフィール情報を返却すること
        $this->assertEquals($expected, (string)$this->_response->getBody());
    }

    /**
     * Test view method
     *
     * @return void
     */
    public function test_プロフィール詳細でプロフィールが存在しないエラーを返すこと(): void
    {
        // Arrange
        $id = 'c2e37627-ac0a-45e0-9dfd-eb5d703d8989';
        $userId = '00676011-5447-4eb1-bde1-001880663af3';

        $mockProfileGetUseCase = $this->createMock(ProfileGetUseCase::class);
        $mockProfileGetUseCase->expects($this->once())
            ->method('handle')
            ->will($this->throwException(new RecordNotFoundException()));

        $this->overridePrivatePropertyWithMock('profileGetUseCase', $mockProfileGetUseCase);

        $expected = [
            'error' => [
                'message' => 'Not Found',
                'errors' => [
                    [
                        'field' => 'profileId',
                        'reason' => 'プロフィールは存在しません。',
                    ],
                ],
            ],
        ];

        $expected = json_encode($expected, JSON_PRETTY_PRINT);

        // Act
        $this->get("/api/v1/users/{$userId}/profiles/{$id}");

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
    public function test_プロフィール追加で追加したプロフィールをレスポンスすること(): void
    {
        // Arrange
        $requestData = [
            'firstName' => '斉藤',
            'lastName' => '太郎',
            'firstNameKana' => 'サイトウ',
            'lastNameKana' => 'タロウ',
            'sex' => '1',
            'birthDay' => '1990-01-01',
            'cellPhoneNumber' => '09011111116',
            'remarks' => '斉藤メモ',
        ];

        $id = 'c2e37627-ac0a-45e0-9dfd-eb5d703d8989';
        $userId = '00676011-5447-4eb1-bde1-001880663af3';
        $mockProfileAddUseCase = $this->createMock(ProfileAddUseCase::class);
        $mockProfileAddUseCase->expects($this->once())
            ->method('handle')
            ->will($this->returnValue(new ProfileId($id)));

        $this->overridePrivatePropertyWithMock('profileAddUseCase', $mockProfileAddUseCase);

        $expected = ['profileId' => $id];
        $expected = json_encode($expected, JSON_PRETTY_PRINT);

        // Act
        $this->post("/api/v1/users/{$userId}/profiles", $requestData);

        // Assert
        // 正常にアクセスできること
        $this->assertResponseCode(200);
        // プロフィール情報を返却すること
        $this->assertEquals($expected, (string)$this->_response->getBody());
    }

    /**
     * Test add method
     *
     * @return void
     */
    public function test_プロフィール追加でバリデーションエラーをレスポンスすること(): void
    {
        // Arrange
        $requestData = [];
        $userId = '00676011-5447-4eb1-bde1-001880663af3';
        $expected = [
            'error' => [
                'message' => 'Bad Request',
                'errors' => [
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
                        'field' => 'sex',
                        'reason' => '必須項目が不足しています。',
                    ],
                ],
            ],
        ];

        $expected = json_encode($expected, JSON_PRETTY_PRINT);

        // Act
        $this->post("/api/v1/users/{$userId}/profiles", $requestData);

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
    public function test_プロフィール編集で編集したプロフィールをレスポンスすること(): void
    {
        // Arrange
        $id = 'c2e37627-ac0a-45e0-9dfd-eb5d703d8989';
        $userId = '00676011-5447-4eb1-bde1-001880663af3';
        $requestData = [
            'firstName' => '斉藤',
            'lastName' => '太郎',
            'firstNameKana' => 'サイトウ',
            'lastNameKana' => 'タロウ',
            'sex' => '1',
            'birthDay' => '1990-01-01',
            'cellPhoneNumber' => '09011111116',
            'remarks' => '斉藤メモ',
        ];

        $mockProfileUpdateUseCase = $this->createMock(ProfileUpdateUseCase::class);
        $mockProfileUpdateUseCase->expects($this->once())
            ->method('handle')
            ->will($this->returnValue(new ProfileId($id)));

        $this->overridePrivatePropertyWithMock('profileUpdateUseCase', $mockProfileUpdateUseCase);

        $expected = ['profileId' => $id];
        $expected = json_encode($expected, JSON_PRETTY_PRINT);

        // Act
        $this->put("/api/v1/users/{$userId}/profiles/{$id}", $requestData);

        // Assert
        // 正常にアクセスできること
        $this->assertResponseCode(200);
        // プロフィール情報を返却すること
        $this->assertEquals($expected, (string)$this->_response->getBody());
    }

    /**
     * Test edit method
     *
     * @return void
     */
    public function test_プロフィール編集でプロフィールが存在しないエラーを返すこと(): void
    {
        // Arrange
        $id = 'c2e37627-ac0a-45e0-9dfd-eb5d703d8989';
        $userId = '00676011-5447-4eb1-bde1-001880663af3';
        $requestData = [
            'firstName' => '斉藤',
            'lastName' => '太郎',
            'firstNameKana' => 'サイトウ',
            'lastNameKana' => 'タロウ',
            'sex' => '1',
            'birthDay' => '1990-01-01',
            'cellPhoneNumber' => '09011111116',
            'remarks' => '斉藤メモ',
        ];

        $mockProfileUpdateUseCase = $this->createMock(ProfileUpdateUseCase::class);
        $mockProfileUpdateUseCase->expects($this->once())
            ->method('handle')
            ->will($this->throwException(new RecordNotFoundException()));

        $this->overridePrivatePropertyWithMock('profileUpdateUseCase', $mockProfileUpdateUseCase);

        $expected = [
            'error' => [
                'message' => 'Not Found',
                'errors' => [
                    [
                        'field' => 'profileId',
                        'reason' => 'プロフィールは存在しません。',
                    ],
                ],
            ],
        ];

        $expected = json_encode($expected, JSON_PRETTY_PRINT);

        // Act
        $this->put("/api/v1/users/{$userId}/profiles/{$id}", $requestData);

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
    public function test_プロフィール編集でバリデーションエラーをレスポンスすること(): void
    {
        // Arrange
        $id = 'c2e37627-ac0a-45e0-9dfd-eb5d703d8989';
        $userId = '00676011-5447-4eb1-bde1-001880663af3';
        $requestData = [];
        $expected = [
            'error' => [
                'message' => 'Bad Request',
                'errors' => [
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
                        'field' => 'sex',
                        'reason' => '必須項目が不足しています。',
                    ],
                ],
            ],
        ];

        $expected = json_encode($expected, JSON_PRETTY_PRINT);

        // Act
        $this->put("/api/v1/users/{$userId}/profiles/{$id}", $requestData);

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
    public function test_プロフィール削除でエラーにならないこと(): void
    {
        // Arrange
        $id = 'c2e37627-ac0a-45e0-9dfd-eb5d703d8989';
        $userId = '00676011-5447-4eb1-bde1-001880663af3';
        $mockProfileDeleteUseCase = $this->createMock(ProfileDeleteUseCase::class);
        $mockProfileDeleteUseCase->expects($this->once())
            ->method('handle');

        $this->overridePrivatePropertyWithMock('profileDeleteUseCase', $mockProfileDeleteUseCase);

        // Act
        $this->delete("/api/v1/users/{$userId}/profiles/{$id}");

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
    public function test_プロフィール削除でプロフィールが存在しないエラーを返すこと(): void
    {
        // Arrange
        $id = 'c2e37627-ac0a-45e0-9dfd-eb5d703d8989';
        $userId = '00676011-5447-4eb1-bde1-001880663af3';
        $mockProfileDeleteUseCase = $this->createMock(ProfileDeleteUseCase::class);
        $mockProfileDeleteUseCase->expects($this->once())
            ->method('handle')
            ->will($this->throwException(new RecordNotFoundException()));

        $this->overridePrivatePropertyWithMock('profileDeleteUseCase', $mockProfileDeleteUseCase);

        $expected = [
            'error' => [
                'message' => 'Not Found',
                'errors' => [
                    [
                        'field' => 'profileId',
                        'reason' => 'プロフィールは存在しません。',
                    ],
                ],
            ],
        ];

        $expected = json_encode($expected, JSON_PRETTY_PRINT);

        // Act
        $this->delete("/api/v1/users/{$userId}/profiles/{$id}");

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
