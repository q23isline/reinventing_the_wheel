<?php
declare(strict_types=1);

namespace App\UseCase\Users;

use App\Domain\Models\User\IUserRepository;

/**
 * class UserListUseCase
 */
class UserListUseCase
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
     * ユーザー一覧を取得する
     *
     * @return array<\App\UseCase\Users\UserData>
     */
    public function handle(): array
    {
        $users = $this->userRepository->findAll();

        $userData = [];
        foreach ($users as $user) {
            $userData[] = new UserData($user);
        }

        return $userData;
    }
}
