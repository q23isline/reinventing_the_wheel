<?php
declare(strict_types=1);

namespace App\Domain\Services;

use App\Domain\Models\User\IUserRepository;
use App\Domain\Models\User\User;

/**
 * class UserService
 *
 * @property-read \App\Domain\Models\User\IUserRepository $userRepository userRepository
 */
final class UserService
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
     * 存在チェック
     *
     * @param \App\Domain\Models\User\User $user user
     * @return bool
     */
    public function isExists(User $user): bool
    {
        $duplicatedUser = $this->userRepository->findByLoginId($user->getLoginId());

        if (is_null($duplicatedUser) || $duplicatedUser->isMyself($user)) {
            return false;
        }

        return true;
    }
}
