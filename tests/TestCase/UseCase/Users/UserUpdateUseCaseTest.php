<?php
declare(strict_types=1);

namespace App\Test\TestCase\UseCase\Users;

use App\Domain\Models\User\Type\UserId;
use App\Domain\Services\UserService;
use App\Domain\Shared\Exception\ValidateException;
use App\Infrastructure\InMemory\Users\InMemoryUserRepository;
use App\UseCase\Users\UserUpdateCommand;
use App\UseCase\Users\UserUpdateUseCase;
use Cake\Datasource\Exception\RecordNotFoundException;
use Cake\TestSuite\TestCase;

/**
 * App\UseCase\Users\UserUpdateUseCase Test Case
 *
 * @uses \App\UseCase\Users\UserUpdateUseCase
 */
class UserUpdateUseCaseTest extends TestCase
{
    /**
     * Test handle method
     *
     * @return void
     */
    public function test_ユーザーが更新されること(): void
    {
        // Arrange
        $userRepository = new InMemoryUserRepository();
        $userService = new UserService($userRepository);
        $userUpdateUseCase = new UserUpdateUseCase($userRepository, $userService);

        $userId = '01509588-3882-42dd-9ab2-485e8e579a8e';
        $loginId = 'test1';
        $password = 'p@ssw0rd1';
        $roleName = 'editor';
        $firstName = 'test2';
        $lastName = 'test3';
        $firstNameKana = 'テストニ';
        $lastNameKana = 'テストサン';
        $mailAddress = 'test1@example.com';
        $sex = '2';
        $birthDay = '1980-01-02';
        $cellPhoneNumber = '09012345679';
        $remarks = 'テストメモ';
        $user = (new TestUserFactory())->create(
            userId: $userId,
            loginId: 'test',
            password: 'p@ssw0rd',
            roleName: 'viewer',
            firstName: 'test1',
            lastName: 'test2',
            firstNameKana: 'テストイチ',
            lastNameKana: 'テストニ',
            mailAddress: 'test@example.com',
            sex: '1',
            birthDay: '1980-01-01',
            cellPhoneNumber: '09012345678',
            remarks: 'テストメモ',
        );
        $userRepository->save($user);
        $inputData = new UserUpdateCommand(
            userId: $userId,
            loginId: $loginId,
            password: $password,
            roleName: $roleName,
            firstName: $firstName,
            lastName: $lastName,
            firstNameKana: $firstNameKana,
            lastNameKana: $lastNameKana,
            mailAddress: $mailAddress,
            sex: $sex,
            birthDay: $birthDay,
            cellPhoneNumber: $cellPhoneNumber,
            remarks: $remarks,
        );

        // Act
        $userUpdateUseCase->handle($inputData);

        // Assert
        // ユーザーが正しく保存されているか
        $updatedUserId = new UserId($userId);
        $updatedUser = $userRepository->getById($updatedUserId);
        $this->assertEquals($userId, $updatedUser->getId()->getValue());
        $this->assertEquals($loginId, $updatedUser->getLoginId()->getValue());
        $this->assertEquals($password, $updatedUser->getPassword()->getValue());
        $this->assertEquals($roleName, $updatedUser->getRoleName()->getValue());
        $this->assertEquals($firstName, $updatedUser->getFirstName()->getValue());
        $this->assertEquals($lastName, $updatedUser->getLastName()->getValue());
        $this->assertEquals($firstNameKana, $updatedUser->getFirstNameKana()->getValue());
        $this->assertEquals($lastNameKana, $updatedUser->getLastNameKana()->getValue());
        $this->assertEquals($mailAddress, $updatedUser->getMailAddress()->getValue());
        $this->assertEquals($sex, $updatedUser->getSex()->getValue());
        $this->assertEquals($birthDay, $updatedUser->getBirthDay()->getValue());
        $this->assertEquals($cellPhoneNumber, $updatedUser->getCellPhoneNumber()->getValue());
        $this->assertEquals($remarks, $updatedUser->getRemarks()->getValue());
    }

    /**
     * Test handle method
     *
     * @return void
     */
    public function test_ユーザーが更新できないこと：存在しないユーザーID(): void
    {
        // Arrange
        $userRepository = new InMemoryUserRepository();
        $userService = new UserService($userRepository);
        $userUpdateUseCase = new UserUpdateUseCase($userRepository, $userService);

        $inputData = new UserUpdateCommand(
            userId: '01509588-3882-42dd-9ab2-485e8e579a8e',
            loginId: 'test',
            password: 'p@ssw0rd1',
            roleName: 'editor',
            firstName: 'test2',
            lastName: 'test3',
            firstNameKana: 'テストニ',
            lastNameKana: 'テストサン',
            mailAddress: 'test1@example.com',
            sex: '2',
            birthDay: '1980-01-02',
            cellPhoneNumber: '09012345679',
            remarks: 'テストメモ',
        );

        // Assert
        // ユーザーの更新に失敗するか
        $this->expectException(RecordNotFoundException::class);

        // Act
        $userUpdateUseCase->handle($inputData);
    }

    /**
     * Test handle method
     *
     * @return void
     */
    public function test_ユーザーが更新できないこと：登録済ログインID(): void
    {
        // Arrange
        $userRepository = new InMemoryUserRepository();
        $userService = new UserService($userRepository);
        $userUpdateUseCase = new UserUpdateUseCase($userRepository, $userService);

        $userId = '01509588-3882-42dd-9ab2-485e8e579a8e';
        $loginId = 'test1';
        $updateTargetUser = (new TestUserFactory())->create(
            userId: $userId,
            loginId: 'test'
        );
        $userRepository->save($updateTargetUser);
        $otherUser = (new TestUserFactory())->create(
            userId: '99999999-3882-42dd-9ab2-485e8e579a8e',
            loginId: $loginId
        );
        $userRepository->save($otherUser);
        $inputData = new UserUpdateCommand(
            userId: $userId,
            loginId: $loginId,
            password: 'p@ssw0rd1',
            roleName: 'editor',
            firstName: 'test2',
            lastName: 'test3',
            firstNameKana: 'テストニ',
            lastNameKana: 'テストサン',
            mailAddress: 'test1@example.com',
            sex: '2',
            birthDay: '1980-01-02',
            cellPhoneNumber: '09012345679',
            remarks: 'テストメモ',
        );

        // Assert
        // ユーザーの更新に失敗するか
        $this->expectException(ValidateException::class);

        // Act
        $userUpdateUseCase->handle($inputData);
    }
}
