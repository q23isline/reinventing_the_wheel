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
     * @param \App\UseCase\Users\UserData[] $userData userData
     */
    public function __construct(
        private array $userData
    ) {
    }

    /**
     * 整形する
     *
     * @return array<string,array>
     */
    public function format(): array
    {
        $data = [];
        foreach ($this->userData as $source) {
            $data[] = [
                'id' => $source->id,
                'loginId' => $source->loginId,
                'roleName' => $source->roleName,
                'firstName' => $source->firstName,
                'lastName' => $source->lastName,
                'firstNameKana' => $source->firstNameKana,
                'lastNameKana' => $source->lastNameKana,
                'mailAddress' => $source->mailAddress,
                'sex' => $source->sex,
                'birthDay' => $source->birthDay,
                'cellPhoneNumber' => $source->cellPhoneNumber,
                'remarks' => $source->remarks,
            ];
        }

        return [
            'data' => $data,
        ];
    }
}
