<?php
declare(strict_types=1);

namespace App\Domain\Models\User;

use ArrayIterator;
use IteratorAggregate;

/**
 * class UserCollection
 *
 * @implements \IteratorAggregate<\App\Domain\Models\User\User>
 */
final class UserCollection implements IteratorAggregate
{
    /**
     * constructor
     *
     * @param array<\App\Domain\Models\User\User> $attributes attributes
     */
    public function __construct(
        private array $attributes = []
    ) {
    }

    /**
     * add
     *
     * @param \App\Domain\Models\User\User $user user
     * @return void
     */
    public function add(User $user): void
    {
        $this->attributes[] = $user;
    }

    /**
     * getIterator
     *
     * @return \ArrayIterator<int,\App\Domain\Models\User\User>
     */
    public function getIterator(): ArrayIterator
    {
        return new ArrayIterator($this->attributes);
    }
}
