<?php
declare(strict_types=1);

namespace App\UseCase\Files;

use App\Domain\Models\File\File;
use App\Domain\Models\File\IFileRepository;
use App\Domain\Models\File\IFileStorageRepository;
use App\Domain\Models\File\Type\ContentType;
use App\Domain\Models\File\Type\FileDirectory;
use App\Domain\Models\File\Type\FileName;
use App\Domain\Models\File\Type\FileSize;
use App\Domain\Models\File\Type\FileUrl;

/**
 * class FileUploadUseCase
 */
class FileUploadUseCase
{
    /**
     * constructor
     *
     * @param \App\Domain\Models\File\IFileRepository $fileRepository fileRepository
     * @param \App\Domain\Models\File\IFileStorageRepository $fileStorageRepository fileStorageRepository
     */
    public function __construct(
        private IFileRepository $fileRepository,
        private IFileStorageRepository $fileStorageRepository
    ) {
    }

    /**
     * ファイルをアップロードする
     *
     * @param \App\UseCase\Files\FileUploadCommand $command command
     * @return \App\Domain\Models\File\Type\FileUrl
     */
    public function handle(FileUploadCommand $command): FileUrl
    {
        $fileParam = $command->file;
        $fileId = $this->fileRepository->assignId();
        $directory = $this->fileStorageRepository->getDirectoryForUser($fileId);
        $this->fileStorageRepository->upload($fileParam, $directory);

        $fileName = new FileName((string)$fileParam->getClientFilename());
        $fileDirectory = new FileDirectory($directory);

        $this->fileRepository->save(
            File::create(
                $fileId,
                $fileName,
                new FileSize((int)$fileParam->getSize()),
                new ContentType((string)$fileParam->getClientMediaType()),
                $fileDirectory,
            )
        );

        return $this->fileStorageRepository->getUrl(
            $fileDirectory,
            $fileName,
        );
    }
}
