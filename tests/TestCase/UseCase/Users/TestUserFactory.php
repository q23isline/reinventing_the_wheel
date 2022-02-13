<?php
declare(strict_types=1);

namespace App\Test\TestCase\UseCase\Users;

use App\Domain\Models\User\Type\MailAddress;
use App\Domain\Models\User\Type\Password;
use App\Domain\Models\User\Type\RoleName;
use App\Domain\Models\User\Type\UserId;
use App\Domain\Models\User\User;

/**
 * App\Test\TestCase\UseCase\Users\TestUserFactory
 */
final class TestUserFactory
{
    /**
     * @param string $userId userId
     * @param string $mailAddress mailAddress
     * @param string $password password
     * @param string $roleName roleName
     * @return \App\Domain\Models\User\User
     */
    public function create(
        string $userId = '01509588-3882-42dd-9ab2-485e8e579a8e',
        string $mailAddress = 'test@example.com',
        string $password = 'p@ssw0rd',
        string $roleName = 'viewer'
    ): User {
        return User::reconstruct(
            new UserId($userId),
            new MailAddress($mailAddress),
            new Password($password),
            new RoleName($roleName),
        );
    }
}
