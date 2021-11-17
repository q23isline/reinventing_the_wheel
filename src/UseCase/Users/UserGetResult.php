<?php
declare(strict_types=1);

namespace App\UseCase\Users;

/**
 * class UserGetResult
 *
 * @property \App\UseCase\Users\UserData $userData userData
 */
final class UserGetResult
{
    private UserData $userData;

    /**
     * constructor
     *
     * @param \App\UseCase\Users\UserData $userData userData
     */
    public function __construct(UserData $userData)
    {
        $this->userData = $userData;
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
                'id' => $this->userData->getId(),
                'loginId' => $this->userData->getLoginId(),
                'roleName' => $this->userData->getRoleName(),
                'firstName' => $this->userData->getFirstName(),
                'lastName' => $this->userData->getLastName(),
                'firstNameKana' => $this->userData->getFirstNameKana(),
                'lastNameKana' => $this->userData->getLastNameKana(),
                'mailAddress' => $this->userData->getMailAddress(),
                'sex' => $this->userData->getSex(),
                'birthDay' => $this->userData->getBirthDay(),
                'cellPhoneNumber' => $this->userData->getCellPhoneNumber(),
                'remarks' => $this->userData->getRemarks(),
            ],
        ];
    }
}
