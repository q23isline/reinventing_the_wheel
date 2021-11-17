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
    private string $field;
    private string $reason;

    /**
     * constructor
     *
     * @param string $field field
     * @param string $reason reason
     */
    public function __construct(string $field, string $reason)
    {
        $this->field = $field;
        $this->reason = $reason;
    }

    /**
     * Get the value of field
     *
     * @return string
     */
    public function getField(): string
    {
        return $this->field;
    }

    /**
     * Get the value of reason
     *
     * @return string
     */
    public function getReason(): string
    {
        return $this->reason;
    }
}
