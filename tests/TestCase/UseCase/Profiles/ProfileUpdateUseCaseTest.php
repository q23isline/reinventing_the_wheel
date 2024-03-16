<?php
declare(strict_types=1);

namespace App\Test\TestCase\UseCase\Profiles;

use App\Domain\Models\Profile\Type\ProfileId;
use App\Infrastructure\InMemory\Profiles\InMemoryProfileRepository;
use App\UseCase\Profiles\ProfileUpdateCommand;
use App\UseCase\Profiles\ProfileUpdateUseCase;
use Cake\Datasource\Exception\RecordNotFoundException;
use Cake\TestSuite\TestCase;

/**
 * App\UseCase\Profiles\ProfileUpdateUseCase Test Case
 *
 * @uses \App\UseCase\Profiles\ProfileUpdateUseCase
 */
final class ProfileUpdateUseCaseTest extends TestCase
{
    /**
     * Test handle method
     *
     * @return void
     */
    public function test_プロフィールが更新されること(): void
    {
        // Arrange
        $profileRepository = new InMemoryProfileRepository();
        $profileUpdateUseCase = new ProfileUpdateUseCase($profileRepository);

        $profileId = 'c2e37627-ac0a-45e0-9dfd-eb5d703d8989';
        $userId = '01509588-3882-42dd-9ab2-485e8e579a8e';
        $firstName = 'test2';
        $lastName = 'test3';
        $firstNameKana = 'テストニ';
        $lastNameKana = 'テストサン';
        $sex = '2';
        $birthDay = '1980-01-02';
        $cellPhoneNumber = '09012345679';
        $remarks = 'テストメモ';
        $profile = (new TestProfileFactory())->create(
            profileId: $profileId,
            firstName: 'test1',
            lastName: 'test2',
            firstNameKana: 'テストイチ',
            lastNameKana: 'テストニ',
            sex: '1',
            birthDay: '1980-01-01',
            cellPhoneNumber: '09012345678',
            remarks: 'テストメモ',
        );
        $profileRepository->save($profile);
        $inputData = new ProfileUpdateCommand(
            profileId: $profileId,
            firstName: $firstName,
            lastName: $lastName,
            firstNameKana: $firstNameKana,
            lastNameKana: $lastNameKana,
            sex: $sex,
            birthDay: $birthDay,
            cellPhoneNumber: $cellPhoneNumber,
            remarks: $remarks,
        );

        // Act
        $profileUpdateUseCase->handle($inputData);

        // Assert
        // 正しく保存されているか
        $updatedProfileId = new ProfileId($profileId);
        $updatedProfile = $profileRepository->getById($updatedProfileId);
        $this->assertEquals($profileId, $updatedProfile->id->value);
        $this->assertEquals($userId, $updatedProfile->userId->value);
        $this->assertEquals($firstName, $updatedProfile->firstName->value);
        $this->assertEquals($lastName, $updatedProfile->lastName->value);
        $this->assertEquals($firstNameKana, $updatedProfile->firstNameKana->value);
        $this->assertEquals($lastNameKana, $updatedProfile->lastNameKana->value);
        $this->assertEquals($sex, $updatedProfile->sex->value);
        $this->assertEquals($birthDay, $updatedProfile->birthDay?->value);
        $this->assertEquals($cellPhoneNumber, $updatedProfile->cellPhoneNumber?->value);
        $this->assertEquals($remarks, $updatedProfile->remarks?->value);
    }

    /**
     * Test handle method
     *
     * @return void
     */
    public function test_プロフィールが更新できないこと：存在しないプロフィールID(): void
    {
        // Arrange
        $profileRepository = new InMemoryProfileRepository();
        $profileUpdateUseCase = new ProfileUpdateUseCase($profileRepository);

        $inputData = new ProfileUpdateCommand(
            profileId: '01509588-3882-42dd-9ab2-485e8e579a8e',
            firstName: 'test2',
            lastName: 'test3',
            firstNameKana: 'テストニ',
            lastNameKana: 'テストサン',
            sex: '2',
            birthDay: '1980-01-02',
            cellPhoneNumber: '09012345679',
            remarks: 'テストメモ',
        );

        // Assert
        // 更新に失敗するか
        $this->expectException(RecordNotFoundException::class);

        // Act
        $profileUpdateUseCase->handle($inputData);
    }
}
