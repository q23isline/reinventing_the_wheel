<?php

namespace App\Domain\Models\User;

/**
 * interface IUserRepository
 */
interface IUserRepository
{
    /**
     * すべて取得
     *
     * @return User[]
     */
    public function findAll(): array;
}
