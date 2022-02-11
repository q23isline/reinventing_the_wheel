<?php
declare(strict_types=1);

namespace App\Test\TestCase\Infrastructure\CakePHP\Profiles;

use App\Domain\Models\Profile\Profile;
use App\Domain\Models\Profile\ProfileCollection;
use App\Domain\Models\Profile\Type\BirthDay;
use App\Domain\Models\Profile\Type\CellPhoneNumber;
use App\Domain\Models\Profile\Type\FirstName;
use App\Domain\Models\Profile\Type\FirstNameKana;
use App\Domain\Models\Profile\Type\LastName;
use App\Domain\Models\Profile\Type\LastNameKana;
use App\Domain\Models\Profile\Type\ProfileId;
use App\Domain\Models\Profile\Type\Remarks;
use App\Domain\Models\Profile\Type\Sex;
use App\Domain\Models\User\Type\UserId;
use App\Infrastructure\CakePHP\Profiles\CakePHPProfileRepository;
use Cake\Datasource\Exception\RecordNotFoundException;
use Cake\TestSuite\IntegrationTestTrait;
use Cake\TestSuite\TestCase;

/**
 * App\Infrastructure\CakePHP\Profiles\CakePHPProfileRepository Test Case
 *
 * @uses \App\Infrastructure\CakePHP\Profiles\CakePHPProfileRepository
 */
final class CakePHPProfileRepositoryTest extends TestCase
{
    use IntegrationTestTrait;

    /**
     * Fixtures
     *
     * @var array
     */
    protected $fixtures = [
        'app.Users',
        'app.Profiles',
    ];

    /**
     * @return void
     */
    public function test_UUIDを取得すること(): void
    {
        // UUID の正規表現パターン
        $expectProfileIdPattern = '/^[0-9a-f]{8}-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{12}$/';

        // Act
        $profileId = (new CakePHPProfileRepository())->assignId();

        // Assert
        $this->assertMatchesRegularExpression($expectProfileIdPattern, $profileId->value);
    }

    /**
     * @return void
     */
    public function test_プロフィールIDによってプロフィール情報を取得すること(): void
    {
        // Arrange
        $profileId = 'c2e37627-ac0a-45e0-9dfd-eb5d703d8989';
        $userId = '41559b8b-e831-4972-8afa-21ee8b952d85';

        $expect = Profile::reconstruct(
            new ProfileId($profileId),
            new UserId($userId),
            new FirstName('admin'),
            new LastName('管理者'),
            new FirstNameKana('アドミン'),
            new LastNameKana('カンリシャ'),
            new Sex('1'),
            new BirthDay('2021-10-14'),
            new CellPhoneNumber('09012345678'),
            new Remarks('管理者メモ'),
        );

        // Act
        $actual = (new CakePHPProfileRepository())->getById(new ProfileId($profileId));

        // Assert
        $this->assertEquals($expect, $actual);
    }

    /**
     * @return void
     */
    public function test_すべてのプロフィール情報を取得すること(): void
    {
        // Arrange
        $expect = new ProfileCollection([
            Profile::reconstruct(
                new ProfileId('c2e37627-ac0a-45e0-9dfd-eb5d703d8989'),
                new UserId('41559b8b-e831-4972-8afa-21ee8b952d85'),
                new FirstName('admin'),
                new LastName('管理者'),
                new FirstNameKana('アドミン'),
                new LastNameKana('カンリシャ'),
                new Sex('1'),
                new BirthDay('2021-10-14'),
                new CellPhoneNumber('09012345678'),
                new Remarks('管理者メモ'),
            ),
            Profile::reconstruct(
                new ProfileId('c2e37627-ac0a-45e0-9dfd-eb5d703d8990'),
                new UserId('99999999-5447-4eb1-bde1-001880663af3'),
                new FirstName('斉藤'),
                new LastName('太郎'),
                new FirstNameKana('サイトウ'),
                new LastNameKana('タロウ'),
                new Sex('1'),
                new BirthDay('1990-01-01'),
                new CellPhoneNumber('09011111116'),
                new Remarks('斉藤メモ'),
            ),
        ]);

        // Act
        $actual = (new CakePHPProfileRepository())->findAll();

        // Assert
        $this->assertEquals($expect, $actual);
    }

    /**
     * @return void
     */
    public function test_プロフィール情報を保存すること(): void
    {
        // Arrange
        $profileId = 'c2e37627-ac0a-45e0-9dfd-eb5d703d8989';
        $userId = '41559b8b-e831-4972-8afa-21ee8b952d85';
        $profile = Profile::reconstruct(
            new ProfileId($profileId),
            new UserId($userId),
            new FirstName('test2'),
            new LastName('test3'),
            new FirstNameKana('テストニ'),
            new LastNameKana('テストサン'),
            new Sex('2'),
            new BirthDay('1980-01-02'),
            new CellPhoneNumber('09012345679'),
            new Remarks('テストメモ'),
        );

        // Act
        $actual = (new CakePHPProfileRepository())->save($profile);

        // Assert
        $this->assertEquals(new ProfileId($profileId), $actual);
    }

    /**
     * @return void
     */
    public function test_プロフィール情報を更新すること(): void
    {
        // Arrange
        $profileId = 'c2e37627-ac0a-45e0-9dfd-eb5d703d8989';
        $userId = '99999999-5447-4eb1-bde1-001880663af3';
        $profile = Profile::reconstruct(
            new ProfileId($profileId),
            new UserId($userId),
            new FirstName('test2'),
            new LastName('test3'),
            new FirstNameKana('テストニ'),
            new LastNameKana('テストサン'),
            new Sex('2'),
            new BirthDay('1980-01-02'),
            new CellPhoneNumber('09012345679'),
            new Remarks('テストメモ'),
        );

        // Act
        $actual = (new CakePHPProfileRepository())->update($profile);

        // Assert
        $this->assertEquals(new ProfileId($profileId), $actual);
    }

    /**
     * @return void
     */
    public function test_プロフィール情報を削除すること(): void
    {
        // Arrange
        $profileId = 'c2e37627-ac0a-45e0-9dfd-eb5d703d8989';

        // Act
        (new CakePHPProfileRepository())->delete(new ProfileId($profileId));

        // Assert
        // 削除したプロフィール情報がヒットせず、例外が発生すること
        $this->expectException(RecordNotFoundException::class);
        (new CakePHPProfileRepository())->getById(new ProfileId($profileId));
    }
}
