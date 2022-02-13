<?php
declare(strict_types=1);

namespace App\UseCase\Profiles;

/**
 * class ProfileGetResult
 */
final class ProfileGetResult
{
    /**
     * constructor
     *
     * @param \App\UseCase\Profiles\ProfileData $profileData profileData
     */
    public function __construct(
        private ProfileData $profileData
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
                'id' => $this->profileData->id,
                'firstName' => $this->profileData->firstName,
                'lastName' => $this->profileData->lastName,
                'firstNameKana' => $this->profileData->firstNameKana,
                'lastNameKana' => $this->profileData->lastNameKana,
                'sex' => $this->profileData->sex,
                'birthDay' => $this->profileData->birthDay,
                'cellPhoneNumber' => $this->profileData->cellPhoneNumber,
                'remarks' => $this->profileData->remarks,
            ],
        ];
    }
}
