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
use App\Domain\Models\User\Type\Remarks;
use App\Domain\Models\User\Type\RoleName;
use App\Domain\Models\User\Type\Sex;
use App\Domain\Models\User\Type\UserId;

/**
 * class User
 *
 * @property \App\Domain\Models\User\Type\UserId $id id
 * @property \App\Domain\Models\User\Type\LoginId $loginId loginId
 * @property \App\Domain\Models\User\Type\Password $password password
 * @property \App\Domain\Models\User\Type\RoleName $roleName roleName
 * @property \App\Domain\Models\User\Type\FirstName $firstName firstName
 * @property \App\Domain\Models\User\Type\LastName $lastName lastName
 * @property \App\Domain\Models\User\Type\FirstNameKana $firstNameKana firstNameKana
 * @property \App\Domain\Models\User\Type\LastNameKana $lastNameKana lastNameKana
 * @property \App\Domain\Models\User\Type\MailAddress $mailAddress mailAddress
 * @property \App\Domain\Models\User\Type\Sex $sex sex
 * @property \App\Domain\Models\User\Type\BirthDay|null $birthDay birthDay
 * @property \App\Domain\Models\User\Type\CellPhoneNumber|null $cellPhoneNumber cellPhoneNumber
 * @property \App\Domain\Models\User\Type\Remarks|null $remarks remarks
 */
final class User
{
    private UserId $id;
    private LoginId $loginId;
    private Password $password;
    private RoleName $roleName;
    private FirstName $firstName;
    private LastName $lastName;
    private FirstNameKana $firstNameKana;
    private LastNameKana $lastNameKana;
    private MailAddress $mailAddress;
    private Sex $sex;
    private ?BirthDay $birthDay = null;
    private ?CellPhoneNumber $cellPhoneNumber = null;
    private ?Remarks $remarks = null;

    /**
     * constructor
     *
     * @param \App\Domain\Models\User\Type\UserId $id id
     * @param \App\Domain\Models\User\Type\LoginId $loginId loginId
     * @param \App\Domain\Models\User\Type\Password $password password
     * @param \App\Domain\Models\User\Type\RoleName $roleName roleName
     * @param \App\Domain\Models\User\Type\FirstName $firstName firstName
     * @param \App\Domain\Models\User\Type\LastName $lastName lastName
     * @param \App\Domain\Models\User\Type\FirstNameKana $firstNameKana firstNameKana
     * @param \App\Domain\Models\User\Type\LastNameKana $lastNameKana lastNameKana
     * @param \App\Domain\Models\User\Type\MailAddress $mailAddress mailAddress
     * @param \App\Domain\Models\User\Type\Sex $sex sex
     * @param \App\Domain\Models\User\Type\BirthDay|null $birthDay birthDay
     * @param \App\Domain\Models\User\Type\CellPhoneNumber|null $cellPhoneNumber cellPhoneNumber
     * @param \App\Domain\Models\User\Type\Remarks|null $remarks remarks
     * @return void
     */
    private function __construct(
        UserId $id,
        LoginId $loginId,
        Password $password,
        RoleName $roleName,
        FirstName $firstName,
        LastName $lastName,
        FirstNameKana $firstNameKana,
        LastNameKana $lastNameKana,
        MailAddress $mailAddress,
        Sex $sex,
        ?BirthDay $birthDay,
        ?CellPhoneNumber $cellPhoneNumber,
        ?Remarks $remarks
    ) {
        $this->id = $id;
        $this->loginId = $loginId;
        $this->password = $password;
        $this->roleName = $roleName;
        $this->firstName = $firstName;
        $this->lastName = $lastName;
        $this->firstNameKana = $firstNameKana;
        $this->lastNameKana = $lastNameKana;
        $this->mailAddress = $mailAddress;
        $this->sex = $sex;
        $this->birthDay = $birthDay;
        $this->cellPhoneNumber = $cellPhoneNumber;
        $this->remarks = $remarks;
    }

    /**
     * 新規作成
     * TODO: UserId を引数からなくしたい
     *
     * @param \App\Domain\Models\User\Type\UserId $id id
     * @param \App\Domain\Models\User\Type\LoginId $loginId loginId
     * @param \App\Domain\Models\User\Type\Password $password password
     * @param \App\Domain\Models\User\Type\RoleName $roleName roleName
     * @param \App\Domain\Models\User\Type\FirstName $firstName firstName
     * @param \App\Domain\Models\User\Type\LastName $lastName lastName
     * @param \App\Domain\Models\User\Type\FirstNameKana $firstNameKana firstNameKana
     * @param \App\Domain\Models\User\Type\LastNameKana $lastNameKana lastNameKana
     * @param \App\Domain\Models\User\Type\MailAddress $mailAddress mailAddress
     * @param \App\Domain\Models\User\Type\Sex $sex sex
     * @param \App\Domain\Models\User\Type\BirthDay|null $birthDay birthDay
     * @param \App\Domain\Models\User\Type\CellPhoneNumber|null $cellPhoneNumber cellPhoneNumber
     * @param \App\Domain\Models\User\Type\Remarks|null $remarks remarks
     * @return self
     */
    public static function create(
        UserId $id,
        LoginId $loginId,
        Password $password,
        RoleName $roleName,
        FirstName $firstName,
        LastName $lastName,
        FirstNameKana $firstNameKana,
        LastNameKana $lastNameKana,
        MailAddress $mailAddress,
        Sex $sex,
        ?BirthDay $birthDay,
        ?CellPhoneNumber $cellPhoneNumber,
        ?Remarks $remarks
    ): self {
        return new self(
            $id,
            $loginId,
            $password,
            $roleName,
            $firstName,
            $lastName,
            $firstNameKana,
            $lastNameKana,
            $mailAddress,
            $sex,
            $birthDay,
            $cellPhoneNumber,
            $remarks,
        );
    }

