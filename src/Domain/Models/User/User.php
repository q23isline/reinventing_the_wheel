<?php
declare(strict_types=1);

namespace App\Domain\Models\User;

use App\Domain\Models\User\Type\BirthDay;
use App\Domain\Models\User\Type\CellPhoneNumber;
use App\Domain\Models\User\Type\FirstName;
use App\Domain\Models\User\Type\FirstNameKana;
use App\Domain\Models\User\Type\LastName;
use App\Domain\Models\User\Type\LastNameKana;
use App\Domain\Models\User\Type\LoginId;
use App\Domain\Models\User\Type\MailAddress;
use App\Domain\Models\User\Type\Password;
use App\Domain\Models\User\Type\Remarks;
use App\Domain\Models\User\Type\RoleName;
use App\Domain\Models\User\Type\Sex;
use App\Domain\Models\User\Type\UserId;

/**
 * class User
 *
 * @property-read \App\Domain\Models\User\Type\UserId $id id
 * @property-read \App\Domain\Models\User\Type\LoginId $loginId loginId
 * @property-read \App\Domain\Models\User\Type\Password $password password
 * @property-read \App\Domain\Models\User\Type\RoleName $roleName roleName
 * @property-read \App\Domain\Models\User\Type\FirstName $firstName firstName
 * @property-read \App\Domain\Models\User\Type\LastName $lastName lastName
 * @property-read \App\Domain\Models\User\Type\FirstNameKana $firstNameKana firstNameKana
 * @property-read \App\Domain\Models\User\Type\LastNameKana $lastNameKana lastNameKana
 * @property-read \App\Domain\Models\User\Type\MailAddress $mailAddress mailAddress
 * @property-read \App\Domain\Models\User\Type\Sex $sex sex
 * @property-read \App\Domain\Models\User\Type\BirthDay|null $birthDay birthDay
 * @property-read \App\Domain\Models\User\Type\CellPhoneNumber|null $cellPhoneNumber cellPhoneNumber
 * @property-read \App\Domain\Models\User\Type\Remarks|null $remarks remarks
 */
final class User
{
    /**
     * constructor
     *
     * @param \App\Domain\Models\User\Type\UserId $id id
     * @param \App\Domain\Models\User\Type\LoginId $loginId loginId
     * @param \App\Domain\Models\User\Type\Password $password password
     * @param \App\Domain\Models\User\Type\RoleName $roleName roleName
     * @param \App\Domain\Models\User\Type\FirstName $firstName firstName
     * @param \App\Domain\Models\User\Type\LastName $lastName lastName
     * @param \App\Domain\Models\User\Type\FirstNameKana $firstNameKana firstNameKana
     * @param \App\Domain\Models\User\Type\LastNameKana $lastNameKana lastNameKana
     * @param \App\Domain\Models\User\Type\MailAddress $mailAddress mailAddress
     * @param \App\Domain\Models\User\Type\Sex $sex sex
     * @param \App\Domain\Models\User\Type\BirthDay|null $birthDay birthDay
     * @param \App\Domain\Models\User\Type\CellPhoneNumber|null $cellPhoneNumber cellPhoneNumber
     * @param \App\Domain\Models\User\Type\Remarks|null $remarks remarks
     * @return void
     */
    private function __construct(
        public readonly UserId $id,
        public readonly LoginId $loginId,
        public readonly Password $password,
        public readonly RoleName $roleName,
        public readonly FirstName $firstName,
        public readonly LastName $lastName,
        public readonly FirstNameKana $firstNameKana,
        public readonly LastNameKana $lastNameKana,
        public readonly MailAddress $mailAddress,
        public readonly Sex $sex,
        public readonly ?BirthDay $birthDay = null,
        public readonly ?CellPhoneNumber $cellPhoneNumber = null,
        public readonly ?Remarks $remarks = null
    ) {
    }

    /**
     * 新規作成
     * TODO: UserId を引数からなくしたい
     *
     * @param \App\Domain\Models\User\Type\UserId $id id
     * @param \App\Domain\Models\User\Type\LoginId $loginId loginId
     * @param \App\Domain\Models\User\Type\Password $password password
     * @param \App\Domain\Models\User\Type\RoleName $roleName roleName
     * @param \App\Domain\Models\User\Type\FirstName $firstName firstName
     * @param \App\Domain\Models\User\Type\LastName $lastName lastName
     * @param \App\Domain\Models\User\Type\FirstNameKana $firstNameKana firstNameKana
     * @param \App\Domain\Models\User\Type\LastNameKana $lastNameKana lastNameKana
     * @param \App\Domain\Models\User\Type\MailAddress $mailAddress mailAddress
     * @param \App\Domain\Models\User\Type\Sex $sex sex
     * @param \App\Domain\Models\User\Type\BirthDay|null $birthDay birthDay
     * @param \App\Domain\Models\User\Type\CellPhoneNumber|null $cellPhoneNumber cellPhoneNumber
     * @param \App\Domain\Models\User\Type\Remarks|null $remarks remarks
     * @return self
     */
    public static function create(
        UserId $id,
        LoginId $loginId,
        Password $password,
        RoleName $roleName,
        FirstName $firstName,
        LastName $lastName,
        FirstNameKana $firstNameKana,
        LastNameKana $lastNameKana,
        MailAddress $mailAddress,
        Sex $sex,
        ?BirthDay $birthDay,
        ?CellPhoneNumber $cellPhoneNumber,
        ?Remarks $remarks
    ): self {
        return new self(
            $id,
            $loginId,
            $password,
            $roleName,
            $firstName,
            $lastName,
            $firstNameKana,
            $lastNameKana,
            $mailAddress,
            $sex,
            $birthDay,
            $cellPhoneNumber,
            $remarks,
        );
    }

