<?php
declare(strict_types=1);

namespace App\Controller\Api\V1;

use App\Controller\AppController;
use App\Domain\Shared\Exception\ExceptionItem;
use App\Domain\Shared\Exception\NotFoundException;
use App\Domain\Shared\Exception\ValidateException;
use App\Infrastructure\CakePHP\Files\CakePHPFileRepository;
use App\Infrastructure\CakePHP\Files\CakePHPFileStorageRepository;
use App\Infrastructure\CakePHP\Profiles\CakePHPProfileRepository;
use App\UseCase\Profiles\ProfileAddCommand;
use App\UseCase\Profiles\ProfileAddUseCase;
use App\UseCase\Profiles\ProfileDeleteCommand;
use App\UseCase\Profiles\ProfileDeleteUseCase;
use App\UseCase\Profiles\ProfileGetCommand;
use App\UseCase\Profiles\ProfileGetResult;
use App\UseCase\Profiles\ProfileGetUseCase;
use App\UseCase\Profiles\ProfileListCommand;
use App\UseCase\Profiles\ProfileListResult;
use App\UseCase\Profiles\ProfileListUseCase;
use App\UseCase\Profiles\ProfileSavedResult;
use App\UseCase\Profiles\ProfileUpdateCommand;
use App\UseCase\Profiles\ProfileUpdateUseCase;
use Cake\Datasource\Exception\RecordNotFoundException;

/**
 * Profiles Controller
 */
class ProfilesController extends AppController
{
    private CakePHPProfileRepository $profileRepository;
    private CakePHPFileRepository $fileRepository;
    private CakePHPFileStorageRepository $fileStorageRepository;
    private ProfileListUseCase $profileListUseCase;
    private ProfileAddUseCase $profileAddUseCase;
    private ProfileGetUseCase $profileGetUseCase;
    private ProfileUpdateUseCase $profileUpdateUseCase;
    private ProfileDeleteUseCase $profileDeleteUseCase;

    /**
     * initialize
     *
     * @return void
     */
    public function initialize(): void
    {
        parent::initialize();

        // テスト時のモック用にプロパティのチェック
        $this->profileRepository = $this->profileRepository ?? new CakePHPProfileRepository();
        $this->fileRepository = $this->fileRepository ?? new CakePHPFileRepository();
        $this->fileStorageRepository = $this->fileStorageRepository ?? new CakePHPFileStorageRepository();
        $this->profileListUseCase = $this->profileListUseCase ?? new ProfileListUseCase($this->profileRepository);
        $this->profileAddUseCase =
            $this->profileAddUseCase ?? new ProfileAddUseCase(
                $this->profileRepository,
                $this->fileRepository,
                $this->fileStorageRepository,
            );
        $this->profileGetUseCase = $this->profileGetUseCase ?? new ProfileGetUseCase($this->profileRepository);
        $this->profileUpdateUseCase = $this->profileUpdateUseCase ?? new ProfileUpdateUseCase($this->profileRepository);
        $this->profileDeleteUseCase = $this->profileDeleteUseCase ?? new ProfileDeleteUseCase($this->profileRepository);
    }

    /**
     * Index method
     *
     * @return void
     */
    public function index(): void
    {
        $params = $this->request->getQueryParams();
        $keyword = $params['q'] ?? null;
        $command = new ProfileListCommand($keyword);

        $profileData = $this->profileListUseCase->handle($command);
        $result = new ProfileListResult($profileData);
        $data = $result->format();

        $this->set($data);
        $this->viewBuilder()->setClassName('Json')
            ->setOption('serialize', ['data']);
    }

    /**
     * View method
     *
     * @return void
     */
    public function view(): void
    {
        $profileId = $this->request->getParam('profileId');

        try {
            $command = new ProfileGetCommand($profileId);

            // TODO: userId と profileId の組み合わせ存在チェックをする
            $profileData = $this->profileGetUseCase->handle($command);
            $result = new ProfileGetResult($profileData);
            $data = $result->format();

            $this->set($data);
            $this->viewBuilder()->setClassName('Json')
                ->setOption('serialize', ['data']);
        } catch (RecordNotFoundException $e) {
            $error = new NotFoundException([new ExceptionItem('profileId', 'プロフィールは存在しません。')]);
            $data = $error->format();

            $this->response = $this->response->withStatus(404);
            $this->set($data);
            $this->viewBuilder()->setClassName('Json')
                ->setOption('serialize', ['error']);
        }
    }

