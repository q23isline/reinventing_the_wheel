<?php
declare(strict_types=1);

namespace App\Domain\Models\File\Type;

/**
 * class FileUrl
 *
 * @property-read string $value value
 */
final class FileUrl
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
