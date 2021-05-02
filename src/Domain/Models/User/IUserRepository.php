<?php
declare(strict_types=1);

namespace App\Domain\Models\User;

use App\Domain\Models\User\Type\LoginId;

/**
 * interface IUserRepository
 */
interface IUserRepository
{
    /**
     * ログインIDで検索
     *
     * @param LoginId $loginId loginId
     * @return User|null
     */
    public function findByLoginId(LoginId $loginId): ?User;

    /**
     * すべて取得
     *
     * @return UserCollection
     */
    public function findAll(): UserCollection;

    /**
     * 保存
     *
     * @param User $user user
     * @return User
     */
    public function save(User $user): User;
}
