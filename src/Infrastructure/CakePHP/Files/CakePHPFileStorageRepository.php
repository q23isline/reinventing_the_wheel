<?php
declare(strict_types=1);

namespace App\Infrastructure\CakePHP\Files;

use App\Domain\Models\File\IFileStorageRepository;
use App\Domain\Models\File\Type\FileId;
use Laminas\Diactoros\UploadedFile;

/**
 * class CakePHPFileStorageRepository
 */
final class CakePHPFileStorageRepository implements IFileStorageRepository
{
    /**
     * @inheritDoc
     */
    public function getDirectoryForUser(FileId $fileId): string
    {
        return "uploadFiles/Users/{$fileId->value}";
    }

    /**
     * @inheritDoc
     */
    public function upload(UploadedFile $file, string $directory): void
    {
        $targetDirectory = WWW_ROOT . $directory;
        $targetPath = $targetDirectory . '/' . $file->getClientFilename();

        // Folder API にならって 755 権限
        // <https://book.cakephp.org/4/ja/core-libraries/file-folder.html#folder-api>
        mkdir($targetDirectory, 0755, true);

        $file->moveTo($targetPath);
    }
}
