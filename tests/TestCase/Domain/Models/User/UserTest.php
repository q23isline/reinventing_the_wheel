<?php
declare(strict_types=1);

namespace App\Test\TestCase\Domain\Models\User;

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
use Cake\TestSuite\TestCase;

/**
 * App\Domain\Models\User\User Test Case
 *
 * @uses \App\Domain\Models\User\User
 */
class UserTest extends TestCase
{
    /**
     * @return void
     */
    public function test_ユーザーインスタンスが作成されること(): void
    {
        // Arrange
        $id = new UserId('01509588-3882-42dd-9ab2-485e8e579a8e');
        $loginId = new LoginId('test');
        $password = new Password('p@ssw0rd');
        $roleName = new RoleName('viewer');
        $firstName = new FirstName('test1');
        $lastName = new LastName('test2');
        $firstNameKana = new FirstNameKana('テストイチ');
        $lastNameKana = new LastNameKana('テストニ');
        $mailAddress = new MailAddress('test@example.com');
        $sex = new Sex('1');
        $birthDay = new BirthDay('1980-01-01');
        $cellPhoneNumber = new CellPhoneNumber('09012345678');
        $remarks = new Remarks('テストメモ');

        // Act
        $user = User::create(
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

        // Assert
        $this->assertEquals($id, $user->getId());
        $this->assertEquals($loginId, $user->getLoginId());
        $this->assertEquals($password, $user->getPassword());
        $this->assertEquals($roleName, $user->getRoleName());
        $this->assertEquals($firstName, $user->getFirstName());
        $this->assertEquals($lastName, $user->getLastName());
        $this->assertEquals($firstNameKana, $user->getFirstNameKana());
        $this->assertEquals($lastNameKana, $user->getLastNameKana());
        $this->assertEquals($mailAddress, $user->getMailAddress());
        $this->assertEquals($sex, $user->getSex());
        $this->assertEquals($birthDay, $user->getBirthDay());
        $this->assertEquals($cellPhoneNumber, $user->getCellPhoneNumber());
        $this->assertEquals($remarks, $user->getRemarks());
    }

    /**
     * @return void
     */
    public function test_ユーザーインスタンスが再構成されること(): void
    {
        // Arrange
        $id = new UserId('01509588-3882-42dd-9ab2-485e8e579a8e');
        $loginId = new LoginId('test');
        $password = new Password('p@ssw0rd');
        $roleName = new RoleName('viewer');
        $firstName = new FirstName('test1');
        $lastName = new LastName('test2');
        $firstNameKana = new FirstNameKana('テストイチ');
        $lastNameKana = new LastNameKana('テストニ');
        $mailAddress = new MailAddress('test@example.com');
        $sex = new Sex('1');
        $birthDay = new BirthDay('1980-01-01');
        $cellPhoneNumber = new CellPhoneNumber('09012345678');
        $remarks = new Remarks('テストメモ');

        // Act
        $user = User::reconstruct(
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

        // Assert
        $this->assertEquals($id, $user->getId());
        $this->assertEquals($loginId, $user->getLoginId());
        $this->assertEquals($password, $user->getPassword());
        $this->assertEquals($roleName, $user->getRoleName());
        $this->assertEquals($firstName, $user->getFirstName());
        $this->assertEquals($lastName, $user->getLastName());
        $this->assertEquals($firstNameKana, $user->getFirstNameKana());
        $this->assertEquals($lastNameKana, $user->getLastNameKana());
        $this->assertEquals($mailAddress, $user->getMailAddress());
        $this->assertEquals($sex, $user->getSex());
        $this->assertEquals($birthDay, $user->getBirthDay());
        $this->assertEquals($cellPhoneNumber, $user->getCellPhoneNumber());
        $this->assertEquals($remarks, $user->getRemarks());
    }

    /**
     * @return void
     */
    public function test_ユーザーインスタンスが更新されること(): void
    {
        // Arrange
        $id = new UserId('01509588-3882-42dd-9ab2-485e8e579a8e');
        $loginId = new LoginId('test1');
        $password = new Password('p@ssw0rd1');
        $roleName = new RoleName('editor');
        $firstName = new FirstName('test2');
        $lastName = new LastName('test3');
        $firstNameKana = new FirstNameKana('テストニ');
        $lastNameKana = new LastNameKana('テストサン');
        $mailAddress = new MailAddress('test1@example.com');
        $sex = new Sex('2');
        $birthDay = new BirthDay('1980-01-02');
        $cellPhoneNumber = new CellPhoneNumber('09012345679');
        $remarks = new Remarks('テストメモ');
        $user = User::create(
            $id,
            new LoginId('test'),
            new Password('p@ssw0rd'),
            new RoleName('viewer'),
            new FirstName('test1'),
            new LastName('test2'),
            new FirstNameKana('テストイチ'),
            new LastNameKana('テストニ'),
            new MailAddress('test@example.com'),
            new Sex('1'),
            new BirthDay('1980-01-01'),
            new CellPhoneNumber('09012345678'),
            new Remarks('テストメモ1'),
        );

        // Act
        $user->update(
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

        // Assert
        $this->assertEquals($id, $user->getId());
        $this->assertEquals($loginId, $user->getLoginId());
        $this->assertEquals($password, $user->getPassword());
        $this->assertEquals($roleName, $user->getRoleName());
        $this->assertEquals($firstName, $user->getFirstName());
        $this->assertEquals($lastName, $user->getLastName());
        $this->assertEquals($firstNameKana, $user->getFirstNameKana());
        $this->assertEquals($lastNameKana, $user->getLastNameKana());
        $this->assertEquals($mailAddress, $user->getMailAddress());
        $this->assertEquals($sex, $user->getSex());
        $this->assertEquals($birthDay, $user->getBirthDay());
        $this->assertEquals($cellPhoneNumber, $user->getCellPhoneNumber());
        $this->assertEquals($remarks, $user->getRemarks());
    }
}
