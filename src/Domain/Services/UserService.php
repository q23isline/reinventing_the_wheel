<?php
declare(strict_types=1);

namespace App\Domain\Services;

use App\Domain\Models\User\IUserRepository;
use App\Domain\Models\User\User;

/**
 * class UserService
 */
final class UserService
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
     * 存在チェック
     *
     * @param \App\Domain\Models\User\User $user user
     * @return bool
     */
    public function isExists(User $user): bool
    {
        $duplicatedUser = $this->userRepository->findByLoginId($user->loginId);

        if (is_null($duplicatedUser) || $duplicatedUser->isMyself($user)) {
            return false;
        }

        return true;
    }
}
