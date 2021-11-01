<?php
declare(strict_types=1);

namespace App\Test\TestCase\Domain\Models\User\Type;

use App\Domain\Models\User\Type\LoginId;
use App\Domain\Shared\Exception\ValidateException;
use Cake\TestSuite\TestCase;

/**
 * App\Test\TestCase\Domain\Models\User\Type\LoginIdTest Test Case
 *
 * @uses \App\Test\TestCase\Domain\Models\User\Type\LoginIdTest
 */
class LoginIdTest extends TestCase
{
    /**
     * Test handle method
     *
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
     * Test handle method
     *
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
     * Test handle method
     *
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
     * Test handle method
     *
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
