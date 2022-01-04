<?php
declare(strict_types=1);

namespace App\Test\TestCase\Controller\Api\V1;

use App\Domain\Models\File\Type\FileUrl;
use App\UseCase\Files\FileUploadUseCase;
use Cake\Event\EventInterface;
use Cake\Event\EventManager;
use Cake\TestSuite\IntegrationTestTrait;
use Cake\TestSuite\TestCase;
use Laminas\Diactoros\UploadedFile;
use PHPUnit\Framework\MockObject\MockObject;
use ReflectionClass;

/**
 * App\Test\TestCase\Controller\Api\V1\FilesControllerTest Test Case
 *
 * @uses \App\Test\TestCase\Controller\Api\V1\FilesControllerTest
 */
class FilesControllerTest extends TestCase
{
    use IntegrationTestTrait;

    /**
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp();

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
     * Test upload method
     *
     * @return void
     */
    public function test_ファイルをアップロードすること(): void
    {
        // Arrange
        $requestData = [
            'file' => new UploadedFile(
                streamOrFile: 'file',
                size: 0,
                errorStatus: 0,
            ),
        ];

        $url = 'http://localhost/uploadFiles/Users/00676011-5447-4eb1-bde1-001880663af3/test.png';
        $mockFileUploadUseCase = $this->createMock(FileUploadUseCase::class);
        $mockFileUploadUseCase->expects($this->once())
            ->method('handle')
            ->will($this->returnValue(new FileUrl($url)));

        $this->overridePrivatePropertyWithMock('fileUploadUseCase', $mockFileUploadUseCase);

        $expected = ['url' => $url];
        $expected = json_encode($expected, JSON_PRETTY_PRINT);

        // Act
        $this->post('/api/v1/files', $requestData);

        // Assert
        // 正常にアクセスできること
        $this->assertResponseCode(200);
        // ユーザー情報を返却すること
        $this->assertEquals($expected, (string)$this->_response->getBody());
    }

    /**
     * Test upload method
     *
     * @return void
     */
    public function test_ファイルアップロードでバリデーションエラーをレスポンスすること(): void
    {
        // Arrange
        $requestData = [];
        $expected = [
            'error' => [
                'message' => 'Bad Request',
                'errors' => [
                    [
                        'field' => 'file',
                        'reason' => '必須項目が不足しています。',
                    ],
                ],
            ],
        ];

        $expected = json_encode($expected, JSON_PRETTY_PRINT);

        // Act
        $this->post('/api/v1/files', $requestData);

        // Assert
        // 400エラーになること
        $this->assertResponseCode(400);
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
        EventManager::instance()->on(
            'Controller.initialize',
            function (EventInterface $event) use ($propertyName, $mockObject) {
                $controller = $event->getSubject();
                $property = (new ReflectionClass($controller))->getProperty($propertyName);
                $property->setAccessible(true);
                $property->setValue($controller, $mockObject);
            }
        );
    }
}
