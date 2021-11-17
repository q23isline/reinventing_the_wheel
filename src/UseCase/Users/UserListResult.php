<?php
declare(strict_types=1);

namespace App\UseCase\Users;

/**
 * class UserListResult
 *
 * @property \App\UseCase\Users\UserData[] $userData userData
 */
final class UserListResult
{
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
     * @return array<string,array>
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
                'firstNameKana' => $source->getFirstNameKana(),
                'lastNameKana' => $source->getLastNameKana(),
                'mailAddress' => $source->getMailAddress(),
                'sex' => $source->getSex(),
                'birthDay' => $source->getBirthDay(),
                'cellPhoneNumber' => $source->getCellPhoneNumber(),
                'remarks' => $source->getRemarks(),
            ];
        }

        return [
            'data' => $data,
        ];
    }
}
