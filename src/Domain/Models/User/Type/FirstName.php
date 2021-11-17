<?php
declare(strict_types=1);

namespace App\Domain\Models\User\Type;

/**
 * class FirstName
 *
 * @property-read string $value value
 */
final class FirstName
{
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
