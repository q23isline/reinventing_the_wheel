<?php
declare(strict_types=1);

namespace App\Domain\Models\Profile;

use App\Domain\Models\Profile\Type\BirthDay;
use App\Domain\Models\Profile\Type\CellPhoneNumber;
use App\Domain\Models\Profile\Type\FirstName;
use App\Domain\Models\Profile\Type\FirstNameKana;
use App\Domain\Models\Profile\Type\LastName;
use App\Domain\Models\Profile\Type\LastNameKana;
use App\Domain\Models\Profile\Type\ProfileId;
use App\Domain\Models\Profile\Type\ProfileImage;
use App\Domain\Models\Profile\Type\Remarks;
use App\Domain\Models\Profile\Type\Sex;
use App\Domain\Models\User\Type\UserId;

/**
 * class Profile
 *
 * @property-read \App\Domain\Models\Profile\Type\ProfileId $id id
 * @property-read \App\Domain\Models\User\Type\UserId $userId userId
 * @property-read \App\Domain\Models\Profile\Type\FirstName $firstName firstName
 * @property-read \App\Domain\Models\Profile\Type\LastName $lastName lastName
 * @property-read \App\Domain\Models\Profile\Type\FirstNameKana $firstNameKana firstNameKana
 * @property-read \App\Domain\Models\Profile\Type\LastNameKana $lastNameKana lastNameKana
 * @property-read \App\Domain\Models\Profile\Type\Sex $sex sex
 * @property-read \App\Domain\Models\Profile\Type\BirthDay|null $birthDay birthDay
 * @property-read \App\Domain\Models\Profile\Type\CellPhoneNumber|null $cellPhoneNumber cellPhoneNumber
 * @property-read \App\Domain\Models\Profile\Type\Remarks|null $remarks remarks
 * @property-read \App\Domain\Models\Profile\Type\ProfileImage|null $profileImage profileImage
 */
final class Profile
{
    /**
     * constructor
     *
     * @param \App\Domain\Models\Profile\Type\ProfileId $id id
     * @param \App\Domain\Models\User\Type\UserId $userId userId
     * @param \App\Domain\Models\Profile\Type\FirstName $firstName firstName
     * @param \App\Domain\Models\Profile\Type\LastName $lastName lastName
     * @param \App\Domain\Models\Profile\Type\FirstNameKana $firstNameKana firstNameKana
     * @param \App\Domain\Models\Profile\Type\LastNameKana $lastNameKana lastNameKana
     * @param \App\Domain\Models\Profile\Type\Sex $sex sex
     * @param \App\Domain\Models\Profile\Type\BirthDay|null $birthDay birthDay
     * @param \App\Domain\Models\Profile\Type\CellPhoneNumber|null $cellPhoneNumber cellPhoneNumber
     * @param \App\Domain\Models\Profile\Type\Remarks|null $remarks remarks
     * @param \App\Domain\Models\Profile\Type\ProfileImage|null $profileImage profileImage
     * @return void
     */
    private function __construct(
        public readonly ProfileId $id,
        public readonly UserId $userId,
        public readonly FirstName $firstName,
        public readonly LastName $lastName,
        public readonly FirstNameKana $firstNameKana,
        public readonly LastNameKana $lastNameKana,
        public readonly Sex $sex,
        public readonly ?BirthDay $birthDay,
        public readonly ?CellPhoneNumber $cellPhoneNumber,
        public readonly ?Remarks $remarks,
        public readonly ?ProfileImage $profileImage
    ) {
    }

