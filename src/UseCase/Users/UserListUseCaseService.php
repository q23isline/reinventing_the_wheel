<?php
declare(strict_types=1);

namespace App\UseCase\Users;

use App\Domain\Models\User\IUserRepository;

/**
 * class UserListUseCaseService
 */
final class UserListUseCaseService
{
    /**
     * @var IUserRepository
     */
    private IUserRepository $userRepository;

    /**
     * constructor
     *
     * @param IUserRepository $userRepository userRepository
     */
    public function __construct(IUserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    /**
     * ユーザー一覧を取得する
     *
     * @return UserData[]
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
