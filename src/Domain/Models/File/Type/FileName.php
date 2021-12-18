<?php
declare(strict_types=1);

namespace App\Domain\Models\File\Type;

/**
 * class FileName
 *
 * @property-read string $value value
 */
final class FileName
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
