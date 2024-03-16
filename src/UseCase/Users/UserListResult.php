<?php
declare(strict_types=1);

namespace App\UseCase\Users;

/**
 * class UserListResult
 */
final class UserListResult
{
    /**
     * constructor
     *
     * @param array<\App\UseCase\Users\UserData> $userData userData
     */
    public function __construct(
        private array $userData
    ) {
    }

    /**
     * 整形する
     *
     * @return array<string,array<mixed>>
     */
    public function format(): array
    {
        $data = [];
        foreach ($this->userData as $source) {
            $data[] = [
                'id' => $source->id,
                'mailAddress' => $source->mailAddress,
                'roleName' => $source->roleName,
            ];
        }

        return [
            'data' => $data,
        ];
    }
}
