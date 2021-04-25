<?php
declare(strict_types=1);

namespace App\Controller\Api\V1;

use App\Controller\AppController;

/**
 * Users Controller
 */
class UsersController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders json
     */
    public function index()
    {
        // TODO: モックAPIを修正する
        $data = [
            'data' => [
                [
                    'id' => 1,
                    'loginId' => 'saitou',
                    'roleName' => 'viewer',
                    'firstName' => '斉藤',
                    'lastName' => '太郎',
                    'created' => '2019-08-24T14:15:22Z',
                    'modified' => '2019-08-24T14:15:22Z',
                ],
            ],
        ];

        $this->set($data);
        // .jsonなしでもOKとする
        $this->viewBuilder()->setClassName('Json')
            ->setOption('serialize', ['data']);
    }

    /**
     * View method
     *
     * @return \Cake\Http\Response|null|void Renders json
     */
    public function view()
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
     * @return \Cake\Http\Response|null|void Renders json
     */
    public function add()
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
}
