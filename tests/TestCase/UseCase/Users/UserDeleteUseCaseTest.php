<?php
declare(strict_types=1);

namespace App\Test\TestCase\UseCase\Users;

use App\Domain\Models\User\Type\MailAddress;
use App\Infrastructure\InMemory\Users\InMemoryUserRepository;
use App\UseCase\Users\UserDeleteCommand;
use App\UseCase\Users\UserDeleteUseCase;
use Cake\Datasource\Exception\RecordNotFoundException;
use Cake\TestSuite\TestCase;

/**
 * App\UseCase\Users\UserDeleteUseCase Test Case
 *
 * @uses \App\UseCase\Users\UserDeleteUseCase
 */
final class UserDeleteUseCaseTest extends TestCase
{
    /**
     * Test handle method
     *
     * @return void
     */
    public function test_ユーザーが削除されること(): void
    {
        // Arrange
        $userRepository = new InMemoryUserRepository();
        $userDeleteUseCase = new UserDeleteUseCase($userRepository);

        $userId = '01509588-3882-42dd-9ab2-485e8e579a8e';
        $mailAddress = 'test@example.com';
        $user = (new TestUserFactory())->create(
            userId: $userId,
            mailAddress: $mailAddress,
        );
        $userRepository->save($user);
        $inputData = new UserDeleteCommand($userId);

        // Act
        $userDeleteUseCase->handle($inputData);

        // Assert
        // ユーザーが正しく削除されているか
        $deletedMailAddress = new MailAddress($mailAddress);
        $deletedUser = $userRepository->findByMailAddress($deletedMailAddress);
        $this->assertNull($deletedUser);
    }

    /**
     * Test handle method
     *
     * @return void
     */
    public function test_ユーザーが削除できないこと：存在しないユーザーID(): void
    {
        // Arrange
        $userRepository = new InMemoryUserRepository();
        $userDeleteUseCase = new UserDeleteUseCase($userRepository);

        $inputData = new UserDeleteCommand('01509588-3882-42dd-9ab2-485e8e579a8e');

        // Assert
        // ユーザーの更新に失敗するか
        $this->expectException(RecordNotFoundException::class);

        // Act
        $userDeleteUseCase->handle($inputData);
    }
}
