<?php
declare(strict_types=1);

namespace App\UseCase\Users;

use App\Domain\Models\User\User;

/**
 * class UserData
 *
 * @property-read string $id id
 * @property-read string $loginId loginId
 * @property-read string $roleName roleName
 * @property-read string $firstName firstName
 * @property-read string $lastName lastName
 * @property-read string $firstNameKana firstNameKana
 * @property-read string $lastNameKana lastNameKana
 * @property-read string $mailAddress mailAddress
 * @property-read string $sex sex
 * @property-read string $birthDay birthDay
 * @property-read string $cellPhoneNumber cellPhoneNumber
 * @property-read string $remarks remarks
 */
final class UserData
{
    public readonly string $id;
    public readonly string $loginId;
    public readonly string $roleName;
    public readonly string $firstName;
    public readonly string $lastName;
    public readonly string $firstNameKana;
    public readonly string $lastNameKana;
    public readonly string $mailAddress;
    public readonly string $sex;
    public readonly string $birthDay;
    public readonly string $cellPhoneNumber;
    public readonly string $remarks;

    /**
     * constructor
     *
     * @param \App\Domain\Models\User\User $source source
     */
    public function __construct(User $source)
    {
        $this->id = $source->id->value;
        $this->loginId = $source->loginId->value;
        $this->roleName = $source->roleName->value;
        $this->firstName = $source->firstName->value;
        $this->lastName = $source->lastName->value;
        $this->firstNameKana = $source->firstNameKana->value;
        $this->lastNameKana = $source->lastNameKana->value;
        $this->mailAddress = $source->mailAddress->value;
        $this->sex = $source->sex->value;
        $this->birthDay = is_null($source->birthDay) ? '' : $source->birthDay->value;
        $this->cellPhoneNumber = is_null($source->cellPhoneNumber) ? '' : $source->cellPhoneNumber->value;
        $this->remarks = is_null($source->remarks) ? '' : $source->remarks->value;
    }
}
