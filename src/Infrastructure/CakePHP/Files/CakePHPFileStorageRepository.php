<?php
declare(strict_types=1);

namespace App\Infrastructure\CakePHP\Files;

use App\Domain\Models\File\IFileStorageRepository;
use App\Domain\Models\File\Type\FileDirectory;
use App\Domain\Models\File\Type\FileId;
use App\Domain\Models\File\Type\FileName;
use App\Domain\Models\File\Type\FileUrl;
use Cake\Core\Configure;
use Laminas\Diactoros\UploadedFile;

/**
 * class CakePHPFileStorageRepository
 */
final class CakePHPFileStorageRepository implements IFileStorageRepository
{
    /**
     * @inheritDoc
     */
    public function getUrl(FileDirectory $fileDirectory, FileName $fileName): FileUrl
    {
        $fullBaseUrl = Configure::read('App.fullBaseUrl');

        return new FileUrl(
            "{$fullBaseUrl}/{$fileDirectory->value}/{$fileName->value}"
        );
    }

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
