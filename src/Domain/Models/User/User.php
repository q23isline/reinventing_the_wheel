<?php
declare(strict_types=1);

namespace App\Domain\Models\User;

use App\Domain\Models\User\Type\BirthDay;
use App\Domain\Models\User\Type\CellPhoneNumber;
use App\Domain\Models\User\Type\FirstName;
use App\Domain\Models\User\Type\FirstNameKana;
use App\Domain\Models\User\Type\LastName;
use App\Domain\Models\User\Type\LastNameKana;
use App\Domain\Models\User\Type\LoginId;
use App\Domain\Models\User\Type\MailAddress;
use App\Domain\Models\User\Type\Password;
use App\Domain\Models\User\Type\RoleName;
use App\Domain\Models\User\Type\Sex;
use App\Domain\Models\User\Type\UserId;

/**
 * class User
 */
final class User
{
    /**
     * @var \App\Domain\Models\User\Type\UserId
     */
    private UserId $id;

    /**
     * @var \App\Domain\Models\User\Type\LoginId
     */
    private LoginId $loginId;

    /**
     * @var \App\Domain\Models\User\Type\Password
     */
    private Password $password;

    /**
     * @var \App\Domain\Models\User\Type\RoleName
     */
    private RoleName $roleName;

    /**
     * @var \App\Domain\Models\User\Type\FirstName
     */
    private FirstName $firstName;

    /**
     * @var \App\Domain\Models\User\Type\LastName
     */
    private LastName $lastName;

    /**
     * @var \App\Domain\Models\User\Type\FirstNameKana
     */
    private FirstNameKana $firstNameKana;

    /**
     * @var \App\Domain\Models\User\Type\LastNameKana
     */
    private LastNameKana $lastNameKana;

    /**
     * @var \App\Domain\Models\User\Type\MailAddress
     */
    private MailAddress $mailAddress;

    /**
     * @var \App\Domain\Models\User\Type\Sex
     */
    private Sex $sex;

    /**
     * @var \App\Domain\Models\User\Type\BirthDay|null
     */
    private ?BirthDay $birthDay = null;

    /**
     * @var \App\Domain\Models\User\Type\CellPhoneNumber|null
     */
    private ?CellPhoneNumber $cellPhoneNumber = null;

    /**
     * constructor
     *
     * @param \App\Domain\Models\User\Type\UserId $id id
     */
    public function __construct(UserId $id)
    {
        $this->id = $id;
    }

    /**
     * isMyself
     *
     * @param \App\Domain\Models\User\User $other other
     * @return bool
     */
    public function isMyself(User $other): bool
    {
        if ($this === $other) {
            // 同じクラスの同じインスタンスであれば true
            return true;
        }

        return $this->id->getValue() === $other->getId()->getValue();
    }

    /**
     * Get the value of id
     *
     * @return \App\Domain\Models\User\Type\UserId
     */
    public function getId(): UserId
    {
        return $this->id;
    }

    /**
     * Get the value of loginId
     *
     * @return \App\Domain\Models\User\Type\LoginId
     */
    public function getLoginId(): LoginId
    {
        return $this->loginId;
    }

    /**
     * Set the value of loginId
     *
     * @param \App\Domain\Models\User\Type\LoginId $loginId loginId
     * @return void
     */
    public function setLoginId(LoginId $loginId): void
    {
        $this->loginId = $loginId;
    }

    /**
     * Get the value of password
     *
     * @return \App\Domain\Models\User\Type\Password
     */
    public function getPassword(): Password
    {
        return $this->password;
    }

    /**
     * Set the value of password
     *
     * @param \App\Domain\Models\User\Type\Password $password password
     * @return void
     */
    public function setPassword(Password $password): void
    {
        $this->password = $password;
    }

    /**
     * Get the value of roleName
     *
     * @return \App\Domain\Models\User\Type\RoleName
     */
    public function getRoleName(): RoleName
    {
        return $this->roleName;
    }

    /**
     * Set the value of roleName
     *
     * @param \App\Domain\Models\User\Type\RoleName $roleName roleName
     * @return void
     */
    public function setRoleName(RoleName $roleName): void
    {
        $this->roleName = $roleName;
    }

