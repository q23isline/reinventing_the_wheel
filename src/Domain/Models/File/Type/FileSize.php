<?php
declare(strict_types=1);

namespace App\Domain\Models\File\Type;

/**
 * class FileSize
 */
final class FileSize
{
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
