<?php
declare(strict_types=1);

namespace App\Test\TestCase\UseCase\Users;

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
use App\Domain\Models\User\User;

/**
 * App\Test\TestCase\UseCase\Users\TestUserFactory
 */
class TestUserFactory
{
    /**
     * @param string $userId userId
     * @param string $loginId loginId
     * @param string $password password
     * @param string $roleName roleName
     * @param string $firstName firstName
     * @param string $lastName lastName
     * @param string $firstNameKana firstNameKana
     * @param string $lastNameKana lastNameKana
     * @param string $mailAddress mailAddress
     * @param string $sex sex
     * @param string|null $birthDay birthDay
     * @param string|null $cellPhoneNumber cellPhoneNumber
     * @param string|null $remarks remarks
     * @return User
     */
    public function create(
        string $userId = '01509588-3882-42dd-9ab2-485e8e579a8e',
        string $loginId = 'test',
        string $password = 'p@ssw0rd',
        string $roleName = 'viewer',
        string $firstName = 'test1',
        string $lastName = 'test2',
        string $firstNameKana = 'テストイチ',
        string $lastNameKana = 'テストニ',
        string $mailAddress = 'test@example.com',
        string $sex = '1',
        ?string $birthDay = null,
        ?string $cellPhoneNumber = null,
        ?string $remarks = null,
    ): User {
        if (!is_null($birthDay)) {
            $birthDay = new BirthDay($birthDay);
        }

        if (!is_null($cellPhoneNumber)) {
            $cellPhoneNumber = new CellPhoneNumber($cellPhoneNumber);
        }

        if (!is_null($remarks)) {
            $remarks = new Remarks($remarks);
        }

        return User::reconstruct(
            new UserId($userId),
            new LoginId($loginId),
            new Password($password),
            new RoleName($roleName),
            new FirstName($firstName),
            new LastName($lastName),
            new FirstNameKana($firstNameKana),
            new LastNameKana($lastNameKana),
            new MailAddress($mailAddress),
            new Sex($sex),
            $birthDay,
            $cellPhoneNumber,
            $remarks,
        );
    }
}
