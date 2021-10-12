<?php
declare(strict_types=1);

namespace App\UseCase\Users;

use App\Domain\Models\User\User;

/**
 * class UserData
 */
final class UserData
{
    /**
     * @var int
     */
    private int $id;

    /**
     * @var string
     */
    private string $loginId;

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
    private string $created;

    /**
     * @var string
     */
    private string $modified;

    /**
     * constructor
     *
     * @param \App\Domain\Models\User\User $source source
     */
    public function __construct(User $source)
    {
        $this->id = is_null($source->getId()) ? 0 : $source->getId()->getValue();
        $this->loginId = is_null($source->getLoginId()) ? '' : $source->getLoginId()->getValue();
        $this->roleName = is_null($source->getRoleName()) ? '' : $source->getRoleName()->getValue();
        $this->firstName = is_null($source->getFirstName()) ? '' : $source->getFirstName()->getValue();
        $this->lastName = is_null($source->getLastName()) ? '' : $source->getLastName()->getValue();
        $this->created = is_null($source->getCreated()) ? '' : $source->getCreated()->getValue();
        $this->modified = is_null($source->getModified()) ? '' : $source->getModified()->getValue();
    }

    /**
     * Get the value of id
     *
     * @return int
     */
    public function getId(): int
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
     * Get the value of created
     *
     * @return string
     */
    public function getCreated(): string
    {
        return $this->created;
    }

    /**
     * Get the value of modified
     *
     * @return string
     */
    public function getModified(): string
    {
        return $this->modified;
    }
}
