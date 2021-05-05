<?php
declare(strict_types=1);

namespace App\UseCase\Users;

/**
 * class UserGetCommand
 */
final class UserGetCommand
{
    /**
     * @var int
     */
    private int $userId;

    /**
     * constructor
     *
     * @param int $userId userId
     */
    public function __construct(int $userId)
    {
        $this->userId = $userId;
    }

    /**
     * Get the value of userId
     *
     * @return int
     */
    public function getUserId(): int
    {
        return $this->userId;
    }
}
