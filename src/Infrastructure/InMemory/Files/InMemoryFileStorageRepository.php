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
    public function getDirectoryForUser(): string
    {
        return 'path';
    }

    /**
     * @inheritDoc
     */
    public function upload(UploadedFile $file, FileId $fileId, string $directory): void
    {
    }
}
