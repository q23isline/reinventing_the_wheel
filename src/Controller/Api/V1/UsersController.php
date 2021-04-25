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
}
