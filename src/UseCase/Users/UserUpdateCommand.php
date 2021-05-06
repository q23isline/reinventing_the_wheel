<?php
declare(strict_types=1);

namespace App\UseCase\Users;

use App\Domain\Shared\Exception\ExceptionItem;
use App\Domain\Shared\Exception\ValidateException;

/**
 * class UserUpdateCommand
 */
final class UserUpdateCommand
{
    /**
     * @var int
     */
    private int $userId;

    /**
     * @var string|null
     */
    private ?string $loginId;

    /**
     * @var string|null
     */
    private ?string $password;

    /**
     * @var string|null
     */
    private ?string $roleName;

    /**
     * @var string|null
     */
    private ?string $firstName;

    /**
     * @var string|null
     */
    private ?string $lastName;

    /**
     * constructor
     *
     * @param int $userId userId
     * @param string|null $loginId loginId
     * @param string|null $password password
     * @param string|null $roleName roleName
     * @param string|null $firstName firstName
     * @param string|null $lastName lastName
     */
    public function __construct(
        int $userId,
        ?string $loginId = null,
        ?string $password = null,
        ?string $roleName = null,
        ?string $firstName = null,
        ?string $lastName = null
    ) {
        // チェック処理が長いので、動的プロパティみたいにしたいがソースコードを追いづらくなるか…？

        if (!is_null($loginId) && $loginId === '') {
            throw new ValidateException([new ExceptionItem('loginId', '必須項目が不足しています。')]);
        } else {
            $this->loginId = $loginId;
        }

        if (!is_null($password) && $password === '') {
            throw new ValidateException([new ExceptionItem('password', '必須項目が不足しています。')]);
        } else {
            $this->password = $password;
        }

        if (!is_null($roleName) && $roleName === '') {
            throw new ValidateException([new ExceptionItem('roleName', '必須項目が不足しています。')]);
        } else {
            $this->roleName = $roleName;
        }

        if (!is_null($firstName) && $firstName === '') {
            throw new ValidateException([new ExceptionItem('firstName', '必須項目が不足しています。')]);
        } else {
            $this->firstName = $firstName;
        }

        if (!is_null($lastName) && $lastName === '') {
            throw new ValidateException([new ExceptionItem('lastName', '必須項目が不足しています。')]);
        } else {
            $this->lastName = $lastName;
        }

        $this->userId = $userId;
    }

    /**
     * Get the value of userId
     *
     * @return int
     */
    public function getUserId()
    {
        return $this->userId;
    }

    /**
     * Get the value of loginId
     *
     * @return string|null
     */
    public function getLoginId(): ?string
    {
        return $this->loginId;
    }

    /**
     * Get the value of password
     *
     * @return string|null
     */
    public function getPassword(): ?string
    {
        return $this->password;
    }

    /**
     * Get the value of roleName
     *
     * @return string|null
     */
    public function getRoleName(): ?string
    {
        return $this->roleName;
    }

    /**
     * Get the value of firstName
     *
     * @return string|null
     */
    public function getFirstName(): ?string
    {
        return $this->firstName;
    }

    /**
     * Get the value of lastName
     *
     * @return string|null
     */
    public function getLastName(): ?string
    {
        return $this->lastName;
    }
}
