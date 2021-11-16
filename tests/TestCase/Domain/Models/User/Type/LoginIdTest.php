<?php
declare(strict_types=1);

namespace App\Test\TestCase\Domain\Models\User\Type;

use App\Domain\Models\User\Type\LoginId;
use App\Domain\Shared\Exception\ValidateException;
use Cake\TestSuite\TestCase;

/**
 * App\Domain\Models\User\Type\LoginId Test Case
 *
 * @uses \App\Domain\Models\User\Type\LoginId
 */
final class LoginIdTest extends TestCase
{
    /**
     * @return void
     */
    public function test_2文字以下の値を渡すと例外が発生すること(): void
    {
        // Arrange
        $loginId = '12';

        // Assert
        $this->expectException(ValidateException::class);

        // Act
        new LoginId($loginId);
    }

    /**
     * @return void
     */
    public function test_3文字の値を渡すと正しくインスタンスが作成されること(): void
    {
        // Arrange
        $loginId = '123';

        // Act
        $actualLoginId = new LoginId($loginId);

        // Assert
        $this->assertEquals($loginId, $actualLoginId->getValue());
    }

    /**
     * @return void
     */
    public function test_20文字の値を渡すと正しくインスタンスが作成されること(): void
    {
        // Arrange
        $loginId = '12345678901234567890';

        // Act
        $actualLoginId = new LoginId($loginId);

        // Assert
        $this->assertEquals($loginId, $actualLoginId->getValue());
    }

    /**
     * @return void
     */
    public function test_21文字以下の値を渡すと例外が発生すること(): void
    {
        // Arrange
        $loginId = '123456789012345678901';

        // Assert
        $this->expectException(ValidateException::class);

        // Act
        new LoginId($loginId);
    }
}
