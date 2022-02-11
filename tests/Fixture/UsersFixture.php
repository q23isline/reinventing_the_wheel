<?php
declare(strict_types=1);

namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * UsersFixture
 */
class UsersFixture extends TestFixture
{
    /**
     * Init method
     *
     * @return void
     */
    public function init(): void
    {
        $this->records = [
            [
                'id' => '41559b8b-e831-4972-8afa-21ee8b952d85',
                'mail_address' => 'admin@example.com',
                'password' => 'password',
                'role' => 'admin',
                'created' => '2020-01-01 00:00:00',
                'modified' => '2020-01-02 00:00:00',
            ],
            [
                'id' => '99999999-5447-4eb1-bde1-001880663af3',
                'mail_address' => 'saito6@example.com',
                'password' => 'password',
                'role' => 'viewer',
                'created' => '2020-01-03 00:00:00',
                'modified' => '2020-01-04 00:00:00',
            ],
        ];
        parent::init();
    }
}
