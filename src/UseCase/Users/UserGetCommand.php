<?php
declare(strict_types=1);

namespace App\UseCase\Users;

/**
 * class UserGetCommand
 *
 * @property-read string $userId userId
 */
final class UserGetCommand
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