    /**
     * 再構成
     *
     * @param \App\Domain\Models\User\Type\UserId $id id
     * @param \App\Domain\Models\User\Type\LoginId $loginId loginId
     * @param \App\Domain\Models\User\Type\Password $password password
     * @param \App\Domain\Models\User\Type\RoleName $roleName roleName
     * @param \App\Domain\Models\User\Type\FirstName $firstName firstName
     * @param \App\Domain\Models\User\Type\LastName $lastName lastName
     * @param \App\Domain\Models\User\Type\FirstNameKana $firstNameKana firstNameKana
     * @param \App\Domain\Models\User\Type\LastNameKana $lastNameKana lastNameKana
     * @param \App\Domain\Models\User\Type\MailAddress $mailAddress mailAddress
     * @param \App\Domain\Models\User\Type\Sex $sex sex
     * @param \App\Domain\Models\User\Type\BirthDay|null $birthDay birthDay
     * @param \App\Domain\Models\User\Type\CellPhoneNumber|null $cellPhoneNumber cellPhoneNumber
     * @param \App\Domain\Models\User\Type\Remarks|null $remarks remarks
     * @return self
     */
    public static function reconstruct(
        UserId $id,
        LoginId $loginId,
        Password $password,
        RoleName $roleName,
        FirstName $firstName,
        LastName $lastName,
        FirstNameKana $firstNameKana,
        LastNameKana $lastNameKana,
        MailAddress $mailAddress,
        Sex $sex,
        ?BirthDay $birthDay,
        ?CellPhoneNumber $cellPhoneNumber,
        ?Remarks $remarks
    ): self {
        return new self(
            $id,
            $loginId,
            $password,
            $roleName,
            $firstName,
            $lastName,
            $firstNameKana,
            $lastNameKana,
            $mailAddress,
            $sex,
            $birthDay,
            $cellPhoneNumber,
            $remarks,
        );
    }

    /**
     * 更新
     *
     * @param \App\Domain\Models\User\Type\LoginId $loginId loginId
     * @param \App\Domain\Models\User\Type\Password $password password
     * @param \App\Domain\Models\User\Type\RoleName $roleName roleName
     * @param \App\Domain\Models\User\Type\FirstName $firstName firstName
     * @param \App\Domain\Models\User\Type\LastName $lastName lastName
     * @param \App\Domain\Models\User\Type\FirstNameKana $firstNameKana firstNameKana
     * @param \App\Domain\Models\User\Type\LastNameKana $lastNameKana lastNameKana
     * @param \App\Domain\Models\User\Type\MailAddress $mailAddress mailAddress
     * @param \App\Domain\Models\User\Type\Sex $sex sex
     * @param \App\Domain\Models\User\Type\BirthDay|null $birthDay birthDay
     * @param \App\Domain\Models\User\Type\CellPhoneNumber|null $cellPhoneNumber cellPhoneNumber
     * @param \App\Domain\Models\User\Type\Remarks|null $remarks remarks
     * @return void
     */
    public function update(
        LoginId $loginId,
        Password $password,
        RoleName $roleName,
        FirstName $firstName,
        LastName $lastName,
        FirstNameKana $firstNameKana,
        LastNameKana $lastNameKana,
        MailAddress $mailAddress,
        Sex $sex,
        ?BirthDay $birthDay,
        ?CellPhoneNumber $cellPhoneNumber,
        ?Remarks $remarks
    ): void {
        $this->loginId = $loginId;
        $this->password = $password;
        $this->roleName = $roleName;
        $this->firstName = $firstName;
        $this->lastName = $lastName;
        $this->firstNameKana = $firstNameKana;
        $this->lastNameKana = $lastNameKana;
        $this->mailAddress = $mailAddress;
        $this->sex = $sex;
        $this->birthDay = $birthDay;
        $this->cellPhoneNumber = $cellPhoneNumber;
        $this->remarks = $remarks;
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
     * Get the value of password
     *
     * @return \App\Domain\Models\User\Type\Password
     */
    public function getPassword(): Password
    {
        return $this->password;
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
     * Get the value of firstName
     *
     * @return \App\Domain\Models\User\Type\FirstName
     */
    public function getFirstName(): FirstName
    {
        return $this->firstName;
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
     * Get the value of firstNameKana
     *
     * @return \App\Domain\Models\User\Type\FirstNameKana
     */
    public function getFirstNameKana(): FirstNameKana
    {
        return $this->firstNameKana;
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
     * Get the value of mailAddress
     *
     * @return \App\Domain\Models\User\Type\MailAddress
     */
    public function getMailAddress(): MailAddress
    {
        return $this->mailAddress;
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
     * Get the value of birthDay
     *
     * @return \App\Domain\Models\User\Type\BirthDay|null
     */
    public function getBirthDay(): ?BirthDay
    {
        return $this->birthDay;
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
     * Get the value of remarks
     *
     * @return \App\Domain\Models\User\Type\Remarks|null
     */
    public function getRemarks(): ?Remarks
    {
        return $this->remarks;
    }
}
