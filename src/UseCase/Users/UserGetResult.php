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
                'loginId' => $this->userData->loginId,
                'roleName' => $this->userData->roleName,
                'firstName' => $this->userData->firstName,
                'lastName' => $this->userData->lastName,
                'firstNameKana' => $this->userData->firstNameKana,
                'lastNameKana' => $this->userData->lastNameKana,
                'mailAddress' => $this->userData->mailAddress,
                'sex' => $this->userData->sex,
                'birthDay' => $this->userData->birthDay,
                'cellPhoneNumber' => $this->userData->cellPhoneNumber,
                'remarks' => $this->userData->remarks,
            ],
        ];
    }
}
