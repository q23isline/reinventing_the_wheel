<?php
declare(strict_types=1);

namespace App\UseCase\Users;

use App\Domain\Shared\Exception\ExceptionItem;
use App\Domain\Shared\Exception\ValidateException;

/**
 * class UserAddCommand
 *
 * @property-read string $loginId loginId
 * @property-read string $password password
 * @property-read string $roleName roleName
 * @property-read string $firstName firstName
 * @property-read string $lastName lastName
 * @property-read string $firstNameKana firstNameKana
 * @property-read string $lastNameKana lastNameKana
 * @property-read string $mailAddress mailAddress
 * @property-read string $sex sex
 * @property-read string|null $birthDay birthDay
 * @property-read string|null $cellPhoneNumber cellPhoneNumber
 * @property-read string|null $remarks remarks
 */
final class UserAddCommand
{
    public readonly string $loginId;
    public readonly string $password;
    public readonly string $roleName;
    public readonly string $firstName;
    public readonly string $lastName;
    public readonly string $firstNameKana;
    public readonly string $lastNameKana;
    public readonly string $mailAddress;
    public readonly string $sex;
    public readonly ?string $birthDay;
    public readonly ?string $cellPhoneNumber;
    public readonly ?string $remarks;

    /**
     * constructor
     *
     * @param string|null $loginId loginId
     * @param string|null $password password
     * @param string|null $roleName roleName
     * @param string|null $firstName firstName
     * @param string|null $lastName lastName
     * @param string|null $firstNameKana firstNameKana
     * @param string|null $lastNameKana lastNameKana
     * @param string|null $mailAddress mailAddress
     * @param string|null $sex sex
     * @param string|null $birthDay birthDay
     * @param string|null $cellPhoneNumber cellPhoneNumber
     * @param string|null $remarks remarks
     * @throws \App\Domain\Shared\Exception\ValidateException
     */
    public function __construct(
        ?string $loginId,
        ?string $password,
        ?string $roleName,
        ?string $firstName,
        ?string $lastName,
        ?string $firstNameKana,
        ?string $lastNameKana,
        ?string $mailAddress,
        ?string $sex,
        ?string $birthDay,
        ?string $cellPhoneNumber,
        ?string $remarks
    ) {
        $errors = [];

        if (empty($loginId)) {
            $errors[] = new ExceptionItem('loginId', '必須項目が不足しています。');
        } else {
            $this->loginId = $loginId;
        }

        if (empty($password)) {
            $errors[] = new ExceptionItem('password', '必須項目が不足しています。');
        } else {
            $this->password = $password;
        }

        if (empty($roleName)) {
            $errors[] = new ExceptionItem('roleName', '必須項目が不足しています。');
        } else {
            $this->roleName = $roleName;
        }

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

        if (empty($mailAddress)) {
            $errors[] = new ExceptionItem('mailAddress', '必須項目が不足しています。');
        } else {
            $this->mailAddress = $mailAddress;
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
    }
}
