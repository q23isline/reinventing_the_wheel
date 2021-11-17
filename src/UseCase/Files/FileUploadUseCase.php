<?php
declare(strict_types=1);

namespace App\UseCase\Files;

use App\Domain\Models\File\File;
use App\Domain\Models\File\IFileRepository;
use App\Domain\Models\File\IFileStorageRepository;
use App\Domain\Models\File\Type\ContentType;
use App\Domain\Models\File\Type\FileDirectory;
use App\Domain\Models\File\Type\FileId;
use App\Domain\Models\File\Type\FileName;
use App\Domain\Models\File\Type\FileSize;

/**
 * class FileUploadUseCase
 *
 * @property-read \App\Domain\Models\File\IFileRepository $fileRepository fileRepository
 * @property-read \App\Domain\Models\File\IFileStorageRepository $fileStorageRepository fileStorageRepository
 */
class FileUploadUseCase
{
    private IFileRepository $fileRepository;
    private IFileStorageRepository $fileStorageRepository;

    /**
     * constructor
     *
     * @param \App\Domain\Models\File\IFileRepository $fileRepository fileRepository
     * @param \App\Domain\Models\File\IFileStorageRepository $fileStorageRepository fileStorageRepository
     */
    public function __construct(IFileRepository $fileRepository, IFileStorageRepository $fileStorageRepository)
    {
        $this->fileRepository = $fileRepository;
        $this->fileStorageRepository = $fileStorageRepository;
    }

    /**
     * ファイルをアップロードする
     *
     * @param \App\UseCase\Files\FileUploadCommand $command command
     * @return \App\Domain\Models\File\Type\FileId
     */
    public function handle(FileUploadCommand $command): FileId
    {
        $fileParam = $command->getFile();
        $fileId = $this->fileRepository->assignId();
        $directory = $this->fileStorageRepository->getDirectoryForUser($fileId);
        $this->fileStorageRepository->upload($fileParam, $directory);

        $data = File::create(
            $fileId,
            new FileName((string)$fileParam->getClientFilename()),
            new FileSize((int)$fileParam->getSize()),
            new ContentType((string)$fileParam->getClientMediaType()),
            new FileDirectory($directory),
        );

        return $this->fileRepository->save($data);
    }
}
