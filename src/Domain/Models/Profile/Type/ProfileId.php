<?php
declare(strict_types=1);

namespace App\Domain\Models\Profile\Type;

/**
 * class ProfileId
 *
 * @property-read string $value value
 */
final class ProfileId
{
    /**
     * constructor
     *
     * @param string $value value
     */
    public function __construct(
        public readonly string $value
    ) {
    }
}
