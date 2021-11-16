<?php
declare(strict_types=1);

namespace App\Test\TestCase\UseCase\Files;

use App\Infrastructure\InMemory\Files\InMemoryFileRepository;
use App\Infrastructure\InMemory\Files\InMemoryFileStorageRepository;
use App\UseCase\Files\FileUploadCommand;
use App\UseCase\Files\FileUploadUseCase;
use Cake\TestSuite\TestCase;
use Laminas\Diactoros\UploadedFile;

/**
 * App\UseCase\Files\FileUploadUseCase Test Case
 *
 * @uses \App\UseCase\Files\FileUploadUseCase
 */
final class FileUploadUseCaseTest extends TestCase
{
    /**
     * Test handle method
     *
     * @return void
     */
    public function test_ファイルが登録されること(): void
    {
        // Arrange
        $fileRepository = new InMemoryFileRepository();
        $fileStorageRepository = new InMemoryFileStorageRepository();
        $fileUploadUseCase = new FileUploadUseCase($fileRepository, $fileStorageRepository);

        $inputData = new FileUploadCommand(
            new UploadedFile(
                streamOrFile: 'file',
                size: 0,
                errorStatus: 0,
            )
        );

        // Act
        $fileUploadUseCase->handle($inputData);

        // Assert
        // ファイルが正しく保存されているか
        $this->assertNotEmpty($fileRepository->store);
    }
}
