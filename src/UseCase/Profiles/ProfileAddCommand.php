<?php
declare(strict_types=1);

namespace App\UseCase\Profiles;

use App\Domain\Shared\Exception\ExceptionItem;
use App\Domain\Shared\Exception\ValidateException;

/**
 * class ProfileAddCommand
 *
 * @property-read string $userId userId
 * @property-read string $firstName firstName
 * @property-read string $lastName lastName
 * @property-read string $firstNameKana firstNameKana
 * @property-read string $lastNameKana lastNameKana
 * @property-read string $sex sex
 * @property-read string|null $birthDay birthDay
 * @property-read string|null $cellPhoneNumber cellPhoneNumber
 * @property-read string|null $remarks remarks
 * @property-read string|null $profileImageFileId profileImageFileId
 */
final class ProfileAddCommand
{
    public readonly string $userId;
    public readonly string $firstName;
    public readonly string $lastName;
    public readonly string $firstNameKana;
    public readonly string $lastNameKana;
    public readonly string $sex;
    public readonly ?string $birthDay;
    public readonly ?string $cellPhoneNumber;
    public readonly ?string $remarks;
    public readonly ?string $profileImageFileId;

    /**
     * constructor
     *
     * @param string $userId userId
     * @param string|null $firstName firstName
     * @param string|null $lastName lastName
     * @param string|null $firstNameKana firstNameKana
     * @param string|null $lastNameKana lastNameKana
     * @param string|null $sex sex
     * @param string|null $birthDay birthDay
     * @param string|null $cellPhoneNumber cellPhoneNumber
     * @param string|null $remarks remarks
     * @param string|null $profileImageFileId profileImageFileId
     * @throws \App\Domain\Shared\Exception\ValidateException
     */
    public function __construct(
        string $userId,
        ?string $firstName,
        ?string $lastName,
        ?string $firstNameKana,
        ?string $lastNameKana,
        ?string $sex,
        ?string $birthDay,
        ?string $cellPhoneNumber,
        ?string $remarks,
        ?string $profileImageFileId
    ) {
        $errors = [];
        $this->userId = $userId;

        if (empty($firstName)) {
            $errors[] = new ExceptionItem('firstName', '必須項目が不足しています。');
        } else {
            $this->firstName = $firstName;
        }

        if (empty($lastName)) {
            $errors[] = new ExceptionItem('lastName', '必須項目が不足しています。');
        } else {
            $this->lastName = $lastName;
        }

        if (empty($firstNameKana)) {
            $errors[] = new ExceptionItem('firstNameKana', '必須項目が不足しています。');
        } else {
            $this->firstNameKana = $firstNameKana;
        }

        if (empty($lastNameKana)) {
            $errors[] = new ExceptionItem('lastNameKana', '必須項目が不足しています。');
        } else {
            $this->lastNameKana = $lastNameKana;
        }

        if (empty($sex)) {
            $errors[] = new ExceptionItem('sex', '必須項目が不足しています。');
        } else {
            $this->sex = $sex;
        }

        if (count($errors) > 0) {
            throw new ValidateException($errors);
        }

        $this->birthDay = $birthDay;
        $this->cellPhoneNumber = $cellPhoneNumber;
        $this->remarks = $remarks;
        $this->profileImageFileId = $profileImageFileId;
    }
}
