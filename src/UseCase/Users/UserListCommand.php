<?php
declare(strict_types=1);

namespace App\UseCase\Users;

/**
 * class UserListCommand
 *
 * @property-read string|null $keyword keyword
 */
final class UserListCommand
{
    /**
     * constructor
     *
     * @param string|null $keyword keyword
     */
    public function __construct(
        public readonly ?string $keyword
    ) {
    }
}
