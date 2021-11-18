<?php
declare(strict_types=1);

namespace App\Infrastructure\InMemory\Files;

use App\Domain\Models\File\IFileStorageRepository;
use App\Domain\Models\File\Type\FileDirectory;
use App\Domain\Models\File\Type\FileId;
use App\Domain\Models\File\Type\FileName;
use App\Domain\Models\File\Type\FileUrl;
use Laminas\Diactoros\UploadedFile;

/**
 * class InMemoryFileStorageRepository
 */
final class InMemoryFileStorageRepository implements IFileStorageRepository
{
    /**
     * @inheritDoc
     */
    public function getUrl(FileDirectory $fileDirectory, FileId $fileId, FileName $fileName): FileUrl
    {
        $url = "{$_SERVER['SERVER_NAME']}/{$fileDirectory->value}/{$fileId->value}/{$fileName->value}";

        return new FileUrl($url);
    }

    /**
     * @inheritDoc
     */
    public function getDirectoryForUser(FileId $fileId): string
    {
        return "path/{$fileId->value}";
    }

    /**
     * @inheritDoc
     */
    public function upload(UploadedFile $file, string $directory): void
    {
    }
}
