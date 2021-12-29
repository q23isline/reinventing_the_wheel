<?php
declare(strict_types=1);

namespace App\UseCase\Users;

/**
 * class UserDeleteCommand
 *
 * @property-read string $userId userId
 */
final class UserDeleteCommand
{
    /**
     * constructor
     *
     * @param string $userId userId
     */
    public function __construct(
        public readonly string $userId
    ) {
    }
}
