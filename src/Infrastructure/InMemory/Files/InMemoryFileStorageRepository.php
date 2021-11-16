<?php
declare(strict_types=1);

namespace App\Infrastructure\InMemory\Files;

use App\Domain\Models\File\IFileStorageRepository;
use App\Domain\Models\File\Type\FileId;
use Laminas\Diactoros\UploadedFile;

/**
 * class InMemoryFileStorageRepository
 */
class InMemoryFileStorageRepository implements IFileStorageRepository
{
    /**
     * @inheritDoc
     */
    public function getDirectoryForUser(FileId $fileId): string
    {
        return "path/{$fileId->getValue()}";
    }

    /**
     * @inheritDoc
     */
    public function upload(UploadedFile $file, string $directory): void
    {
    }
}
