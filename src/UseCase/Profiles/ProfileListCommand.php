<?php
declare(strict_types=1);

namespace App\UseCase\Profiles;

/**
 * class ProfileListCommand
 *
 * @property-read string|null $keyword keyword
 */
final class ProfileListCommand
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
