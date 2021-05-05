<?php
declare(strict_types=1);

namespace App\Domain\Models\User;

use ArrayIterator;
use IteratorAggregate;

/**
 * class UserCollection
 */
final class UserCollection implements IteratorAggregate
{
    /**
     * @var array
     */
    private array $attributes;

    /**
     * constructor
     *
     * @param array $attributes attributes
     */
    public function __construct(array $attributes = [])
    {
        $this->attributes = $attributes;
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
     * @return \ArrayIterator
     */
    public function getIterator(): ArrayIterator
    {
        return new ArrayIterator($this->attributes);
    }
}
