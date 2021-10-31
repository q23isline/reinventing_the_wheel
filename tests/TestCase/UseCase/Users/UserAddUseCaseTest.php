<?php
declare(strict_types=1);

namespace App\Test\TestCase\UseCase\Users;

use App\Domain\Models\User\Type\LoginId;
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
class UserAddUseCaseTest extends TestCase
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

        $loginId = 'test';
        $inputData = new UserAddCommand(
            loginId: $loginId,
            password: 'p@ssw0rd',
            roleName: 'viewer',
            firstName: 'test1',
            lastName: 'test2',
            firstNameKana: 'テストイチ',
            lastNameKana: 'テストニ',
            mailAddress: 'test@example.com',
            sex: '1',
            birthDay: '1980-01-01',
            cellPhoneNumber: '09012345678',
        );

        // Act
        $userAddUseCase->handle($inputData);

        // Assert
        // ユーザーが正しく保存されているか
        $createdLoginId = new LoginId($loginId);
        $createdUser = $userRepository->findByLoginId($createdLoginId);
        $this->assertNotNull($createdUser);
    }

    /**
     * Test handle method
     *
     * @return void
     */
    public function test_ユーザーが登録できないこと：登録済ログインID(): void
    {
        // Arrange
        $userRepository = new InMemoryUserRepository();
        $userService = new UserService($userRepository);
        $userAddUseCase = new UserAddUseCase($userRepository, $userService);

        $loginId = 'test';
        $user = (new TestUserFactory())->create(loginId: $loginId);
        $userRepository->save($user);
        $inputData = new UserAddCommand(
            loginId: $loginId,
            password: 'p@ssw0rd',
            roleName: 'viewer',
            firstName: 'test1',
            lastName: 'test2',
            firstNameKana: 'テストイチ',
            lastNameKana: 'テストニ',
            mailAddress: 'test@example.com',
            sex: '1',
            birthDay: '1980-01-01',
            cellPhoneNumber: '09012345678',
        );

        // Assert
        // ユーザーの登録に失敗するか
        $this->expectException(ValidateException::class);

        // Act
        $userAddUseCase->handle($inputData);
    }
}
