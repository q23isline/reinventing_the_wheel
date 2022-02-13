<?php
declare(strict_types=1);

namespace App\Domain\Models\Profile\Type;

/**
 * class Remarks
 *
 * @property-read string $value value
 */
final class Remarks
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
