<?php
declare(strict_types=1);

namespace App\UseCase\Users;

use App\Domain\Models\User\User;

/**
 * class UserData
 */
final class UserData
{
    private string $id;
    private string $loginId;
    private string $roleName;
    private string $firstName;
    private string $lastName;
    private string $firstNameKana;
    private string $lastNameKana;
    private string $mailAddress;
    private string $sex;
    private string $birthDay;
    private string $cellPhoneNumber;
    private string $remarks;

    /**
     * constructor
     *
     * @param \App\Domain\Models\User\User $source source
     */
    public function __construct(User $source)
    {
        $this->id = $source->getId()->getValue();
        $this->loginId = $source->getLoginId()->getValue();
        $this->roleName = $source->getRoleName()->getValue();
        $this->firstName = $source->getFirstName()->getValue();
        $this->lastName = $source->getLastName()->getValue();
        $this->firstNameKana = $source->getFirstNameKana()->getValue();
        $this->lastNameKana = $source->getLastNameKana()->getValue();
        $this->mailAddress = $source->getMailAddress()->getValue();
        $this->sex = $source->getSex()->getValue();
        $this->birthDay = is_null($source->getBirthDay()) ? '' : $source->getBirthDay()->getValue();
        $this->cellPhoneNumber =
            is_null($source->getCellPhoneNumber()) ? '' : $source->getCellPhoneNumber()->getValue();
        $this->remarks = is_null($source->getRemarks()) ? '' : $source->getRemarks()->getValue();
    }

    /**
     * Get the value of id
     *
     * @return string
     */
    public function getId(): string
    {
        return $this->id;
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
     * @return string
     */
    public function getBirthDay(): string
    {
        return $this->birthDay;
    }

    /**
     * Get the value of cellPhoneNumber
     *
     * @return string
     */
    public function getCellPhoneNumber(): string
    {
        return $this->cellPhoneNumber;
    }

    /**
     * Get the value of remarks
     *
     * @return string
     */
    public function getRemarks(): string
    {
        return $this->remarks;
    }
}
