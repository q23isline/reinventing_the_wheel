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
     * @var \App\Domain\Models\User\IUserRepository
     */
    private IUserRepository $userRepository;

    /**
     * constructor
     *
     * @param \App\Domain\Models\User\IUserRepository $userRepository userRepository
     */
    public function __construct(IUserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    /**
     * ユーザーを削除する
     *
     * @param \App\UseCase\Users\UserDeleteCommand $command command
     * @return void
     */
    public function handle(UserDeleteCommand $command): void
    {
        $userId = new UserId($command->getUserId());
        $this->userRepository->delete($userId);
    }
}
