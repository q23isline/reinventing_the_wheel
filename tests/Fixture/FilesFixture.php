<?php
declare(strict_types=1);

namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * FilesFixture
 */
class FilesFixture extends TestFixture
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
                'id' => '1de9f5cb-32f1-4825-a745-ad7e1b1516c0',
                'name' => 'Lorem ipsum dolor sit amet',
                'size' => 1,
                'content_type' => 'Lorem ipsum dolor sit amet',
                'directory' => 'Lorem ipsum dolor sit amet',
                'created' => '2021-11-11 20:57:46',
                'modified' => '2021-11-11 20:57:46',
            ],
        ];
        parent::init();
    }
}
