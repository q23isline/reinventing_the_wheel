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
     * constructor
     *
     * @param string|null $loginId loginId
     * @param string|null $password password
     * @param string|null $roleName roleName
     * @param string|null $firstName firstName
     * @param string|null $lastName lastName
     */
    public function __construct(
        ?string $loginId,
        ?string $password,
        ?string $roleName,
        ?string $firstName,
        ?string $lastName
    ) {
        if (
            is_null($loginId) ||
            is_null($password) ||
            is_null($roleName) ||
            is_null($firstName) ||
            is_null($lastName)
        ) {
            // TODO: field を個別のエラーにする
            throw new ValidateException([new ExceptionItem('field', '必須項目が不足しています。')]);
        }

        $this->loginId = $loginId;
        $this->password = $password;
        $this->roleName = $roleName;
        $this->firstName = $firstName;
        $this->lastName = $lastName;
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
}
