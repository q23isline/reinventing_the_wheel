<?php
declare(strict_types=1);

namespace App\UseCase\Users;

use App\Domain\Shared\Exception\ExceptionItem;
use App\Domain\Shared\Exception\ValidateException;

/**
 * class UserAddCommand
 *
 * @property-read string $mailAddress mailAddress
 * @property-read string $password password
 * @property-read string $roleName roleName
 */
final class UserAddCommand
{
    public readonly string $mailAddress;
    public readonly string $password;
    public readonly string $roleName;

    /**
     * constructor
     *
     * @param string|null $mailAddress mailAddress
     * @param string|null $password password
     * @param string|null $roleName roleName
     * @throws \App\Domain\Shared\Exception\ValidateException
     */
    public function __construct(
        ?string $mailAddress,
        ?string $password,
        ?string $roleName
    ) {
        $errors = [];

        if (empty($mailAddress)) {
            $errors[] = new ExceptionItem('mailAddress', '必須項目が不足しています。');
        } else {
            $this->mailAddress = $mailAddress;
        }

        if (empty($password)) {
            $errors[] = new ExceptionItem('password', '必須項目が不足しています。');
        } else {
            $this->password = $password;
        }

        if (empty($roleName)) {
            $errors[] = new ExceptionItem('roleName', '必須項目が不足しています。');
        } else {
            $this->roleName = $roleName;
        }

        if (count($errors) > 0) {
            throw new ValidateException($errors);
        }
    }
}
