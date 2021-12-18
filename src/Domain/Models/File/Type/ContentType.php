<?php
declare(strict_types=1);

namespace App\Domain\Models\File\Type;

/**
 * class ContentType
 *
 * @property-read string $value value
 */
final class ContentType
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
