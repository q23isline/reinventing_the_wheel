<?php
declare(strict_types=1);

namespace App\UseCase\Users;

final class UserListResult
{
    /**
     * @var \App\UseCase\Users\UserData[]
     */
    private array $userData;

    /**
     * constructor
     *
     * @param \App\UseCase\Users\UserData[] $userData userData
     */
    public function __construct(array $userData)
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
        $data = [];
        foreach ($this->userData as $source) {
            $data[] = [
                'id' => $source->getId(),
                'loginId' => $source->getLoginId(),
                'roleName' => $source->getRoleName(),
                'firstName' => $source->getFirstName(),
                'lastName' => $source->getLastName(),
                'created' => $source->getCreated(),
                'modified' => $source->getModified(),
            ];
        }

        return [
            'data' => $data,
        ];
    }
}
