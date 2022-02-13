<?php
declare(strict_types=1);

namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * ProfileFilesFixture
 */
class ProfileFilesFixture extends TestFixture
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
                'id' => 1,
                'profile_id' => 'Lorem ipsum dolor sit amet',
                'file_id' => 'Lorem ipsum dolor sit amet',
                'created' => '2021-11-11 21:32:28',
                'modified' => '2021-11-11 21:32:28',
            ],
        ];
        parent::init();
    }
}
