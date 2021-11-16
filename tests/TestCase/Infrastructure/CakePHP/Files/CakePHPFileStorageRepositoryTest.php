<?php
declare(strict_types=1);

namespace App\Test\TestCase\Infrastructure\CakePHP\Files;

use App\Domain\Models\File\Type\FileId;
use App\Infrastructure\CakePHP\Files\CakePHPFileStorageRepository;
use Cake\TestSuite\TestCase;

/**
 * App\Infrastructure\CakePHP\Files\CakePHPFileStorageRepository Test Case
 *
 * @uses \App\Infrastructure\CakePHP\Files\CakePHPFileStorageRepository
 */
class CakePHPFileStorageRepositoryTest extends TestCase
{
    /**
     * @return void
     */
    public function test_ユーザー用のファイル保存パスを取得すること(): void
    {
        // Arrange
        $fileId = '01509588-3882-42dd-9ab2-485e8e579a8e';
        $expectPathForUser = "uploadFiles/Users/{$fileId}";

        // Act
        $pathForUser = (new CakePHPFileStorageRepository())->getDirectoryForUser(new FileId($fileId));

        // Assert
        $this->assertEquals($expectPathForUser, $pathForUser);
    }
}
