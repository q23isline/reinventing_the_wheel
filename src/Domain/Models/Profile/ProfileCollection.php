<?php
declare(strict_types=1);

namespace App\Domain\Models\Profile;

use ArrayIterator;
use IteratorAggregate;

/**
 * class ProfileCollection
 *
 * @implements \IteratorAggregate<\App\Domain\Models\Profile\Profile>
 */
final class ProfileCollection implements IteratorAggregate
{
    /**
     * constructor
     *
     * @param array<\App\Domain\Models\Profile\Profile> $attributes attributes
     */
    public function __construct(
        private array $attributes = []
    ) {
    }

    /**
     * add
     *
     * @param \App\Domain\Models\Profile\Profile $profile profile
     * @return void
     */
    public function add(Profile $profile): void
    {
        $this->attributes[] = $profile;
    }

    /**
     * getIterator
     *
     * @return \ArrayIterator<int,\App\Domain\Models\Profile\Profile>
     */
    public function getIterator(): ArrayIterator
    {
        return new ArrayIterator($this->attributes);
    }
}
