<?php
declare(strict_types=1);

namespace App\Domain\Models\User\Type;

/**
 * class FirstNameKana
 *
 * @property-read string $value value
 */
final class FirstNameKana
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
