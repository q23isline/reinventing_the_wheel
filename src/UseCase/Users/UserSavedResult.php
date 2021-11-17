<?php
declare(strict_types=1);

namespace App\UseCase\Users;

use App\Domain\Models\User\Type\UserId;

/**
 * class UserSavedResult
 */
final class UserSavedResult
{
    private UserId $userId;

    /**
     * constructor
     *
     * @param \App\Domain\Models\User\Type\UserId $userId userId
     */
    public function __construct(UserId $userId)
    {
        $this->userId = $userId;
    }

    /**
     * 整形する
     *
     * @return array<string,string>
     */
    public function format(): array
    {
        return [
            'userId' => $this->userId->getValue(),
        ];
    }
}
