<?php
declare(strict_types=1);

namespace App\Test\TestCase\Domain\Models\User\Type;

use App\Domain\Models\User\Type\RoleName;
use App\Domain\Shared\Exception\ValidateException;
use Cake\TestSuite\TestCase;

/**
 * App\Domain\Models\User\Type\RoleName Test Case
 *
 * @uses \App\Domain\Models\User\Type\RoleName
 */
final class RoleNameTest extends TestCase
{
    /**
     * @return void
     */
    public function test_admin、editor、viewer以外の値を渡すと例外が発生すること(): void
    {
        // Arrange
        $roleName = 'sample';

        // Assert
        $this->expectException(ValidateException::class);

        // Act
        new RoleName($roleName);
    }

    /**
     * @return void
     */
    public function test_adminの値を渡すと正しくインスタンスが作成されること(): void
    {
        // Arrange
        $roleName = 'admin';

        // Act
        $actualRoleName = new RoleName($roleName);

        // Assert
        $this->assertEquals($roleName, $actualRoleName->value);
    }
}
