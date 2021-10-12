<?php
declare(strict_types=1);

/**
 * CakePHP(tm) : Rapid Development Framework (https://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 * @link      https://cakephp.org CakePHP(tm) Project
 * @since     0.2.9
 * @license   https://opensource.org/licenses/mit-license.php MIT License
 */
namespace App\Controller;

use Cake\Controller\Controller;

/**
 * Application Controller
 *
 * Add your application-wide methods in the class below, your controllers
 * will inherit them.
 *
 * @link https://book.cakephp.org/4/en/controllers.html#the-app-controller
 */
class AppController extends Controller
{
    /**
     * Initialization hook method.
     *
     * Use this method to add common initialization code like loading components.
     *
     * e.g. `$this->loadComponent('FormProtection');`
     *
     * @return void
     */
    public function initialize(): void
    {
        parent::initialize();

        $this->loadComponent('RequestHandler');
        $this->loadComponent('Flash');

        $this->loadComponent('Auth', [
            // controllerのisAuthorized()メソッドを呼ばせる
            'authorize' => 'Controller',

            'loginAction' => [
                'controller' => 'Users',
                'action' => 'login',
                // プレフィックス無しの UsersController->index() を参照させるため
                'prefix' => false,
            ],
            'loginRedirect' => [
                'controller' => 'Users',
                'action' => 'index',
                // プレフィックス無しの UsersController->index() を参照させるため
                'prefix' => false,
            ],
            'logoutRedirect' => [
                'controller' => 'Users',
                'action' => 'login',
                // プレフィックス無しの UsersController->index() を参照させるため
                'prefix' => false,
            ],
        ]);

        /*
         * Enable the following component for recommended CakePHP form protection settings.
         * see https://book.cakephp.org/4/en/controllers/components/form-protection.html
         */
        //$this->loadComponent('FormProtection');
    }

    /**
     * 操作権限があるかどうか
     *
     * @param array<string,string> $user usersモデル
     * @return bool adminであればtrue、それ以外はfalse
     */
    public function isAuthorized(array $user): bool
    {
        // 管理者はすべての操作にアクセス可能
        if (isset($user['role']) && $user['role'] === 'admin') {
            return true;
        }

        // デフォルトは拒否
        return false;
    }
}
