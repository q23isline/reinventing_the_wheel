<?php
declare(strict_types=1);

namespace App\Test\TestCase\UseCase\Profiles;

use App\Domain\Models\Profile\Profile;
use App\Domain\Models\Profile\Type\BirthDay;
use App\Domain\Models\Profile\Type\CellPhoneNumber;
use App\Domain\Models\Profile\Type\FirstName;
use App\Domain\Models\Profile\Type\FirstNameKana;
use App\Domain\Models\Profile\Type\LastName;
use App\Domain\Models\Profile\Type\LastNameKana;
use App\Domain\Models\Profile\Type\ProfileId;
use App\Domain\Models\Profile\Type\Remarks;
use App\Domain\Models\Profile\Type\Sex;
use App\Domain\Models\User\Type\UserId;

/**
 * App\Test\TestCase\UseCase\Profiles\TestProfileFactory
 */
final class TestProfileFactory
{
    /**
     * @param string $profileId profileId
     * @param string $userId userId
     * @param string $firstNameKana firstName
     * @param string $lastNameKana lastName
     * @param string $sex firstNameKana
     * @param string $birthDay lastNameKana
     * @param string $remarks sex
     * @param string|null $birthDay birthDay
     * @param string|null $cellPhoneNumber cellPhoneNumber
     * @param string|null $remarks remarks
     * @return \App\Domain\Models\Profile\Profile
     */
    public function create(
        string $profileId = 'c2e37627-ac0a-45e0-9dfd-eb5d703d8989',
        string $userId = '01509588-3882-42dd-9ab2-485e8e579a8e',
        string $firstName = 'test1',
        string $lastName = 'test2',
        string $firstNameKana = 'テストイチ',
        string $lastNameKana = 'テストニ',
        string $sex = '1',
        ?string $birthDay = null,
        ?string $cellPhoneNumber = null,
        ?string $remarks = null,
    ): Profile {
        if (!is_null($birthDay)) {
            $birthDay = new BirthDay($birthDay);
        }

        if (!is_null($cellPhoneNumber)) {
            $cellPhoneNumber = new CellPhoneNumber($cellPhoneNumber);
        }

        if (!is_null($remarks)) {
            $remarks = new Remarks($remarks);
        }

        return Profile::reconstruct(
            new ProfileId($profileId),
            new UserId($userId),
            new FirstName($firstName),
            new LastName($lastName),
            new FirstNameKana($firstNameKana),
            new LastNameKana($lastNameKana),
            new Sex($sex),
            $birthDay,
            $cellPhoneNumber,
            $remarks,
        );
    }
}
