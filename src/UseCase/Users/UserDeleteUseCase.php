<?php
declare(strict_types=1);

namespace App\UseCase\Users;

use App\Domain\Models\User\IUserRepository;
use App\Domain\Models\User\Type\UserId;

/**
 * class UserDeleteUseCase
 */
class UserDeleteUseCase
{
    /**
     * constructor
     *
     * @param \App\Domain\Models\User\IUserRepository $userRepository userRepository
     */
    public function __construct(
        private IUserRepository $userRepository
    ) {
    }

    /**
     * ユーザーを削除する
     *
     * @param \App\UseCase\Users\UserDeleteCommand $command command
     * @return void
     */
    public function handle(UserDeleteCommand $command): void
    {
        $userId = new UserId($command->userId);
        $this->userRepository->delete($userId);
    }
}
