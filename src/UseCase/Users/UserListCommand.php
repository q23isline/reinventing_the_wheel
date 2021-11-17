<?php
declare(strict_types=1);

namespace App\UseCase\Users;

/**
 * class UserListCommand
 *
 * @property string|null $keyword keyword
 */
final class UserListCommand
{
    private ?string $keyword;

    /**
     * constructor
     *
     * @param string|null $keyword keyword
     */
    public function __construct(?string $keyword)
    {
        $this->keyword = $keyword;
    }

    /**
     * Get the value of keyword
     *
     * @return string|null
     */
    public function getKeyword(): ?string
    {
        return $this->keyword;
    }
}
