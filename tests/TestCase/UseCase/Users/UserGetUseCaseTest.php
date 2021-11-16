<?php
declare(strict_types=1);

namespace App\Test\TestCase\UseCase\Users;

use App\Infrastructure\InMemory\Users\InMemoryUserRepository;
use App\UseCase\Users\UserData;
use App\UseCase\Users\UserGetCommand;
use App\UseCase\Users\UserGetUseCase;
use Cake\Datasource\Exception\RecordNotFoundException;
use Cake\TestSuite\TestCase;

/**
 * App\UseCase\Users\UserGetUseCase Test Case
 *
 * @uses \App\UseCase\Users\UserGetUseCase
 */
final class UserGetUseCaseTest extends TestCase
{
    /**
     * Test handle method
     *
     * @return void
     */
    public function test_ユーザー詳細が参照できること(): void
    {
        // Arrange
        $userRepository = new InMemoryUserRepository();
        $userGetUseCase = new UserGetUseCase($userRepository);

        $userId = '01509588-3882-42dd-9ab2-485e8e579a8e';
        $user = (new TestUserFactory())->create(userId: $userId);
        $userRepository->save($user);
        $inputData = new UserGetCommand(userId: $userId);

        // Act
        $actualUserDto = $userGetUseCase->handle($inputData);

        // Assert
        // ユーザーが正しく参照できるか
        $expectDto = new UserData($user);
        $this->assertEquals($expectDto, $actualUserDto);
    }

    /**
     * Test handle method
     *
     * @return void
     */
    public function test_ユーザー詳細が参照できないこと：存在しないユーザーID(): void
    {
        // Arrange
        $userRepository = new InMemoryUserRepository();
        $userGetUseCase = new UserGetUseCase($userRepository);

        $inputData = new UserGetCommand(userId: '01509588-3882-42dd-9ab2-485e8e579a8e');

        // Assert
        // ユーザーの更新に失敗するか
        $this->expectException(RecordNotFoundException::class);

        // Act
        $userGetUseCase->handle($inputData);
    }
}
