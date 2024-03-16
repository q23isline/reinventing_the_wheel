<?php
declare(strict_types=1);

namespace App\Test\TestCase\Infrastructure\CakePHP\Files;

use App\Domain\Models\File\File;
use App\Domain\Models\File\Type\ContentType;
use App\Domain\Models\File\Type\FileDirectory;
use App\Domain\Models\File\Type\FileId;
use App\Domain\Models\File\Type\FileName;
use App\Domain\Models\File\Type\FileSize;
use App\Infrastructure\CakePHP\Files\CakePHPFileRepository;
use Cake\TestSuite\IntegrationTestTrait;
use Cake\TestSuite\TestCase;

/**
 * App\Infrastructure\CakePHP\Files\CakePHPFileRepository Test Case
 *
 * @uses \App\Infrastructure\CakePHP\Files\CakePHPFileRepository
 */
final class CakePHPFileRepositoryTest extends TestCase
{
    use IntegrationTestTrait;

    /**
     * Fixtures
     *
     * @var list<string>
     */
    protected array $fixtures = [
        'app.Files',
    ];

    /**
     * @return void
     */
    public function test_UUIDを取得すること(): void
    {
        // UUID の正規表現パターン
        $expectFileIdPattern = '/^[0-9a-f]{8}-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{12}$/';

        // Act
        $fileId = (new CakePHPFileRepository())->assignId();

        // Assert
        $this->assertMatchesRegularExpression($expectFileIdPattern, $fileId->value);
    }

    /**
     * @return void
     */
    public function test_ファイル情報を保存すること(): void
    {
        // Arrange
        $fileId = '01509588-3882-42dd-9ab2-485e8e579a8e';
        $file = File::reconstruct(
            new FileId($fileId),
            new FileName('test.png'),
            new FileSize(1024),
            new ContentType('image/png'),
            new FileDirectory('uploadFiles/Users'),
        );

        // Act
        $actual = (new CakePHPFileRepository())->save($file);

        // Assert
        $this->assertEquals(new FileId($fileId), $actual);
    }
}
