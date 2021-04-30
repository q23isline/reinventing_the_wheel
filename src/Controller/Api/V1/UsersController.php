<?php
declare(strict_types=1);

namespace App\Controller\Api\V1;

use App\Controller\AppController;
use App\Infrastructure\CakePHP\Users\CakePHPUserRepository;
use App\UseCase\Users\UserListResult;
use App\UseCase\Users\UserListUseCaseService;

/**
 * Users Controller
 */
class UsersController extends AppController
{
    /**
     * Index method
     *
     * @return void
     */
    public function index(): void
    {
        $userRepository = new CakePHPUserRepository();
        $userListUseCaseService = new UserListUseCaseService($userRepository);
        $userData = $userListUseCaseService->handle();
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
