<?php
declare(strict_types=1);

namespace App\UseCase\Users;

final class UserGetResult
{
    /**
     * @var UserData
     */
    private UserData $userData;

    /**
     * constructor
     *
     * @param UserData $userData userData
     */
    public function __construct(UserData $userData)
    {
        $this->userData = $userData;
    }

    /**
     * 整形する
     *
     * @return array
     */
    public function format(): array
    {
        return [
            'data' => [
                'id' => $this->userData->getId(),
                'loginId' => $this->userData->getLoginId(),
                'roleName' => $this->userData->getRoleName(),
                'firstName' => $this->userData->getFirstName(),
                'lastName' => $this->userData->getLastName(),
                'created' => $this->userData->getCreated(),
                'modified' => $this->userData->getModified(),
            ],
        ];
    }
}
