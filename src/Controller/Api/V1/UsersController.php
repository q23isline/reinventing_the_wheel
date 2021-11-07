<?php
declare(strict_types=1);

namespace App\Controller\Api\V1;

use App\Controller\AppController;
use App\Domain\Services\UserService;
use App\Domain\Shared\Exception\ExceptionItem;
use App\Domain\Shared\Exception\NotFoundException;
use App\Domain\Shared\Exception\ValidateException;
use App\Infrastructure\CakePHP\Users\CakePHPUserRepository;
use App\UseCase\Users\UserAddCommand;
use App\UseCase\Users\UserAddUseCase;
use App\UseCase\Users\UserDeleteCommand;
use App\UseCase\Users\UserDeleteUseCase;
use App\UseCase\Users\UserGetCommand;
use App\UseCase\Users\UserGetResult;
use App\UseCase\Users\UserGetUseCase;
use App\UseCase\Users\UserListCommand;
use App\UseCase\Users\UserListResult;
use App\UseCase\Users\UserListUseCase;
use App\UseCase\Users\UserSavedResult;
use App\UseCase\Users\UserUpdateCommand;
use App\UseCase\Users\UserUpdateUseCase;
use Cake\Datasource\Exception\RecordNotFoundException;

/**
 * Users Controller
 */
class UsersController extends AppController
{
    /**
     * @var \App\Infrastructure\CakePHP\Users\CakePHPUserRepository
     */
    private CakePHPUserRepository $userRepository;

    /**
     * @var \App\UseCase\Users\UserListUseCase
     */
    private UserListUseCase $userListUseCase;

    /**
     * @var \App\Domain\Services\UserService
     */
    private UserService $userService;

    /**
     * @var \App\UseCase\Users\UserAddUseCase
     */
    private UserAddUseCase $userAddUseCase;

    /**
     * @var \App\UseCase\Users\UserGetUseCase
     */
    private UserGetUseCase $userGetUseCase;

    /**
     * @var \App\UseCase\Users\UserUpdateUseCase
     */
    private UserUpdateUseCase $userUpdateUseCase;

    /**
     * @var \App\UseCase\Users\UserDeleteUseCase
     */
    private UserDeleteUseCase $userDeleteUseCase;

    /**
     * initialize
     *
     * @return void
     */
    public function initialize(): void
    {
        parent::initialize();

        // テスト時のモック用にプロパティのチェック
        $this->userRepository = $this->userRepository ?? new CakePHPUserRepository();
        $this->userListUseCase = $this->userListUseCase ?? new UserListUseCase($this->userRepository);
        $this->userService = $this->userService ?? new UserService($this->userRepository);
        $this->userAddUseCase = $this->userAddUseCase ?? new UserAddUseCase($this->userRepository, $this->userService);
        $this->userGetUseCase = $this->userGetUseCase ?? new UserGetUseCase($this->userRepository);
        $this->userUpdateUseCase =
            $this->userUpdateUseCase ?? new UserUpdateUseCase($this->userRepository, $this->userService);
        $this->userDeleteUseCase = $this->userDeleteUseCase ?? new UserDeleteUseCase($this->userRepository);
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
        $command = new UserListCommand($keyword);

        $userData = $this->userListUseCase->handle($command);
        $result = new UserListResult($userData);
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
        $userId = $this->request->getParam('userId');

        try {
            $command = new UserGetCommand($userId);

            $userData = $this->userGetUseCase->handle($command);
            $result = new UserGetResult($userData);
            $data = $result->format();

            $this->set($data);
            $this->viewBuilder()->setClassName('Json')
                ->setOption('serialize', ['data']);
        } catch (RecordNotFoundException $e) {
            $error = new NotFoundException([new ExceptionItem('userId', 'ユーザーは存在しません。')]);
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
            $command = new UserAddCommand(
                $jsonData['loginId'] ?? null,
                $jsonData['password'] ?? null,
                $jsonData['roleName'] ?? null,
                $jsonData['firstName'] ?? null,
                $jsonData['lastName'] ?? null,
                $jsonData['firstNameKana'] ?? null,
                $jsonData['lastNameKana'] ?? null,
                $jsonData['mailAddress'] ?? null,
                $jsonData['sex'] ?? null,
                $jsonData['birthDay'] ?? null,
                $jsonData['cellPhoneNumber'] ?? null,
                $jsonData['remarks'] ?? null,
            );

            $userId = $this->userAddUseCase->handle($command);
            $result = new UserSavedResult($userId);
            $data = $result->format();

            $this->set($data);
            $this->viewBuilder()->setClassName('Json')
                ->setOption('serialize', ['userId']);
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
        $userId = $this->request->getParam('userId');
        $jsonData = $this->request->getData();

        try {
            $command = new UserUpdateCommand(
                $userId,
                $jsonData['loginId'] ?? null,
                $jsonData['password'] ?? null,
                $jsonData['roleName'] ?? null,
                $jsonData['firstName'] ?? null,
                $jsonData['lastName'] ?? null,
                $jsonData['firstNameKana'] ?? null,
                $jsonData['lastNameKana'] ?? null,
                $jsonData['mailAddress'] ?? null,
                $jsonData['sex'] ?? null,
                $jsonData['birthDay'] ?? null,
                $jsonData['cellPhoneNumber'] ?? null,
                $jsonData['remarks'] ?? null,
            );

            $userId = $this->userUpdateUseCase->handle($command);
            $result = new UserSavedResult($userId);
            $data = $result->format();

            $this->set($data);
            $this->viewBuilder()->setClassName('Json')
                ->setOption('serialize', ['userId']);
        } catch (RecordNotFoundException $e) {
            $error = new NotFoundException([new ExceptionItem('userId', 'ユーザーは存在しません。')]);
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
        $userId = $this->request->getParam('userId');

        try {
            $command = new UserDeleteCommand($userId);
            $this->userDeleteUseCase->handle($command);

            $this->viewBuilder()->setClassName('Json')
                ->setOption('serialize', []);
        } catch (RecordNotFoundException $e) {
            $error = new NotFoundException([new ExceptionItem('userId', 'ユーザーは存在しません。')]);
            $data = $error->format();

            $this->response = $this->response->withStatus(404);
            $this->set($data);
            $this->viewBuilder()->setClassName('Json')
                ->setOption('serialize', ['error']);
        }
    }
}
