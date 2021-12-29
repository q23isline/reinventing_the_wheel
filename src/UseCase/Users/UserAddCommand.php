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

        $this->setProperty('loginId', $loginId, $errors);
        $this->setProperty('password', $password, $errors);
        $this->setProperty('roleName', $roleName, $errors);
        $this->setProperty('firstName', $firstName, $errors);
        $this->setProperty('lastName', $lastName, $errors);
        $this->setProperty('firstNameKana', $firstNameKana, $errors);
        $this->setProperty('lastNameKana', $lastNameKana, $errors);
        $this->setProperty('mailAddress', $mailAddress, $errors);
        $this->setProperty('sex', $sex, $errors);

        if (count($errors) > 0) {
            throw new ValidateException($errors);
        }

        $this->birthDay = $birthDay;
        $this->cellPhoneNumber = $cellPhoneNumber;
        $this->remarks = $remarks;
    }

    /**
     * プロパティに値をセットする
     *
     * @param string $propertyName propertyName
     * @param mixed $value value
     * @param \App\Domain\Shared\Exception\ExceptionItem[] $errors errors
     * @return void
     */
    private function setProperty(string $propertyName, $value, array &$errors): void
    {
        if (empty($value)) {
            $errors[] = new ExceptionItem($propertyName, '必須項目が不足しています。');
        } else {
            $this->{$propertyName} = $value;
        }
    }
}
