<?php
declare(strict_types=1);

namespace App\Test\TestCase\Infrastructure\CakePHP\Files;

use App\Domain\Models\File\Type\FileId;
use App\Infrastructure\CakePHP\Files\CakePHPFileStorageRepository;
use Cake\TestSuite\TestCase;
use Laminas\Diactoros\UploadedFile;
use const UPLOAD_ERR_OK;

/**
 * App\Infrastructure\CakePHP\Files\CakePHPFileStorageRepository Test Case
 *
 * @uses \App\Infrastructure\CakePHP\Files\CakePHPFileStorageRepository
 */
final class CakePHPFileStorageRepositoryTest extends TestCase
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

    /**
     * @return void
     */
    public function test_ファイルをアップロードできること(): void
    {
        // Arrange
        $fileName = 'teaser.jpg';
        $directory = 'uploadFiles/Users/01509588-3882-42dd-9ab2-485e8e579a8e';
        $tempFileDirectory = 'path/to/test';
        $tempFileName = 'file.jpg';
        // <https://book.cakephp.org/4/ja/development/testing.html#id35>
        $file = new UploadedFile(
            TMP . "/{$tempFileDirectory}/{$tempFileName}",
            12345,
            UPLOAD_ERR_OK,
            $fileName,
            'image/jpeg'
        );

        if (!is_dir(TMP . "/{$tempFileDirectory}")) {
            // 一時ファイル用のファイル作成
            mkdir(TMP . "/{$tempFileDirectory}", 0755, true);
            touch(TMP . "/{$tempFileDirectory}/{$tempFileName}");
        }

        if (is_dir(WWW_ROOT . "{$directory}")) {
            // すでに期待値のファイルができていれば削除しておく
            unlink(WWW_ROOT . "{$directory}/{$fileName}");
            rmdir(WWW_ROOT . "{$directory}");
        }

        // Act
        (new CakePHPFileStorageRepository())->upload($file, $directory);

        // // Assert
        $this->assertFileExists(WWW_ROOT . "{$directory}/{$fileName}");

        // 元の状態（削除）にしておく
        // 一時ファイル自体は自動で削除される
        rmdir(TMP . "/{$tempFileDirectory}");
        rmdir(TMP . '/path/to');
        rmdir(TMP . '/path');
        unlink(WWW_ROOT . "{$directory}/{$fileName}");
        rmdir(WWW_ROOT . "{$directory}");
    }
}
