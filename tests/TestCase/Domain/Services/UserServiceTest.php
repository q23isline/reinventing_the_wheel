<?php
declare(strict_types=1);

namespace App\Test\TestCase\Domain\Services;

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
use Cake\TestSuite\TestCase;

/**
 * App\Domain\Services\UserService Test Case
 *
 * @uses \App\Domain\Services\UserService
 */
class UserServiceTest extends TestCase
{
    /**
     * @return void
     */
    public function test_ユーザーインスタンスが自分自身であること(): void
    {
        // Arrange
        $user = User::create(
            new UserId('01509588-3882-42dd-9ab2-485e8e579a8e'),
            new LoginId('test'),
            new Password('p@ssw0rd'),
            new RoleName('viewer'),
            new FirstName('test1'),
            new LastName('test2'),
            new FirstNameKana('テストイチ'),
            new LastNameKana('テストニ'),
            new MailAddress('test@example.com'),
            new Sex('1'),
            new BirthDay('1980-01-01'),
            new CellPhoneNumber('09012345678'),
            new Remarks('テストメモ'),
        );
        $userOther = $user;

        // Act
        $isMyself = $user->isMyself($userOther);

        // Assert
        $this->assertTrue($isMyself);
    }

    /**
     * @return void
     */
    public function test_ユーザーインスタンスが自分自身でないこと(): void
    {
        // Arrange
        $user = User::create(
            new UserId('01509588-3882-42dd-9ab2-485e8e579a8e'),
            new LoginId('test'),
            new Password('p@ssw0rd'),
            new RoleName('viewer'),
            new FirstName('test1'),
            new LastName('test2'),
            new FirstNameKana('テストイチ'),
            new LastNameKana('テストニ'),
            new MailAddress('test@example.com'),
            new Sex('1'),
            new BirthDay('1980-01-01'),
            new CellPhoneNumber('09012345678'),
            new Remarks('テストメモ'),
        );
        $userOther = User::create(
            new UserId('99999999-3882-42dd-9ab2-485e8e579a8e'),
            new LoginId('test1'),
            new Password('p@ssw0rd'),
            new RoleName('viewer'),
            new FirstName('test1'),
            new LastName('test2'),
            new FirstNameKana('テストイチ'),
            new LastNameKana('テストニ'),
            new MailAddress('test1@example.com'),
            new Sex('1'),
            new BirthDay('1980-01-01'),
            new CellPhoneNumber('09012345679'),
            new Remarks('テストメモ'),
        );

        // Act
        $isMyself = $user->isMyself($userOther);

        // Assert
        $this->assertFalse($isMyself);
    }
}
