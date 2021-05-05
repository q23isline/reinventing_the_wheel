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
     * @var \App\Domain\Models\User\Type\UserId|null
     */
    private ?UserId $id;

    /**
     * @var \App\Domain\Models\User\Type\LoginId
     */
    private LoginId $loginId;

    /**
     * @var \App\Domain\Models\User\Type\Password|null
     */
    private ?Password $password;

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
     * @var \App\Domain\Shared\AuditDate|null
     */
    private ?AuditDate $created;

    /**
     * @var \App\Domain\Shared\AuditDate|null
     */
    private ?AuditDate $modified;

    /**
     * constructor
     *
     * @param \App\Domain\Models\User\Type\UserId|null $id id
     * @param \App\Domain\Models\User\Type\LoginId $loginId loginId
     * @param \App\Domain\Models\User\Type\Password|null $password password 参照では不要なため null を許可
     * @param \App\Domain\Models\User\Type\RoleName $roleName roleName
     * @param \App\Domain\Models\User\Type\FirstName $firstName firstName
     * @param \App\Domain\Models\User\Type\LastName $lastName lastName
     * @param \App\Domain\Shared\AuditDate|null $created created
     * @param \App\Domain\Shared\AuditDate|null $modified modified
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
     * @return \App\Domain\Models\User\Type\UserId|null
     */
    public function getId(): ?UserId
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
     * @return \App\Domain\Shared\AuditDate|null
     */
    public function getCreated(): ?AuditDate
    {
        return $this->created;
    }

    /**
     * Get the value of modified
     *
     * @return \App\Domain\Shared\AuditDate|null
     */
    public function getModified(): ?AuditDate
    {
        return $this->modified;
    }
}
