<?php
declare(strict_types=1);

namespace App\UseCase\Profiles;

/**
 * class ProfileDeleteCommand
 *
 * @property-read string $profileId profileId
 */
final class ProfileDeleteCommand
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
