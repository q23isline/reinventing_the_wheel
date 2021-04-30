<?php

namespace App\Domain\Models\User\Type;

/**
 * class UserId
 */
final class UserId
{
    /**
     * @var int
     */
    private int $value;

    /**
     * constructor
     *
     * @param int $value value
     */
    public function __construct(int $value)
    {
        $this->value = $value;
    }

    /**
     * Get the value of value
     *
     * @return int
     */
    public function getValue(): int
    {
        return $this->value;
    }
}
