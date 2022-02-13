<?php
declare(strict_types=1);

namespace App\Domain\Models\User;

use App\Domain\Models\User\Type\MailAddress;
use App\Domain\Models\User\Type\Password;
use App\Domain\Models\User\Type\RoleName;
use App\Domain\Models\User\Type\UserId;

/**
 * class User
 *
 * @property-read \App\Domain\Models\User\Type\UserId $id id
 * @property-read \App\Domain\Models\User\Type\MailAddress $mailAddress mailAddress
 * @property-read \App\Domain\Models\User\Type\Password $password password
 * @property-read \App\Domain\Models\User\Type\RoleName $roleName roleName
 */
final class User
{
    /**
     * constructor
     *
     * @param \App\Domain\Models\User\Type\UserId $id id
     * @param \App\Domain\Models\User\Type\MailAddress $mailAddress mailAddress
     * @param \App\Domain\Models\User\Type\Password $password password
     * @param \App\Domain\Models\User\Type\RoleName $roleName roleName
     * @return void
     */
    private function __construct(
        public readonly UserId $id,
        public readonly MailAddress $mailAddress,
        public readonly Password $password,
        public readonly RoleName $roleName
    ) {
    }

    /**
     * 新規作成
     * TODO: UserId を引数からなくしたい
     *
     * @param \App\Domain\Models\User\Type\UserId $id id
     * @param \App\Domain\Models\User\Type\MailAddress $mailAddress mailAddress
     * @param \App\Domain\Models\User\Type\Password $password password
     * @param \App\Domain\Models\User\Type\RoleName $roleName roleName
     * @return self
     */
    public static function create(
        UserId $id,
        MailAddress $mailAddress,
        Password $password,
        RoleName $roleName
    ): self {
        return new self(
            $id,
            $mailAddress,
            $password,
            $roleName,
        );
    }

    /**
     * 再構成
     *
     * @param \App\Domain\Models\User\Type\UserId $id id
     * @param \App\Domain\Models\User\Type\MailAddress $mailAddress mailAddress
     * @param \App\Domain\Models\User\Type\Password $password password
     * @param \App\Domain\Models\User\Type\RoleName $roleName roleName
     * @return self
     */
    public static function reconstruct(
        UserId $id,
        MailAddress $mailAddress,
        Password $password,
        RoleName $roleName
    ): self {
        return new self(
            $id,
            $mailAddress,
            $password,
            $roleName,
        );
    }

    /**
     * 更新
     * TODO: 自身のプロパティを更新したいが readonly アクセス修飾子は一度初期化したら上書きできないため、
     *       新しいオブジェクトとして返す。 `private set` をサポートされたら書き換える。
     *       <https://www.php.net/manual/ja/language.oop5.properties.php>
     *
     * @param \App\Domain\Models\User\Type\MailAddress $mailAddress mailAddress
     * @param \App\Domain\Models\User\Type\Password $password password
     * @param \App\Domain\Models\User\Type\RoleName $roleName roleName
     * @return self
     */
    public function update(
        MailAddress $mailAddress,
        Password $password,
        RoleName $roleName
    ): self {
        return new self(
            $this->id,
            $mailAddress,
            $password,
            $roleName,
        );
    }

    /**
     * isMyself
     *
     * @param \App\Domain\Models\User\User $other other
     * @return bool
     */
    public function isMyself(User $other): bool
    {
        if ($this === $other) {
            // 同じクラスの同じインスタンスであれば true
            return true;
        }

        return $this->id->value === $other->id->value;
    }
}
