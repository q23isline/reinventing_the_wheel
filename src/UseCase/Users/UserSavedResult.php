<?php
declare(strict_types=1);

namespace App\UseCase\Users;

use App\Domain\Models\User\Type\UserId;

/**
 * class UserSavedResult
 */
final class UserSavedResult
{
    /**
     * constructor
     *
     * @param \App\Domain\Models\User\Type\UserId $userId userId
     */
    public function __construct(
        private UserId $userId
    ) {
    }

    /**
     * 整形する
     *
     * @return array<string,string>
     */
    public function format(): array
    {
        return [
            'userId' => $this->userId->value,
        ];
    }
}
