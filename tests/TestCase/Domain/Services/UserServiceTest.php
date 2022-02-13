<?php
declare(strict_types=1);

namespace App\Test\TestCase\Domain\Services;

use App\Domain\Models\User\Type\MailAddress;
use App\Domain\Models\User\Type\Password;
use App\Domain\Models\User\Type\RoleName;
use App\Domain\Models\User\Type\UserId;
use App\Domain\Models\User\User;
use Cake\TestSuite\TestCase;

/**
 * App\Domain\Services\UserService Test Case
 *
 * @uses \App\Domain\Services\UserService
 */
final class UserServiceTest extends TestCase
{
    /**
     * @return void
     */
    public function test_ユーザーインスタンスが自分自身であること(): void
    {
        // Arrange
        $user = User::create(
            new UserId('01509588-3882-42dd-9ab2-485e8e579a8e'),
            new MailAddress('test@example.com'),
            new Password('p@ssw0rd'),
            new RoleName('viewer'),
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
            new MailAddress('test@example.com'),
            new Password('p@ssw0rd'),
            new RoleName('viewer'),
        );
        $userOther = User::create(
            new UserId('99999999-3882-42dd-9ab2-485e8e579a8e'),
            new MailAddress('test1@example.com'),
            new Password('p@ssw0rd'),
            new RoleName('viewer'),
        );

        // Act
        $isMyself = $user->isMyself($userOther);

        // Assert
        $this->assertFalse($isMyself);
    }
}
