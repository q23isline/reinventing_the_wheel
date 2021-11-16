<?php
declare(strict_types=1);

namespace App\Test\TestCase\Infrastructure\CakePHP\Files;

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
        $expectPathForUser = 'uploadFiles/Users';

        // Act
        $pathForUser = (new CakePHPFileStorageRepository())->getDirectoryForUser();

        // Assert
        $this->assertEquals($expectPathForUser, $pathForUser);
    }
}
