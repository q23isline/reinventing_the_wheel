<?php
declare(strict_types=1);

namespace App\Test\TestCase\Domain\Models\Profile;

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
use Cake\TestSuite\TestCase;

/**
 * App\Domain\Models\Profile\Profile Test Case
 *
 * @uses \App\Domain\Models\Profile\Profile
 */
final class ProfileTest extends TestCase
{
    /**
     * @return void
     */
    public function test_プロフィールインスタンスが作成されること(): void
    {
        // Arrange
        $id = new ProfileId('c2e37627-ac0a-45e0-9dfd-eb5d703d8989');
        $userId = new UserId('01509588-3882-42dd-9ab2-485e8e579a8e');
        $firstName = new FirstName('test1');
        $lastName = new LastName('test2');
        $firstNameKana = new FirstNameKana('テストイチ');
        $lastNameKana = new LastNameKana('テストニ');
        $sex = new Sex('1');
        $birthDay = new BirthDay('1980-01-01');
        $cellPhoneNumber = new CellPhoneNumber('09012345678');
        $remarks = new Remarks('テストメモ');

        // Act
        $profile = Profile::create(
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
        );

        // Assert
        $this->assertEquals($id, $profile->id);
        $this->assertEquals($userId, $profile->userId);
        $this->assertEquals($firstName, $profile->firstName);
        $this->assertEquals($lastName, $profile->lastName);
        $this->assertEquals($firstNameKana, $profile->firstNameKana);
        $this->assertEquals($lastNameKana, $profile->lastNameKana);
        $this->assertEquals($sex, $profile->sex);
        $this->assertEquals($birthDay, $profile->birthDay);
        $this->assertEquals($cellPhoneNumber, $profile->cellPhoneNumber);
        $this->assertEquals($remarks, $profile->remarks);
    }

    /**
     * @return void
     */
    public function test_プロフィールインスタンスが再構成されること(): void
    {
        // Arrange
        $id = new ProfileId('c2e37627-ac0a-45e0-9dfd-eb5d703d8989');
        $userId = new UserId('01509588-3882-42dd-9ab2-485e8e579a8e');
        $firstName = new FirstName('test1');
        $lastName = new LastName('test2');
        $firstNameKana = new FirstNameKana('テストイチ');
        $lastNameKana = new LastNameKana('テストニ');
        $sex = new Sex('1');
        $birthDay = new BirthDay('1980-01-01');
        $cellPhoneNumber = new CellPhoneNumber('09012345678');
        $remarks = new Remarks('テストメモ');

        // Act
        $profile = Profile::reconstruct(
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
        );

        // Assert
        $this->assertEquals($id, $profile->id);
        $this->assertEquals($userId, $profile->userId);
        $this->assertEquals($firstName, $profile->firstName);
        $this->assertEquals($lastName, $profile->lastName);
        $this->assertEquals($firstNameKana, $profile->firstNameKana);
        $this->assertEquals($lastNameKana, $profile->lastNameKana);
        $this->assertEquals($sex, $profile->sex);
        $this->assertEquals($birthDay, $profile->birthDay);
        $this->assertEquals($cellPhoneNumber, $profile->cellPhoneNumber);
        $this->assertEquals($remarks, $profile->remarks);
    }

    /**
     * @return void
     */
    public function test_プロフィールインスタンスが更新（再作成）されること(): void
    {
        // Arrange
        $id = new ProfileId('c2e37627-ac0a-45e0-9dfd-eb5d703d8989');
        $userId = new UserId('01509588-3882-42dd-9ab2-485e8e579a8e');
        $firstName = new FirstName('test2');
        $lastName = new LastName('test3');
        $firstNameKana = new FirstNameKana('テストニ');
        $lastNameKana = new LastNameKana('テストサン');
        $sex = new Sex('2');
        $birthDay = new BirthDay('1980-01-02');
        $cellPhoneNumber = new CellPhoneNumber('09012345679');
        $remarks = new Remarks('テストメモ');
        $profile = Profile::create(
            $id,
            $userId,
            new FirstName('test1'),
            new LastName('test2'),
            new FirstNameKana('テストイチ'),
            new LastNameKana('テストニ'),
            new Sex('1'),
            new BirthDay('1980-01-01'),
            new CellPhoneNumber('09012345678'),
            new Remarks('テストメモ1'),
        );

        // Act
        $profile = $profile->update(
            $firstName,
            $lastName,
            $firstNameKana,
            $lastNameKana,
            $sex,
            $birthDay,
            $cellPhoneNumber,
            $remarks,
        );

        // Assert
        $this->assertEquals($id, $profile->id);
        $this->assertEquals($userId, $profile->userId);
        $this->assertEquals($firstName, $profile->firstName);
        $this->assertEquals($lastName, $profile->lastName);
        $this->assertEquals($firstNameKana, $profile->firstNameKana);
        $this->assertEquals($lastNameKana, $profile->lastNameKana);
        $this->assertEquals($sex, $profile->sex);
        $this->assertEquals($birthDay, $profile->birthDay);
        $this->assertEquals($cellPhoneNumber, $profile->cellPhoneNumber);
        $this->assertEquals($remarks, $profile->remarks);
    }
}
