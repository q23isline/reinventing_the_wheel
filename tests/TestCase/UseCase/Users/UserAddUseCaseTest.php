<?php
declare(strict_types=1);

namespace App\Test\TestCase\UseCase\Users;

use App\Domain\Models\User\Type\MailAddress;
use App\Domain\Services\UserService;
use App\Domain\Shared\Exception\ValidateException;
use App\Infrastructure\InMemory\Users\InMemoryUserRepository;
use App\UseCase\Users\UserAddCommand;
use App\UseCase\Users\UserAddUseCase;
use Cake\TestSuite\TestCase;

/**
 * App\UseCase\Users\UserAddUseCase Test Case
 *
 * @uses \App\UseCase\Users\UserAddUseCase
 */
final class UserAddUseCaseTest extends TestCase
{
    /**
     * Test handle method
     *
     * @return void
     */
    public function test_ユーザーが登録されること(): void
    {
        // Arrange
        $userRepository = new InMemoryUserRepository();
        $userService = new UserService($userRepository);
        $userAddUseCase = new UserAddUseCase($userRepository, $userService);

        $mailAddress = 'test@example.com';
        $inputData = new UserAddCommand(
            mailAddress: $mailAddress,
            password: 'p@ssw0rd',
            roleName: 'viewer',
        );

        // Act
        $userAddUseCase->handle($inputData);

        // Assert
        // ユーザーが正しく保存されているか
        $createdMailAddress = new MailAddress($mailAddress);
        $createdUser = $userRepository->findByMailAddress($createdMailAddress);
        $this->assertNotNull($createdUser);
    }

    /**
     * Test handle method
     *
     * @return void
     */
    public function test_ユーザーが登録できないこと：登録済メールアドレス(): void
    {
        // Arrange
        $userRepository = new InMemoryUserRepository();
        $userService = new UserService($userRepository);
        $userAddUseCase = new UserAddUseCase($userRepository, $userService);

        $mailAddress = 'test@example.com';
        $user = (new TestUserFactory())->create(mailAddress: $mailAddress);
        $userRepository->save($user);
        $inputData = new UserAddCommand(
            mailAddress: 'test@example.com',
            password: 'p@ssw0rd',
            roleName: 'viewer',
        );

        // Assert
        // ユーザーの登録に失敗するか
        $this->expectException(ValidateException::class);

        // Act
        $userAddUseCase->handle($inputData);
    }
}
