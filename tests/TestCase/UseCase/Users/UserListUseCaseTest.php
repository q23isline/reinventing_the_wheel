<?php
declare(strict_types=1);

namespace App\Test\TestCase\UseCase\Users;

use App\Infrastructure\InMemory\Users\InMemoryUserRepository;
use App\UseCase\Users\UserData;
use App\UseCase\Users\UserListCommand;
use App\UseCase\Users\UserListUseCase;
use Cake\TestSuite\TestCase;

/**
 * App\UseCase\Users\UserListUseCase Test Case
 *
 * @uses \App\UseCase\Users\UserListUseCase
 */
class UserListUseCaseTest extends TestCase
{
    /**
     * Test handle method
     *
     * @return void
     */
    public function test_ユーザー一覧が参照できること(): void
    {
        // Arrange
        $userRepository = new InMemoryUserRepository();
        $userListUseCase = new UserListUseCase($userRepository);

        $userId1 = '01509588-3882-42dd-9ab2-485e8e579a8e';
        $user1 = (new TestUserFactory())->create(userId: $userId1);
        $userRepository->save($user1);

        $userId2 = '99999999-3882-42dd-9ab2-485e8e579a8e';
        $user2 = (new TestUserFactory())->create(userId: $userId2);
        $userRepository->save($user2);

        // テスト実行を sqlite にしているため、FULLTEXT INDEX のテストができない
        // 検索条件なしのテストのみを行う
        $command = new UserListCommand(null);

        // Act
        $actualUserDtos = $userListUseCase->handle($command);

        // Assert
        // ユーザー一覧が正しく参照できるか
        $expectDto1 = new UserData($user1);
        $expectDto2 = new UserData($user2);
        $this->assertEquals(2, count($actualUserDtos));
        $this->assertEquals($expectDto1, $actualUserDtos[0]);
        $this->assertEquals($expectDto2, $actualUserDtos[1]);
    }
}