    /**
     * Add method
     *
     * @return void
     */
    public function add(): void
    {
        $jsonData = $this->request->getData();

        try {
            $command = new ProfileAddCommand(
                $this->request->getParam('userId'),
                $jsonData['firstName'] ?? null,
                $jsonData['lastName'] ?? null,
                $jsonData['firstNameKana'] ?? null,
                $jsonData['lastNameKana'] ?? null,
                $jsonData['sex'] ?? null,
                $jsonData['birthDay'] ?? null,
                $jsonData['cellPhoneNumber'] ?? null,
                $jsonData['remarks'] ?? null,
                $jsonData['profileImageFileId'] ?? null,
            );

            // TODO: userId の存在チェック＆プロフィール未登録チェックをする
            $profileId = $this->profileAddUseCase->handle($command);
            $result = new ProfileSavedResult($profileId);
            $data = $result->format();

            $this->set($data);
            $this->viewBuilder()->setClassName('Json')
                ->setOption('serialize', ['profileId']);
        } catch (ValidateException $e) {
            $data = $e->format();

            $this->response = $this->response->withStatus(400);
            $this->set($data);
            $this->viewBuilder()->setClassName('Json')
                ->setOption('serialize', ['error']);
        }
    }

    /**
     * Edit method
     *
     * @return void
     */
    public function edit(): void
    {
        $profileId = $this->request->getParam('profileId');
        $jsonData = $this->request->getData();

        try {
            $command = new ProfileUpdateCommand(
                $profileId,
                $jsonData['firstName'] ?? null,
                $jsonData['lastName'] ?? null,
                $jsonData['firstNameKana'] ?? null,
                $jsonData['lastNameKana'] ?? null,
                $jsonData['sex'] ?? null,
                $jsonData['birthDay'] ?? null,
                $jsonData['cellPhoneNumber'] ?? null,
                $jsonData['remarks'] ?? null,
            );

            // TODO: userId と profileId の組み合わせ存在チェックをする
            $profileId = $this->profileUpdateUseCase->handle($command);
            $result = new ProfileSavedResult($profileId);
            $data = $result->format();

            $this->set($data);
            $this->viewBuilder()->setClassName('Json')
                ->setOption('serialize', ['profileId']);
        } catch (RecordNotFoundException $e) {
            $error = new NotFoundException([new ExceptionItem('profileId', 'プロフィールは存在しません。')]);
            $data = $error->format();

            $this->response = $this->response->withStatus(404);
            $this->set($data);
            $this->viewBuilder()->setClassName('Json')
                ->setOption('serialize', ['error']);
        } catch (ValidateException $e) {
            $data = $e->format();

            $this->response = $this->response->withStatus(400);
            $this->set($data);
            $this->viewBuilder()->setClassName('Json')
                ->setOption('serialize', ['error']);
        }
    }

    /**
     * Delete method
     *
     * @return void
     */
    public function delete(): void
    {
        $profileId = $this->request->getParam('profileId');

        try {
            $command = new ProfileDeleteCommand($profileId);
            // TODO: userId と profileId の組み合わせ存在チェックをする
            $this->profileDeleteUseCase->handle($command);

            $this->viewBuilder()->setClassName('Json')
                ->setOption('serialize', []);
        } catch (RecordNotFoundException $e) {
            $error = new NotFoundException([new ExceptionItem('profileId', 'プロフィールは存在しません。')]);
            $data = $error->format();

            $this->response = $this->response->withStatus(404);
            $this->set($data);
            $this->viewBuilder()->setClassName('Json')
                ->setOption('serialize', ['error']);
        }
    }
}
