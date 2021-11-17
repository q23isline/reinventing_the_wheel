<?php
declare(strict_types=1);

namespace App\UseCase\Users;

/**
 * class UserDeleteCommand
 *
 * @property string $userId userId
 */
final class UserDeleteCommand
{
    private string $userId;

    /**
     * constructor
     *
     * @param string $userId userId
     */
    public function __construct(string $userId)
    {
        $this->userId = $userId;
    }

    /**
     * Get the value of userId
     *
     * @return string
     */
    public function getUserId(): string
    {
        return $this->userId;
    }
}
