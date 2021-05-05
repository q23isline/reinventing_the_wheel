<?php
declare(strict_types=1);

namespace App\UseCase\Users;

use App\Domain\Models\User\IUserRepository;
use App\Domain\Models\User\Type\UserId;
use App\Domain\Shared\Exception\ExceptionItem;
use App\Domain\Shared\Exception\NotFoundException;

/**
 * class UserGetUseCaseService
 */
final class UserGetUseCaseService
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
     * ユーザー詳細を取得する
     *
     * @param \App\UseCase\Users\UserGetCommand $command command
     * @return \App\UseCase\Users\UserData
     */
    public function handle(UserGetCommand $command): UserData
    {
        $userId = new UserId($command->getUserId());

        $user = $this->userRepository->findById($userId);

        if (is_null($user)) {
            throw new NotFoundException([new ExceptionItem('userId', 'ユーザーは存在しません。')]);
        }

        return new UserData($user);
    }
}
