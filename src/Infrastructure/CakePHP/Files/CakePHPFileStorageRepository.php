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
    public function getDirectoryForUser(): string
    {
        return 'uploadFiles/Users';
    }

    /**
     * @inheritDoc
     */
    public function upload(UploadedFile $file, FileId $fileId, string $directory): void
    {
        $targetDirectory = WWW_ROOT . $directory . '/' . $fileId->getValue();
        $targetPath = $targetDirectory . '/' . $file->getClientFilename();

        // Folder API にならって 755 権限
        // <https://book.cakephp.org/4/ja/core-libraries/file-folder.html#folder-api>
        mkdir($targetDirectory, 0755, true);

        $file->moveTo($targetPath);
    }
}
