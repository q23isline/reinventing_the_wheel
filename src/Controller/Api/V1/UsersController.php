<?php
declare(strict_types=1);

namespace App\Controller\Api\V1;

use App\Controller\AppController;
use App\Domain\Services\UserService;
use App\Domain\Shared\Exception\NotFoundException;
use App\Domain\Shared\Exception\ValidateException;
use App\Infrastructure\CakePHP\Users\CakePHPUserRepository;
use App\UseCase\Users\UserAddCommand;
use App\UseCase\Users\UserAddUseCase;
use App\UseCase\Users\UserGetCommand;
use App\UseCase\Users\UserGetResult;
use App\UseCase\Users\UserGetUseCaseService;
use App\UseCase\Users\UserListResult;
use App\UseCase\Users\UserListUseCase;
use App\UseCase\Users\UserSavedResult;

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
     * @var \App\UseCase\Users\UserGetUseCaseService
     */
    private UserGetUseCaseService $userGetUseCaseService;

    /**
     * initialize
     *
     * @return void
     */
    public function initialize(): void
    {
        parent::initialize();

        $this->userRepository = new CakePHPUserRepository();
        $this->userListUseCase = new UserListUseCase($this->userRepository);
        $this->userService = new UserService($this->userRepository);
        $this->userAddUseCase = new UserAddUseCase($this->userRepository, $this->userService);
        $this->userGetUseCaseService = new UserGetUseCaseService($this->userRepository);
    }

    /**
     * Index method
     *
     * @return void
     */
    public function index(): void
    {
        $userData = $this->userListUseCase->handle();
        $result = new UserListResult($userData);
        $data = $result->format();

        $this->set($data);
        // .jsonなしでもOKとする
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
        $userId = (int)$this->request->getParam('userId');

        try {
            $command = new UserGetCommand($userId);

            $userData = $this->userGetUseCaseService->handle($command);
            $result = new UserGetResult($userData);
            $data = $result->format();

            $this->set($data);
            // .jsonなしでもOKとする
            $this->viewBuilder()->setClassName('Json')
                ->setOption('serialize', ['data']);
        } catch (NotFoundException $e) {
            $data = $e->format();

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
        // スマートに JSON から値を取り出せないため、長いけど…
        $jsonData = $this->request->input('json_decode');

        $loginId = null;
        $password = null;
        $roleName = null;
        $firstName = null;
        $lastName = null;

        if (!is_null($jsonData)) {
            if (property_exists($jsonData, 'loginId')) {
                $loginId = $jsonData->loginId;
            }

            if (property_exists($jsonData, 'password')) {
                $password = $jsonData->password;
            }

            if (property_exists($jsonData, 'roleName')) {
                $roleName = $jsonData->roleName;
            }

            if (property_exists($jsonData, 'firstName')) {
                $firstName = $jsonData->firstName;
            }

            if (property_exists($jsonData, 'lastName')) {
                $lastName = $jsonData->lastName;
            }
        }

        try {
            $command = new UserAddCommand(
                $loginId,
                $password,
                $roleName,
                $firstName,
                $lastName
            );

            $userId = $this->userAddUseCase->handle($command);
            $result = new UserSavedResult($userId);
            $data = $result->format();

            $this->set($data);
            // .jsonなしでもOKとする
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

        $jsonData = $this->request->input('json_decode');

        $loginId = null;
        $password = null;
        $roleName = null;
        $firstName = null;
        $lastName = null;

        if (!is_null($jsonData)) {
            if (property_exists($jsonData, 'loginId')) {
                $loginId = $jsonData->loginId;
            }

            if (property_exists($jsonData, 'password')) {
                $password = $jsonData->password;
            }

            if (property_exists($jsonData, 'roleName')) {
                $roleName = $jsonData->roleName;
            }

            if (property_exists($jsonData, 'firstName')) {
                $firstName = $jsonData->firstName;
            }

            if (property_exists($jsonData, 'lastName')) {
                $lastName = $jsonData->lastName;
            }
        }

        $dataParams = [
            'loginId' => $loginId,
            'password' => $password,
            'roleName' => $roleName,
            'firstName' => $firstName,
            'lastName' => $lastName,
        ];

        // TODO: モックAPIを修正する
        $data = [
            'userId' => 1,
        ];

        $this->set($data);
        // .jsonなしでもOKとする
        $this->viewBuilder()->setClassName('Json')
            ->setOption('serialize', ['userId']);
    }

    /**
     * Delete method
     *
     * @return void
     */
    public function delete(): void
    {
        $userId = $this->request->getParam('userId');

        // TODO: モックAPIを修正する

        // .jsonなしでもOKとする
        $this->viewBuilder()->setClassName('Json')
            ->setOption('serialize', []);
    }
}
