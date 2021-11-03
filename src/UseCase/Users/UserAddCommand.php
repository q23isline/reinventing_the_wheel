<?php
declare(strict_types=1);

namespace App\UseCase\Users;

use App\Domain\Shared\Exception\ExceptionItem;
use App\Domain\Shared\Exception\ValidateException;

/**
 * class UserAddCommand
 */
final class UserAddCommand
{
    /**
     * @var string
     */
    private string $loginId;

    /**
     * @var string
     */
    private string $password;

    /**
     * @var string
     */
    private string $roleName;

    /**
     * @var string
     */
    private string $firstName;

    /**
     * @var string
     */
    private string $lastName;

    /**
     * @var string
     */
    private string $firstNameKana;

    /**
     * @var string
     */
    private string $lastNameKana;

    /**
     * @var string
     */
    private string $mailAddress;

    /**
     * @var string
     */
    private string $sex;

    /**
     * @var string
     */
    private ?string $birthDay;

    /**
     * @var string
     */
    private ?string $cellPhoneNumber;

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
        ?string $cellPhoneNumber
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
    }

    /**
     * Get the value of loginId
     *
     * @return string
     */
    public function getLoginId(): string
    {
        return $this->loginId;
    }

    /**
     * Get the value of password
     *
     * @return string
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    /**
     * Get the value of roleName
     *
     * @return string
     */
    public function getRoleName(): string
    {
        return $this->roleName;
    }

    /**
     * Get the value of firstName
     *
     * @return string
     */
    public function getFirstName(): string
    {
        return $this->firstName;
    }

    /**
     * Get the value of lastName
     *
     * @return string
     */
    public function getLastName(): string
    {
        return $this->lastName;
    }

    /**
     * Get the value of firstNameKana
     *
     * @return string
     */
    public function getFirstNameKana(): string
    {
        return $this->firstNameKana;
    }

    /**
     * Get the value of lastNameKana
     *
     * @return string
     */
    public function getLastNameKana(): string
    {
        return $this->lastNameKana;
    }

    /**
     * Get the value of mailAddress
     *
     * @return string
     */
    public function getMailAddress(): string
    {
        return $this->mailAddress;
    }

    /**
     * Get the value of sex
     *
     * @return string
     */
    public function getSex(): string
    {
        return $this->sex;
    }

    /**
     * Get the value of birthDay
     *
     * @return string|null
     */
    public function getBirthDay(): ?string
    {
        return $this->birthDay;
    }

    /**
     * Get the value of cellPhoneNumber
     *
     * @return string|null
     */
    public function getCellPhoneNumber(): ?string
    {
        return $this->cellPhoneNumber;
    }

    /**
     * プロパティに値をセットする
     *
     * @param string $propertyName propertyName
     * @param mixed $value value
     * @param array<int,\App\Domain\Shared\Exception\ExceptionItem> $errors errors
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
