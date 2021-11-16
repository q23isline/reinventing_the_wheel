<?php
declare(strict_types=1);

namespace App\Test\TestCase\Domain\Models\File;

use App\Domain\Models\File\File;
use App\Domain\Models\File\Type\ContentType;
use App\Domain\Models\File\Type\FileDirectory;
use App\Domain\Models\File\Type\FileId;
use App\Domain\Models\File\Type\FileName;
use App\Domain\Models\File\Type\FileSize;
use Cake\TestSuite\TestCase;

/**
 * App\Domain\Models\File\File Test Case
 *
 * @uses \App\Domain\Models\File\File
 */
final class FileTest extends TestCase
{
    /**
     * @return void
     */
    public function test_ファイルインスタンスが作成されること(): void
    {
        // Arrange
        $id = new FileId('01509588-3882-42dd-9ab2-485e8e579a8e');
        $fileName = new FileName('test.png');
        $fileSize = new FileSize(1024);
        $contentType = new ContentType('image/png');
        $fileDirectory = new FileDirectory('uploadFiles/Users');

        // Act
        $file = File::create(
            $id,
            $fileName,
            $fileSize,
            $contentType,
            $fileDirectory,
        );

        // Assert
        $this->assertEquals($id, $file->getId());
        $this->assertEquals($fileName, $file->getFileName());
        $this->assertEquals($fileSize, $file->getFileSize());
        $this->assertEquals($contentType, $file->getContentType());
        $this->assertEquals($fileDirectory, $file->getFileDirectory());
    }

    /**
     * @return void
     */
    public function test_ファイルインスタンスが再構成されること(): void
    {
        // Arrange
        $id = new FileId('01509588-3882-42dd-9ab2-485e8e579a8e');
        $fileName = new FileName('test.png');
        $fileSize = new FileSize(1024);
        $contentType = new ContentType('image/png');
        $fileDirectory = new FileDirectory('uploadFiles/Users');

        // Act
        $file = File::reconstruct(
            $id,
            $fileName,
            $fileSize,
            $contentType,
            $fileDirectory,
        );

        // Assert
        $this->assertEquals($id, $file->getId());
        $this->assertEquals($fileName, $file->getFileName());
        $this->assertEquals($fileSize, $file->getFileSize());
        $this->assertEquals($contentType, $file->getContentType());
        $this->assertEquals($fileDirectory, $file->getFileDirectory());
    }
}
