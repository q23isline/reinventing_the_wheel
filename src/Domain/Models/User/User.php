<?php
declare(strict_types=1);

namespace App\Domain\Models\User;

use App\Domain\Models\User\Type\FirstName;
use App\Domain\Models\User\Type\LastName;
use App\Domain\Models\User\Type\LoginId;
use App\Domain\Models\User\Type\Password;
use App\Domain\Models\User\Type\RoleName;
use App\Domain\Models\User\Type\UserId;
use App\Domain\Shared\AuditDate;

/**
 * class User
 */
final class User
{
    /**
     * @var UserId|null
     */
    private ?UserId $id;

    /**
     * @var LoginId
     */
    private LoginId $loginId;

    /**
     * @var Password|null
     */
    private ?Password $password;

    /**
     * @var RoleName
     */
    private RoleName $roleName;

    /**
     * @var FirstName
     */
    private FirstName $firstName;

    /**
     * @var LastName
     */
    private LastName $lastName;

    /**
     * @var AuditDate|null
     */
    private ?AuditDate $created;

    /**
     * @var AuditDate|null
     */
    private ?AuditDate $modified;

    /**
     * constructor
     *
     * @param UserId|null $id id
     * @param LoginId $loginId loginId
     * @param Password|null $password password 参照では不要なため null を許可
     * @param RoleName $roleName roleName
     * @param FirstName $firstName firstName
     * @param LastName $lastName lastName
     * @param AuditDate|null $created created
     * @param AuditDate|null $modified modified
     */
    public function __construct(
        ?UserId $id = null,
        LoginId $loginId,
        ?Password $password = null,
        RoleName $roleName,
        FirstName $firstName,
        LastName $lastName,
        ?AuditDate $created = null,
        ?AuditDate $modified = null
    ) {
        $this->id = $id;
        $this->loginId = $loginId;
        $this->password = $password;
        $this->roleName = $roleName;
        $this->firstName = $firstName;
        $this->lastName = $lastName;
        $this->created = $created;
        $this->modified = $modified;
    }

    /**
     * Get the value of id
     *
     * @return UserId|null
     */
    public function getId(): ?UserId
    {
        return $this->id;
    }

    /**
     * Get the value of loginId
     *
     * @return LoginId
     */
    public function getLoginId(): LoginId
    {
        return $this->loginId;
    }

    /**
     * Set the value of loginId
     *
     * @param LoginId $loginId loginId
     *
     * @return self
     */
    public function setLoginId(LoginId $loginId): LoginId
    {
        $this->loginId = $loginId;

        return $this;
    }

    /**
     * Get the value of password
     *
     * @return Password
     */
    public function getPassword(): Password
    {
        return $this->password;
    }

    /**
     * Set the value of password
     *
     * @param Password $password password
     *
     * @return self
     */
    public function setPassword(Password $password): Password
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Get the value of roleName
     *
     * @return RoleName
     */
    public function getRoleName(): RoleName
    {
        return $this->roleName;
    }

    /**
     * Set the value of roleName
     *
     * @param RoleName $roleName roleName
     *
     * @return self
     */
    public function setRoleName(RoleName $roleName): RoleName
    {
        $this->roleName = $roleName;

        return $this;
    }

    /**
     * Get the value of firstName
     *
     * @return FirstName
     */
    public function getFirstName(): FirstName
    {
        return $this->firstName;
    }

    /**
     * Set the value of firstName
     *
     * @param FirstName $firstName firstName
     *
     * @return self
     */
    public function setFirstName(FirstName $firstName): FirstName
    {
        $this->firstName = $firstName;

        return $this;
    }

    /**
     * Get the value of lastName
     *
     * @return LastName
     */
    public function getLastName(): LastName
    {
        return $this->lastName;
    }

    /**
     * Set the value of lastName
     *
     * @param LastName $lastName lastName
     *
     * @return self
     */
    public function setLastName(LastName $lastName): LastName
    {
        $this->lastName = $lastName;

        return $this;
    }

    /**
     * Get the value of created
     *
     * @return AuditDate|null
     */
    public function getCreated(): ?AuditDate
    {
        return $this->created;
    }

    /**
     * Get the value of modified
     *
     * @return AuditDate|null
     */
    public function getModified(): ?AuditDate
    {
        return $this->modified;
    }
}