    /**
     * 新規作成
     * TODO: ProfileId を引数からなくしたい
     *
     * @param \App\Domain\Models\Profile\Type\ProfileId $id id
     * @param \App\Domain\Models\User\Type\UserId $userId userId
     * @param \App\Domain\Models\Profile\Type\FirstName $firstName firstName
     * @param \App\Domain\Models\Profile\Type\LastName $lastName lastName
     * @param \App\Domain\Models\Profile\Type\FirstNameKana $firstNameKana firstNameKana
     * @param \App\Domain\Models\Profile\Type\LastNameKana $lastNameKana lastNameKana
     * @param \App\Domain\Models\Profile\Type\Sex $sex sex
     * @param \App\Domain\Models\Profile\Type\BirthDay|null $birthDay birthDay
     * @param \App\Domain\Models\Profile\Type\CellPhoneNumber|null $cellPhoneNumber cellPhoneNumber
     * @param \App\Domain\Models\Profile\Type\Remarks|null $remarks remarks
     * @param \App\Domain\Models\Profile\Type\ProfileImage|null $profileImage profileImage
     * @return self
     */
    public static function create(
        ProfileId $id,
        UserId $userId,
        FirstName $firstName,
        LastName $lastName,
        FirstNameKana $firstNameKana,
        LastNameKana $lastNameKana,
        Sex $sex,
        ?BirthDay $birthDay = null,
        ?CellPhoneNumber $cellPhoneNumber = null,
        ?Remarks $remarks = null,
        ?ProfileImage $profileImage = null
    ): self {
        return new self(
            $id,
            $userId,
            $firstName,
            $lastName,
            $firstNameKana,
            $lastNameKana,
            $sex,
            $birthDay,
            $cellPhoneNumber,
            $remarks,
            $profileImage,
        );
    }

    /**
     * 再構成
     *
     * @param \App\Domain\Models\Profile\Type\ProfileId $id id
     * @param \App\Domain\Models\User\Type\UserId $userId userId
     * @param \App\Domain\Models\Profile\Type\FirstName $firstName firstName
     * @param \App\Domain\Models\Profile\Type\LastName $lastName lastName
     * @param \App\Domain\Models\Profile\Type\FirstNameKana $firstNameKana firstNameKana
     * @param \App\Domain\Models\Profile\Type\LastNameKana $lastNameKana lastNameKana
     * @param \App\Domain\Models\Profile\Type\Sex $sex sex
     * @param \App\Domain\Models\Profile\Type\BirthDay|null $birthDay birthDay
     * @param \App\Domain\Models\Profile\Type\CellPhoneNumber|null $cellPhoneNumber cellPhoneNumber
     * @param \App\Domain\Models\Profile\Type\Remarks|null $remarks remarks
     * @return self
     */
    public static function reconstruct(
        ProfileId $id,
        UserId $userId,
        FirstName $firstName,
        LastName $lastName,
        FirstNameKana $firstNameKana,
        LastNameKana $lastNameKana,
        Sex $sex,
        ?BirthDay $birthDay = null,
        ?CellPhoneNumber $cellPhoneNumber = null,
        ?Remarks $remarks = null
    ): self {
        return new self(
            $id,
            $userId,
            $firstName,
            $lastName,
            $firstNameKana,
            $lastNameKana,
            $sex,
            $birthDay,
            $cellPhoneNumber,
            $remarks,
            null // TODO: 暫定対応：引数でプロフィール画像を受け取る
        );
    }

    /**
     * 更新
     * TODO: 自身のプロパティを更新したいが readonly アクセス修飾子は一度初期化したら上書きできないため、
     *       新しいオブジェクトとして返す。 `private set` をサポートされたら書き換える。
     *       <https://www.php.net/manual/ja/language.oop5.properties.php>
     *
     * @param \App\Domain\Models\Profile\Type\FirstName $firstName firstName
     * @param \App\Domain\Models\Profile\Type\LastName $lastName lastName
     * @param \App\Domain\Models\Profile\Type\FirstNameKana $firstNameKana firstNameKana
     * @param \App\Domain\Models\Profile\Type\LastNameKana $lastNameKana lastNameKana
     * @param \App\Domain\Models\Profile\Type\Sex $sex sex
     * @param \App\Domain\Models\Profile\Type\BirthDay|null $birthDay birthDay
     * @param \App\Domain\Models\Profile\Type\CellPhoneNumber|null $cellPhoneNumber cellPhoneNumber
     * @param \App\Domain\Models\Profile\Type\Remarks|null $remarks remarks
     * @return self
     */
    public function update(
        FirstName $firstName,
        LastName $lastName,
        FirstNameKana $firstNameKana,
        LastNameKana $lastNameKana,
        Sex $sex,
        ?BirthDay $birthDay = null,
        ?CellPhoneNumber $cellPhoneNumber = null,
        ?Remarks $remarks = null,
    ): self {
        return new self(
            $this->id,
            $this->userId,
            $firstName,
            $lastName,
            $firstNameKana,
            $lastNameKana,
            $sex,
            $birthDay,
            $cellPhoneNumber,
            $remarks,
            null // TODO: 暫定対応：引数でプロフィール画像を受け取る
        );
    }
}