    /**
     * Get the value of firstName
     *
     * @return \App\Domain\Models\User\Type\FirstName
     */
    public function getFirstName(): FirstName
    {
        return $this->firstName;
    }

    /**
     * Set the value of firstName
     *
     * @param \App\Domain\Models\User\Type\FirstName $firstName firstName
     * @return void
     */
    public function setFirstName(FirstName $firstName): void
    {
        $this->firstName = $firstName;
    }

    /**
     * Get the value of lastName
     *
     * @return \App\Domain\Models\User\Type\LastName
     */
    public function getLastName(): LastName
    {
        return $this->lastName;
    }

    /**
     * Set the value of lastName
     *
     * @param \App\Domain\Models\User\Type\LastName $lastName lastName
     * @return void
     */
    public function setLastName(LastName $lastName): void
    {
        $this->lastName = $lastName;
    }

    /**
     * Get the value of firstNameKana
     *
     * @return \App\Domain\Models\User\Type\FirstNameKana
     */
    public function getFirstNameKana(): FirstNameKana
    {
        return $this->firstNameKana;
    }

    /**
     * Set the value of firstNameKana
     *
     * @param \App\Domain\Models\User\Type\FirstNameKana $firstNameKana firstNameKana
     * @return void
     */
    public function setFirstNameKana(FirstNameKana $firstNameKana): void
    {
        $this->firstNameKana = $firstNameKana;
    }

    /**
     * Get the value of lastNameKana
     *
     * @return \App\Domain\Models\User\Type\LastNameKana
     */
    public function getLastNameKana(): LastNameKana
    {
        return $this->lastNameKana;
    }

    /**
     * Set the value of lastNameKana
     *
     * @param \App\Domain\Models\User\Type\LastNameKana $lastNameKana lastNameKana
     * @return void
     */
    public function setLastNameKana(LastNameKana $lastNameKana): void
    {
        $this->lastNameKana = $lastNameKana;
    }

    /**
     * Get the value of mailAddress
     *
     * @return \App\Domain\Models\User\Type\MailAddress
     */
    public function getMailAddress(): MailAddress
    {
        return $this->mailAddress;
    }

    /**
     * Set the value of mailAddress
     *
     * @param \App\Domain\Models\User\Type\MailAddress $mailAddress mailAddress
     * @return void
     */
    public function setMailAddress(MailAddress $mailAddress): void
    {
        $this->mailAddress = $mailAddress;
    }

    /**
     * Get the value of sex
     *
     * @return \App\Domain\Models\User\Type\Sex
     */
    public function getSex(): Sex
    {
        return $this->sex;
    }

    /**
     * Set the value of sex
     *
     * @param \App\Domain\Models\User\Type\Sex $sex sex
     * @return void
     */
    public function setSex(Sex $sex): void
    {
        $this->sex = $sex;
    }

    /**
     * Get the value of birthDay
     *
     * @return \App\Domain\Models\User\Type\BirthDay|null
     */
    public function getBirthDay(): ?BirthDay
    {
        return $this->birthDay;
    }

    /**
     * Set the value of birthDay
     *
     * @param \App\Domain\Models\User\Type\BirthDay|null $birthDay birthDay
     * @return void
     */
    public function setBirthDay(?BirthDay $birthDay): void
    {
        $this->birthDay = $birthDay;
    }

    /**
     * Get the value of cellPhoneNumber
     *
     * @return \App\Domain\Models\User\Type\CellPhoneNumber|null
     */
    public function getCellPhoneNumber(): ?CellPhoneNumber
    {
        return $this->cellPhoneNumber;
    }

    /**
     * Set the value of cellPhoneNumber
     *
     * @param \App\Domain\Models\User\Type\CellPhoneNumber|null $cellPhoneNumber cellPhoneNumber
     * @return void
     */
    public function setCellPhoneNumber(?CellPhoneNumber $cellPhoneNumber): void
    {
        $this->cellPhoneNumber = $cellPhoneNumber;
    }
}
