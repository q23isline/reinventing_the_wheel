<?php
declare(strict_types=1);

namespace App\Domain\Shared;

/**
 * class AuditDate
 */
final class AuditDate
{
    /**
     * @var string
     */
    private string $value;

    /**
     * constructor
     *
     * @param string $value value
     */
    public function __construct(string $value)
    {
        $this->value = $value;
    }

    /**
     * Get the value of value
     *
     * @return string
     */
    public function getValue(): string
    {
        return $this->value;
    }
}
