<?php
declare(strict_types=1);

namespace App\Domain\Models\Profile;

use App\Domain\Models\Profile\Type\ProfileId;

/**
 * interface IProfileRepository
 */
interface IProfileRepository
{
    /**
     * 採番を取得
     *
     * @return \App\Domain\Models\Profile\Type\ProfileId
     */
    public function assignId(): ProfileId;

    /**
     * IDで検索
     *
     * @param \App\Domain\Models\Profile\Type\ProfileId $profileId profileId
     * @return \App\Domain\Models\Profile\Profile
     */
    public function getById(ProfileId $profileId): Profile;

    /**
     * すべて取得
     *
     * @param string|null $searchKeyword searchKeyword
     * @return \App\Domain\Models\Profile\ProfileCollection
     */
    public function findAll(?string $searchKeyword = null): ProfileCollection;

    /**
     * 保存
     *
     * @param \App\Domain\Models\Profile\Profile $profile profile
     * @return \App\Domain\Models\Profile\Type\ProfileId
     */
    public function save(Profile $profile): ProfileId;

    /**
     * 更新
     *
     * @param \App\Domain\Models\Profile\Profile $profile profile
     * @return \App\Domain\Models\Profile\Type\ProfileId
     */
    public function update(Profile $profile): ProfileId;

    /**
     * 削除
     *
     * @param \App\Domain\Models\Profile\Type\ProfileId $profileId profileId
     * @return void
     */
    public function delete(ProfileId $profileId): void;
}
