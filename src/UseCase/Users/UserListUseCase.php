<?php
declare(strict_types=1);

namespace App\UseCase\Users;

use App\Domain\Models\User\IUserRepository;

/**
 * class UserListUseCase
 */
class UserListUseCase
{
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
     * ユーザー一覧を取得する
     *
     * @param \App\UseCase\Users\UserListCommand $command command
     * @return \App\UseCase\Users\UserData[]
     */
    public function handle(UserListCommand $command): array
    {
        $searchKeyword = $command->getKeyword();

        $users = $this->userRepository->findAll($searchKeyword);

        $userData = [];
        foreach ($users as $user) {
            $userData[] = new UserData($user);
        }

        return $userData;
    }
}
