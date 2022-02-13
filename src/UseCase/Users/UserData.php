<?php
declare(strict_types=1);

namespace App\UseCase\Users;

use App\Domain\Models\User\User;

/**
 * class UserData
 *
 * @property-read string $id id
 * @property-read string $mailAddress mailAddress
 * @property-read string $roleName roleName
 */
final class UserData
{
    public readonly string $id;
    public readonly string $mailAddress;
    public readonly string $roleName;

    /**
     * constructor
     *
     * @param \App\Domain\Models\User\User $source source
     */
    public function __construct(User $source)
    {
        $this->id = $source->id->value;
        $this->mailAddress = $source->mailAddress->value;
        $this->roleName = $source->roleName->value;
    }
}
