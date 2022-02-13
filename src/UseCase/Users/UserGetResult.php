<?php
declare(strict_types=1);

namespace App\UseCase\Users;

/**
 * class UserGetResult
 */
final class UserGetResult
{
    /**
     * constructor
     *
     * @param \App\UseCase\Users\UserData $userData userData
     */
    public function __construct(
        private UserData $userData
    ) {
    }

    /**
     * 整形する
     *
     * @return array<string,array>
     */
    public function format(): array
    {
        return [
            'data' => [
                'id' => $this->userData->id,
                'mailAddress' => $this->userData->mailAddress,
                'roleName' => $this->userData->roleName,
            ],
        ];
    }
}
