<?php
declare(strict_types=1);

namespace App\Domain\Models\User;

use App\Domain\Models\User\Type\LoginId;
use App\Domain\Models\User\Type\UserId;

/**
 * interface IUserRepository
 */
interface IUserRepository
{
    /**
     * IDで検索
     *
     * @param \App\Domain\Models\User\Type\UserId $userId userId
     * @return \App\Domain\Models\User\User
     */
    public function getById(UserId $userId): User;

    /**
     * ログインIDで検索
     *
     * @param \App\Domain\Models\User\Type\LoginId $loginId loginId
     * @return \App\Domain\Models\User\User|null
     */
    public function findByLoginId(LoginId $loginId): ?User;

    /**
     * すべて取得
     *
     * @return \App\Domain\Models\User\UserCollection
     */
    public function findAll(): UserCollection;

    /**
     * 保存
     *
     * @param \App\Domain\Models\User\User $user user
     * @return \App\Domain\Models\User\Type\UserId
     */
    public function save(User $user): UserId;

    /**
     * 更新
     *
     * @param \App\Domain\Models\User\User $user user
     * @return \App\Domain\Models\User\Type\UserId
     */
    public function update(User $user): UserId;
}
