<?php
declare(strict_types=1);

namespace App\UseCase\Users;

use App\Domain\Models\User\IUserRepository;
use App\Domain\Models\User\Type\UserId;

/**
 * class UserGetUseCase
 */
class UserGetUseCase
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
     * ユーザー詳細を取得する
     *
     * @param \App\UseCase\Users\UserGetCommand $command command
     * @return \App\UseCase\Users\UserData
     */
    public function handle(UserGetCommand $command): UserData
    {
        $userId = new UserId($command->userId);
        $user = $this->userRepository->getById($userId);

        return new UserData($user);
    }
}
