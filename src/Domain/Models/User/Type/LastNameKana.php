<?php
declare(strict_types=1);

namespace App\Domain\Models\User\Type;

/**
 * class LastNameKana
 *
 * @property-read string $value value
 */
final class LastNameKana
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
