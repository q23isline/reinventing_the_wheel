<?php
declare(strict_types=1);

namespace App\UseCase\Profiles;

use App\Domain\Shared\Exception\ExceptionItem;
use App\Domain\Shared\Exception\ValidateException;

/**
 * class ProfileUpdateCommand
 *
 * @property-read string $profileId profileId
 * @property-read string $firstName firstName
 * @property-read string $lastName lastName
 * @property-read string $firstNameKana firstNameKana
 * @property-read string $lastNameKana lastNameKana
 * @property-read string $sex sex
 * @property-read string|null $birthDay birthDay
 * @property-read string|null $cellPhoneNumber cellPhoneNumber
 * @property-read string|null $remarks remarks
 */
final class ProfileUpdateCommand
{
    public readonly string $profileId;
    public readonly string $firstName;
    public readonly string $lastName;
    public readonly string $firstNameKana;
    public readonly string $lastNameKana;
    public readonly string $sex;
    public readonly ?string $birthDay;
    public readonly ?string $cellPhoneNumber;
    public readonly ?string $remarks;

    /**
     * constructor
     *
     * @param string $profileId profileId
     * @param string|null $firstName firstName
     * @param string|null $lastName lastName
     * @param string|null $firstNameKana firstNameKana
     * @param string|null $lastNameKana lastNameKana
     * @param string|null $sex sex
     * @param string|null $birthDay birthDay
     * @param string|null $cellPhoneNumber cellPhoneNumber
     * @param string|null $remarks remarks
     * @throws \App\Domain\Shared\Exception\ValidateException
     */
    public function __construct(
        string $profileId,
        ?string $firstName,
        ?string $lastName,
        ?string $firstNameKana,
        ?string $lastNameKana,
        ?string $sex,
        ?string $birthDay,
        ?string $cellPhoneNumber,
        ?string $remarks
    ) {
        $errors = [];

        if (empty($firstName)) {
            $errors[] = new ExceptionItem('firstName', '必須項目が不足しています。');
        }

        if (empty($lastName)) {
            $errors[] = new ExceptionItem('lastName', '必須項目が不足しています。');
        }

        if (empty($firstNameKana)) {
            $errors[] = new ExceptionItem('firstNameKana', '必須項目が不足しています。');
        }

        if (empty($lastNameKana)) {
            $errors[] = new ExceptionItem('lastNameKana', '必須項目が不足しています。');
        }

        if (empty($sex)) {
            $errors[] = new ExceptionItem('sex', '必須項目が不足しています。');
        }

        if (empty($firstName) || empty($lastName) || empty($firstNameKana) || empty($lastNameKana) || empty($sex)) {
            throw new ValidateException($errors);
        }

        $this->firstName = $firstName;
        $this->lastName = $lastName;
        $this->firstNameKana = $firstNameKana;
        $this->lastNameKana = $lastNameKana;
        $this->sex = $sex;
        $this->birthDay = $birthDay;
        $this->cellPhoneNumber = $cellPhoneNumber;
        $this->remarks = $remarks;
        $this->profileId = $profileId;
    }
}
