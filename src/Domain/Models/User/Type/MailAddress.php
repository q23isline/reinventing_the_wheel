<?php
declare(strict_types=1);

namespace App\Domain\Models\User\Type;

/**
 * class MailAddress
 *
 * @property-read string $value value
 */
final class MailAddress
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
