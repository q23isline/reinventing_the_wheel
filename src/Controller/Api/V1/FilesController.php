<?php
declare(strict_types=1);

namespace App\Controller\Api\V1;

use App\Controller\AppController;
use App\Domain\Shared\Exception\ValidateException;
use App\Infrastructure\CakePHP\Files\CakePHPFileRepository;
use App\Infrastructure\CakePHP\Files\CakePHPFileStorageRepository;
use App\UseCase\Files\FileSavedResult;
use App\UseCase\Files\FileUploadCommand;
use App\UseCase\Files\FileUploadUseCase;

/**
 * Files Controller
 */
class FilesController extends AppController
{
    /**
     * @var \App\Infrastructure\CakePHP\Files\CakePHPFileRepository
     */
    private CakePHPFileRepository $fileRepository;

    /**
     * @var \App\Infrastructure\CakePHP\Files\CakePHPFileStorageRepository
     */
    private CakePHPFileStorageRepository $fileStorageRepository;

    /**
     * @var \App\UseCase\Files\FileUploadUseCase
     */
    private FileUploadUseCase $fileUploadUseCase;

    /**
     * initialize
     *
     * @return void
     */
    public function initialize(): void
    {
        parent::initialize();

        $this->fileRepository = $this->fileRepository ?? new CakePHPFileRepository();
        $this->fileStorageRepository = $this->fileStorageRepository ?? new CakePHPFileStorageRepository();
        $this->fileUploadUseCase =
            $this->fileUploadUseCase ?? new FileUploadUseCase($this->fileRepository, $this->fileStorageRepository);
    }

    /**
     * Upload method
     *
     * @return void
     */
    public function upload(): void
    {
        $jsonData = $this->request->getData();

        try {
            $command = new FileUploadCommand(
                $jsonData['file'] ?? null,
            );

            $fileId = $this->fileUploadUseCase->handle($command);
            $result = new FileSavedResult($fileId);
            $data = $result->format();

            $this->set($data);
            $this->viewBuilder()->setClassName('Json')
                ->setOption('serialize', ['fileId']);
        } catch (ValidateException $e) {
            $data = $e->format();

            $this->response = $this->response->withStatus(400);
            $this->set($data);
            $this->viewBuilder()->setClassName('Json')
                ->setOption('serialize', ['error']);
        }
    }
}