    /**
     * 再構成
     *
     * @param \App\Domain\Models\User\Type\UserId $id id
     * @param \App\Domain\Models\User\Type\LoginId $loginId loginId
     * @param \App\Domain\Models\User\Type\Password $password password
     * @param \App\Domain\Models\User\Type\RoleName $roleName roleName
     * @param \App\Domain\Models\User\Type\FirstName $firstName firstName
     * @param \App\Domain\Models\User\Type\LastName $lastName lastName
     * @param \App\Domain\Models\User\Type\FirstNameKana $firstNameKana firstNameKana
     * @param \App\Domain\Models\User\Type\LastNameKana $lastNameKana lastNameKana
     * @param \App\Domain\Models\User\Type\MailAddress $mailAddress mailAddress
     * @param \App\Domain\Models\User\Type\Sex $sex sex
     * @param \App\Domain\Models\User\Type\BirthDay|null $birthDay birthDay
     * @param \App\Domain\Models\User\Type\CellPhoneNumber|null $cellPhoneNumber cellPhoneNumber
     * @param \App\Domain\Models\User\Type\Remarks|null $remarks remarks
     * @return self
     */
    public static function reconstruct(
        UserId $id,
        LoginId $loginId,
        Password $password,
        RoleName $roleName,
        FirstName $firstName,
        LastName $lastName,
        FirstNameKana $firstNameKana,
        LastNameKana $lastNameKana,
        MailAddress $mailAddress,
        Sex $sex,
        ?BirthDay $birthDay,
        ?CellPhoneNumber $cellPhoneNumber,
        ?Remarks $remarks
    ): self {
        return new self(
            $id,
            $loginId,
            $password,
            $roleName,
            $firstName,
            $lastName,
            $firstNameKana,
            $lastNameKana,
            $mailAddress,
            $sex,
            $birthDay,
            $cellPhoneNumber,
            $remarks,
        );
    }

    /**
     * 更新
     * TODO: 自身のプロパティを更新したいが readonly アクセス修飾子は一度初期化したら上書きできないため、
     *       新しいオブジェクトとして返す。 `private set` をサポートされたら書き換える。
     *       <https://www.php.net/manual/ja/language.oop5.properties.php>
     *
     * @param \App\Domain\Models\User\Type\LoginId $loginId loginId
     * @param \App\Domain\Models\User\Type\Password $password password
     * @param \App\Domain\Models\User\Type\RoleName $roleName roleName
     * @param \App\Domain\Models\User\Type\FirstName $firstName firstName
     * @param \App\Domain\Models\User\Type\LastName $lastName lastName
     * @param \App\Domain\Models\User\Type\FirstNameKana $firstNameKana firstNameKana
     * @param \App\Domain\Models\User\Type\LastNameKana $lastNameKana lastNameKana
     * @param \App\Domain\Models\User\Type\MailAddress $mailAddress mailAddress
     * @param \App\Domain\Models\User\Type\Sex $sex sex
     * @param \App\Domain\Models\User\Type\BirthDay|null $birthDay birthDay
     * @param \App\Domain\Models\User\Type\CellPhoneNumber|null $cellPhoneNumber cellPhoneNumber
     * @param \App\Domain\Models\User\Type\Remarks|null $remarks remarks
     * @return self
     */
    public function update(
        LoginId $loginId,
        Password $password,
        RoleName $roleName,
        FirstName $firstName,
        LastName $lastName,
        FirstNameKana $firstNameKana,
        LastNameKana $lastNameKana,
        MailAddress $mailAddress,
        Sex $sex,
        ?BirthDay $birthDay,
        ?CellPhoneNumber $cellPhoneNumber,
        ?Remarks $remarks
    ): self {
        return new self(
            $this->id,
            $loginId,
            $password,
            $roleName,
            $firstName,
            $lastName,
            $firstNameKana,
            $lastNameKana,
            $mailAddress,
            $sex,
            $birthDay,
            $cellPhoneNumber,
            $remarks,
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
