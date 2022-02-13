<?php
declare(strict_types=1);

namespace App\Test\TestCase\Domain\Models\User;

use App\Domain\Models\User\Type\MailAddress;
use App\Domain\Models\User\Type\Password;
use App\Domain\Models\User\Type\RoleName;
use App\Domain\Models\User\Type\UserId;
use App\Domain\Models\User\User;
use Cake\TestSuite\TestCase;

/**
 * App\Domain\Models\User\User Test Case
 *
 * @uses \App\Domain\Models\User\User
 */
final class UserTest extends TestCase
{
    /**
     * @return void
     */
    public function test_ユーザーインスタンスが作成されること(): void
    {
        // Arrange
        $id = new UserId('01509588-3882-42dd-9ab2-485e8e579a8e');
        $mailAddress = new MailAddress('test@example.com');
        $password = new Password('p@ssw0rd');
        $roleName = new RoleName('viewer');

        // Act
        $user = User::create(
            $id,
            $mailAddress,
            $password,
            $roleName,
        );

        // Assert
        $this->assertEquals($id, $user->id);
        $this->assertEquals($roleName, $user->roleName);
        $this->assertEquals($password, $user->password);
        $this->assertEquals($mailAddress, $user->mailAddress);
    }

    /**
     * @return void
     */
    public function test_ユーザーインスタンスが再構成されること(): void
    {
        // Arrange
        $id = new UserId('01509588-3882-42dd-9ab2-485e8e579a8e');
        $mailAddress = new MailAddress('test@example.com');
        $password = new Password('p@ssw0rd');
        $roleName = new RoleName('viewer');

        // Act
        $user = User::reconstruct(
            $id,
            $mailAddress,
            $password,
            $roleName,
        );

        // Assert
        $this->assertEquals($id, $user->id);
        $this->assertEquals($mailAddress, $user->mailAddress);
        $this->assertEquals($password, $user->password);
        $this->assertEquals($roleName, $user->roleName);
    }

    /**
     * @return void
     */
    public function test_ユーザーインスタンスが更新（再作成）されること(): void
    {
        // Arrange
        $id = new UserId('01509588-3882-42dd-9ab2-485e8e579a8e');
        $mailAddress = new MailAddress('test1@example.com');
        $password = new Password('p@ssw0rd1');
        $roleName = new RoleName('editor');
        $user = User::create(
            $id,
            new MailAddress('test@example.com'),
            new Password('p@ssw0rd'),
            new RoleName('viewer'),
        );

        // Act
        $user = $user->update(
            $mailAddress,
            $password,
            $roleName,
        );

        // Assert
        $this->assertEquals($id, $user->id);
        $this->assertEquals($mailAddress, $user->mailAddress);
        $this->assertEquals($password, $user->password);
        $this->assertEquals($roleName, $user->roleName);
    }
}
