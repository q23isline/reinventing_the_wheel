<?php
declare(strict_types=1);

namespace App\UseCase\Profiles;

/**
 * class ProfileGetCommand
 *
 * @property-read string $profileId profileId
 */
final class ProfileGetCommand
{
    /**
     * constructor
     *
     * @param string $profileId profileId
     */
    public function __construct(
        public readonly string $profileId
    ) {
    }
}
