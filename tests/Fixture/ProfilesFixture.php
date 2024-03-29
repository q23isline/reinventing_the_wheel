<?php
declare(strict_types=1);

namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * ProfilesFixture
 */
class ProfilesFixture extends TestFixture
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
                'id' => 'c2e37627-ac0a-45e0-9dfd-eb5d703d8989',
                'user_id' => '41559b8b-e831-4972-8afa-21ee8b952d85',
                'first_name' => 'admin',
                'last_name' => '管理者',
                'first_name_kana' => 'アドミン',
                'last_name_kana' => 'カンリシャ',
                'sex' => '1',
                'birth_day' => '2021-10-14',
                'cell_phone_number' => '09012345678',
                'remarks' => '管理者メモ',
                'created' => '2020-01-01 00:00:00',
                'modified' => '2020-01-02 00:00:00',
            ],
            [
                'id' => 'c2e37627-ac0a-45e0-9dfd-eb5d703d8990',
                'user_id' => '99999999-5447-4eb1-bde1-001880663af3',
                'first_name' => '斉藤',
                'last_name' => '太郎',
                'first_name_kana' => 'サイトウ',
                'last_name_kana' => 'タロウ',
                'sex' => '1',
                'birth_day' => '1990-01-01',
                'cell_phone_number' => '09011111116',
                'remarks' => '斉藤メモ',
                'created' => '2020-01-03 00:00:00',
                'modified' => '2020-01-04 00:00:00',
            ],
        ];
        parent::init();
    }
}
