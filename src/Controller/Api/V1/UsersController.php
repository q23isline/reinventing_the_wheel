<?php
declare(strict_types=1);

namespace App\Controller\Api\V1;

use App\Controller\AppController;
use App\Domain\Services\UserService;
use App\Domain\Shared\Exception\ValidateException;
use App\Infrastructure\CakePHP\Users\CakePHPUserRepository;
use App\UseCase\Users\UserAddCommand;
use App\UseCase\Users\UserAddUseCaseService;
use App\UseCase\Users\UserGetResult;
use App\UseCase\Users\UserListResult;
use App\UseCase\Users\UserListUseCaseService;
use Exception;

/**
 * Users Controller
 */
class UsersController extends AppController
{
    /**
     * @var CakePHPUserRepository
     */
    private CakePHPUserRepository $userRepository;

    /**
     * @var UserListUseCaseService
     */
    private UserListUseCaseService $userListUseCaseService;

    /**
     * @var UserService
     */
    private UserService $userService;

    /**
     * @var UserAddUseCaseService
     */
    private UserAddUseCaseService $userAddUseCaseService;

    /**
     * initialize
     *
     * @return void
     */
    public function initialize(): void
    {
        parent::initialize();

        $this->userRepository = new CakePHPUserRepository();
        $this->userListUseCaseService = new UserListUseCaseService($this->userRepository);
        $this->userService = new UserService($this->userRepository);
        $this->userAddUseCaseService = new UserAddUseCaseService($this->userRepository, $this->userService);
    }

    /**
     * Index method
     *
     * @return void
     */
    public function index(): void
    {
        $userData = $this->userListUseCaseService->handle();
        $userListResult = new UserListResult($userData);
        $data = $userListResult->format();

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
        $userId = $this->request->getParam('userId');

        // TODO: モックAPIを修正する
        $data = [
            'data' => [
                'id' => 1,
                'loginId' => 'saitou',
                'roleName' => 'viewer',
                'firstName' => '斉藤',
                'lastName' => '太郎',
                'created' => '2019-08-24T14:15:22Z',
                'modified' => '2019-08-24T14:15:22Z',
            ],
        ];

        $this->set($data);
        // .jsonなしでもOKとする
        $this->viewBuilder()->setClassName('Json')
            ->setOption('serialize', ['data']);
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

            $userData = $this->userAddUseCaseService->handle($command);
            $userGetResult = new UserGetResult($userData);
            $data = $userGetResult->format();

            $this->set($data);
            // .jsonなしでもOKとする
            $this->viewBuilder()->setClassName('Json')
                ->setOption('serialize', ['data']);
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
            'data' => [
                'id' => 1,
                'loginId' => 'saitou',
                'roleName' => 'viewer',
                'firstName' => '斉藤',
                'lastName' => '太郎',
                'created' => '2019-08-24T14:15:22Z',
                'modified' => '2019-08-24T14:15:22Z',
            ],
        ];

        $this->set($data);
        // .jsonなしでもOKとする
        $this->viewBuilder()->setClassName('Json')
            ->setOption('serialize', ['data']);
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
