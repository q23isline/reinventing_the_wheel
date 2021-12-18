<?php
declare(strict_types=1);

namespace App\Domain\Shared\Exception;

/**
 * class ExceptionItem
 *
 * @property-read string $field field
 * @property-read string $reason reason
 */
final class ExceptionItem
{
    /**
     * constructor
     *
     * @param string $field field
     * @param string $reason reason
     */
    public function __construct(
        public readonly string $field,
        public readonly string $reason
    ) {
    }
}
