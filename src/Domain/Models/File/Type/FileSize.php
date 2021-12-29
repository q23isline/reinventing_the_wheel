<?php
declare(strict_types=1);

namespace App\Domain\Models\File\Type;

/**
 * class FileSize
 *
 * @property-read int $value value
 */
final class FileSize
{
    /**
     * constructor
     *
     * @param int $value value
     */
    public function __construct(
        public readonly int $value
    ) {
    }
}
