<?php
declare(strict_types=1);

namespace App\Test\TestCase\UseCase\Users;

use App\Domain\Models\User\Type\UserId;
use App\Domain\Services\UserService;
use App\Domain\Shared\Exception\ValidateException;
use App\Infrastructure\InMemory\Users\InMemoryUserRepository;
use App\UseCase\Users\UserUpdateCommand;
use App\UseCase\Users\UserUpdateUseCase;
use Cake\Datasource\Exception\RecordNotFoundException;
use Cake\TestSuite\TestCase;

/**
 * App\UseCase\Users\UserUpdateUseCase Test Case
 *
 * @uses \App\UseCase\Users\UserUpdateUseCase
 */
final class UserUpdateUseCaseTest extends TestCase
{
    /**
     * Test handle method
     *
     * @return void
     */
    public function test_ユーザーが更新されること(): void
    {
        // Arrange
        $userRepository = new InMemoryUserRepository();
        $userService = new UserService($userRepository);
        $userUpdateUseCase = new UserUpdateUseCase($userRepository, $userService);

        $userId = '01509588-3882-42dd-9ab2-485e8e579a8e';
        $mailAddress = 'test1@example.com';
        $password = 'p@ssw0rd1';
        $roleName = 'editor';
        $user = (new TestUserFactory())->create(
            userId: $userId,
            mailAddress: 'test@example.com',
            password: 'p@ssw0rd',
            roleName: 'viewer',
        );
        $userRepository->save($user);
        $inputData = new UserUpdateCommand(
            userId: $userId,
            mailAddress: $mailAddress,
            password: $password,
            roleName: $roleName,
        );

        // Act
        $userUpdateUseCase->handle($inputData);

        // Assert
        // ユーザーが正しく保存されているか
        $updatedUserId = new UserId($userId);
        $updatedUser = $userRepository->getById($updatedUserId);
        $this->assertEquals($userId, $updatedUser->id->value);
        $this->assertEquals($mailAddress, $updatedUser->mailAddress->value);
        $this->assertEquals($password, $updatedUser->password->value);
        $this->assertEquals($roleName, $updatedUser->roleName->value);
    }

    /**
     * Test handle method
     *
     * @return void
     */
    public function test_ユーザーが更新できないこと：存在しないユーザーID(): void
    {
        // Arrange
        $userRepository = new InMemoryUserRepository();
        $userService = new UserService($userRepository);
        $userUpdateUseCase = new UserUpdateUseCase($userRepository, $userService);

        $inputData = new UserUpdateCommand(
            userId: '01509588-3882-42dd-9ab2-485e8e579a8e',
            mailAddress: 'test1@example.com',
            password: 'p@ssw0rd1',
            roleName: 'editor',
        );

        // Assert
        // ユーザーの更新に失敗するか
        $this->expectException(RecordNotFoundException::class);

        // Act
        $userUpdateUseCase->handle($inputData);
    }

    /**
     * Test handle method
     *
     * @return void
     */
    public function test_ユーザーが更新できないこと：登録済メールアドレス(): void
    {
        // Arrange
        $userRepository = new InMemoryUserRepository();
        $userService = new UserService($userRepository);
        $userUpdateUseCase = new UserUpdateUseCase($userRepository, $userService);

        $userId = '01509588-3882-42dd-9ab2-485e8e579a8e';
        $mailAddress = 'test1@example.com';
        $updateTargetUser = (new TestUserFactory())->create(
            userId: $userId,
            mailAddress: 'test@example.com'
        );
        $userRepository->save($updateTargetUser);
        $otherUser = (new TestUserFactory())->create(
            userId: '99999999-3882-42dd-9ab2-485e8e579a8e',
            mailAddress: $mailAddress
        );
        $userRepository->save($otherUser);
        $inputData = new UserUpdateCommand(
            userId: $userId,
            mailAddress: 'test1@example.com',
            password: 'p@ssw0rd1',
            roleName: 'editor',
        );

        // Assert
        // ユーザーの更新に失敗するか
        $this->expectException(ValidateException::class);

        // Act
        $userUpdateUseCase->handle($inputData);
    }
}
