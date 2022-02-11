<?php
declare(strict_types=1);

namespace App\UseCase\Profiles;

use App\Domain\Models\Profile\Profile;

/**
 * class ProfileData
 *
 * @property-read string $id id
 * @property-read string $firstName firstName
 * @property-read string $lastName lastName
 * @property-read string $firstNameKana firstNameKana
 * @property-read string $lastNameKana lastNameKana
 * @property-read string $sex sex
 * @property-read string $birthDay birthDay
 * @property-read string $cellPhoneNumber cellPhoneNumber
 * @property-read string $remarks remarks
 */
final class ProfileData
{
    public readonly string $id;
    public readonly string $firstName;
    public readonly string $lastName;
    public readonly string $firstNameKana;
    public readonly string $lastNameKana;
    public readonly string $sex;
    public readonly string $birthDay;
    public readonly string $cellPhoneNumber;
    public readonly string $remarks;

    /**
     * constructor
     *
     * @param \App\Domain\Models\Profile\Profile $source source
     */
    public function __construct(Profile $source)
    {
        $this->id = $source->id->value;
        $this->firstName = $source->firstName->value;
        $this->lastName = $source->lastName->value;
        $this->firstNameKana = $source->firstNameKana->value;
        $this->lastNameKana = $source->lastNameKana->value;
        $this->sex = $source->sex->value;
        $this->birthDay = is_null($source->birthDay) ? '' : $source->birthDay->value;
        $this->cellPhoneNumber = is_null($source->cellPhoneNumber) ? '' : $source->cellPhoneNumber->value;
        $this->remarks = is_null($source->remarks) ? '' : $source->remarks->value;
    }
}
