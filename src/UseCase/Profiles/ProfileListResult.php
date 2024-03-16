<?php
declare(strict_types=1);

namespace App\UseCase\Profiles;

/**
 * class ProfileListResult
 */
final class ProfileListResult
{
    /**
     * constructor
     *
     * @param array<\App\UseCase\Profiles\ProfileData> $profileData profileData
     */
    public function __construct(
        private array $profileData
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
        foreach ($this->profileData as $source) {
            $data[] = [
                'id' => $source->id,
                'firstName' => $source->firstName,
                'lastName' => $source->lastName,
                'firstNameKana' => $source->firstNameKana,
                'lastNameKana' => $source->lastNameKana,
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
