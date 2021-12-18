<?php
declare(strict_types=1);

namespace App\Test\TestCase\Infrastructure\CakePHP\Users;

use App\Domain\Models\User\Type\BirthDay;
use App\Domain\Models\User\Type\CellPhoneNumber;
use App\Domain\Models\User\Type\FirstName;
use App\Domain\Models\User\Type\FirstNameKana;
use App\Domain\Models\User\Type\LastName;
use App\Domain\Models\User\Type\LastNameKana;
use App\Domain\Models\User\Type\LoginId;
use App\Domain\Models\User\Type\MailAddress;
use App\Domain\Models\User\Type\Password;
use App\Domain\Models\User\Type\Remarks;
use App\Domain\Models\User\Type\RoleName;
use App\Domain\Models\User\Type\Sex;
use App\Domain\Models\User\Type\UserId;
use App\Domain\Models\User\User;
use App\Domain\Models\User\UserCollection;
use App\Infrastructure\CakePHP\Users\CakePHPUserRepository;
use Cake\Datasource\Exception\RecordNotFoundException;
use Cake\TestSuite\IntegrationTestTrait;
use Cake\TestSuite\TestCase;

/**
 * App\Infrastructure\CakePHP\Users\CakePHPUserRepository Test Case
 *
 * @uses \App\Infrastructure\CakePHP\Users\CakePHPUserRepository
 */
final class CakePHPUserRepositoryTest extends TestCase
{
    use IntegrationTestTrait;

    /**
     * Fixtures
     *
     * @var array
     */
    protected $fixtures = [
        'app.Users',
    ];

    /**
     * @return void
     */
    public function test_UUIDを取得すること(): void
    {
        // UUID の正規表現パターン
        $expectUserIdPattern = '/^[0-9a-f]{8}-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{12}$/';

        // Act
        $userId = (new CakePHPUserRepository())->assignId();

        // Assert
        $this->assertMatchesRegularExpression($expectUserIdPattern, $userId->value);
    }

    /**
     * @return void
     */
    public function test_ユーザーIDによってユーザー情報を取得すること(): void
    {
        // Arrange
        $userId = '41559b8b-e831-4972-8afa-21ee8b952d85';

        $expect = User::reconstruct(
            new UserId($userId),
            new LoginId('admin'),
            new Password('password'),
            new RoleName('admin'),
            new FirstName('admin'),
            new LastName('管理者'),
            new FirstNameKana('アドミン'),
            new LastNameKana('カンリシャ'),
            new MailAddress('admin@example.com'),
            new Sex('1'),
            new BirthDay('2021-10-14'),
            new CellPhoneNumber('09012345678'),
            new Remarks('管理者メモ'),
        );

        // Act
        $actual = (new CakePHPUserRepository())->getById(new UserId($userId));

        // Assert
        $this->assertEquals($expect, $actual);
    }

    /**
     * @return void
     */
    public function test_ログインIDによってユーザー情報を取得すること(): void
    {
        // Arrange
        $loginId = 'admin';

        $expect = User::reconstruct(
            new UserId('41559b8b-e831-4972-8afa-21ee8b952d85'),
            new LoginId($loginId),
            new Password('password'),
            new RoleName('admin'),
            new FirstName('admin'),
            new LastName('管理者'),
            new FirstNameKana('アドミン'),
            new LastNameKana('カンリシャ'),
            new MailAddress('admin@example.com'),
            new Sex('1'),
            new BirthDay('2021-10-14'),
            new CellPhoneNumber('09012345678'),
            new Remarks('管理者メモ'),
        );

        // Act
        $actual = (new CakePHPUserRepository())->findByLoginId(new LoginId($loginId));

        // Assert
        $this->assertEquals($expect, $actual);
    }

    /**
     * @return void
     */
    public function test_ログインIDに一致するユーザー情報が存在しない場合空を返すこと(): void
    {
        // Arrange
        $loginId = 'sample';

        // Act
        $actual = (new CakePHPUserRepository())->findByLoginId(new LoginId($loginId));

        // Assert
        $this->assertNull($actual);
    }

    /**
     * @return void
     */
    public function test_すべてのユーザー情報を取得すること(): void
    {
        // Arrange
        $expect = new UserCollection([
            User::reconstruct(
                new UserId('41559b8b-e831-4972-8afa-21ee8b952d85'),
                new LoginId('admin'),
                new Password('password'),
                new RoleName('admin'),
                new FirstName('admin'),
                new LastName('管理者'),
                new FirstNameKana('アドミン'),
                new LastNameKana('カンリシャ'),
                new MailAddress('admin@example.com'),
                new Sex('1'),
                new BirthDay('2021-10-14'),
                new CellPhoneNumber('09012345678'),
                new Remarks('管理者メモ'),
            ),
            User::reconstruct(
                new UserId('99999999-5447-4eb1-bde1-001880663af3'),
                new LoginId('test1018'),
                new Password('password'),
                new RoleName('viewer'),
                new FirstName('斉藤'),
                new LastName('太郎'),
                new FirstNameKana('サイトウ'),
                new LastNameKana('タロウ'),
                new MailAddress('saito6@example.com'),
                new Sex('1'),
                new BirthDay('1990-01-01'),
                new CellPhoneNumber('09011111116'),
                new Remarks('斉藤メモ'),
            ),
        ]);

        // Act
        $actual = (new CakePHPUserRepository())->findAll();

        // Assert
        $this->assertEquals($expect, $actual);
    }

    /**
     * @return void
     */
    public function test_ユーザー情報を保存すること(): void
    {
        // Arrange
        $userId = '01509588-3882-42dd-9ab2-485e8e579a8e';
        $user = User::reconstruct(
            new UserId($userId),
            new LoginId('test'),
            new Password('p@ssw0rd1'),
            new RoleName('editor'),
            new FirstName('test2'),
            new LastName('test3'),
            new FirstNameKana('テストニ'),
            new LastNameKana('テストサン'),
            new MailAddress('test1@example.com'),
            new Sex('2'),
            new BirthDay('1980-01-02'),
            new CellPhoneNumber('09012345679'),
            new Remarks('テストメモ'),
        );

        // Act
        $actual = (new CakePHPUserRepository())->save($user);

        // Assert
        $this->assertEquals(new UserId($userId), $actual);
    }

    /**
     * @return void
     */
    public function test_ユーザー情報を更新すること(): void
    {
        // Arrange
        $userId = '99999999-5447-4eb1-bde1-001880663af3';
        $user = User::reconstruct(
            new UserId($userId),
            new LoginId('test'),
            new Password('p@ssw0rd1'),
            new RoleName('editor'),
            new FirstName('test2'),
            new LastName('test3'),
            new FirstNameKana('テストニ'),
            new LastNameKana('テストサン'),
            new MailAddress('test1@example.com'),
            new Sex('2'),
            new BirthDay('1980-01-02'),
            new CellPhoneNumber('09012345679'),
            new Remarks('テストメモ'),
        );

        // Act
        $actual = (new CakePHPUserRepository())->update($user);

        // Assert
        $this->assertEquals(new UserId($userId), $actual);
    }

    /**
     * @return void
     */
    public function test_ユーザー情報を削除すること(): void
    {
        // Arrange
        $userId = '99999999-5447-4eb1-bde1-001880663af3';

        // Act
        (new CakePHPUserRepository())->delete(new UserId($userId));

        // Assert
        // 削除したユーザー情報がヒットせず、例外が発生すること
        $this->expectException(RecordNotFoundException::class);
        (new CakePHPUserRepository())->getById(new UserId($userId));
    }
}
