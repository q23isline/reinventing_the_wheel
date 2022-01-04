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
    private CakePHPFileRepository $fileRepository;
    private CakePHPFileStorageRepository $fileStorageRepository;
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
            // UploadedFile クラスを利用しない実装をしたかったが、tmp 保存パスが private で取得できないため、このまま進める
            $command = new FileUploadCommand(
                $jsonData['file'] ?? null,
            );

            $fileUrl = $this->fileUploadUseCase->handle($command);
            $result = new FileSavedResult($fileUrl);
            $data = $result->format();

            $this->set($data);
            $this->viewBuilder()->setClassName('Json')
                ->setOption('serialize', ['url']);
        } catch (ValidateException $e) {
            $data = $e->format();

            $this->response = $this->response->withStatus(400);
            $this->set($data);
            $this->viewBuilder()->setClassName('Json')
                ->setOption('serialize', ['error']);
        }
    }
}
