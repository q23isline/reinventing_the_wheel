<?php
declare(strict_types=1);

namespace App\Test\TestCase\UseCase\Profiles;

use App\Infrastructure\InMemory\Files\InMemoryFileRepository;
use App\Infrastructure\InMemory\Files\InMemoryFileStorageRepository;
use App\Infrastructure\InMemory\Profiles\InMemoryProfileRepository;
use App\UseCase\Profiles\ProfileAddCommand;
use App\UseCase\Profiles\ProfileAddUseCase;
use Cake\TestSuite\TestCase;

/**
 * App\UseCase\Profiles\ProfileAddUseCase Test Case
 *
 * @uses \App\UseCase\Profiles\ProfileAddUseCase
 */
final class ProfileAddUseCaseTest extends TestCase
{
    /**
     * Test handle method
     *
     * @return void
     */
    public function test_プロフィールが登録されること(): void
    {
        // Arrange
        $profileRepository = new InMemoryProfileRepository();
        $fileRepository = new InMemoryFileRepository();
        $fileStorageRepository = new InMemoryFileStorageRepository();
        $profileAddUseCase = new ProfileAddUseCase($profileRepository, $fileRepository, $fileStorageRepository);

        $userId = '41559b8b-e831-4972-8afa-21ee8b952d85';
        $inputData = new ProfileAddCommand(
            userId: $userId,
            firstName: 'test1',
            lastName: 'test2',
            firstNameKana: 'テストイチ',
            lastNameKana: 'テストニ',
            sex: '1',
            birthDay: '1980-01-01',
            cellPhoneNumber: '09012345678',
            remarks: 'テストメモ',
            // ファイル登録テストはいったんしない
            profileImageFileId: null,
        );

        // Act
        $createdProfileId = $profileAddUseCase->handle($inputData);

        // Assert
        // 正しく保存されているか
        $createdProfile = $profileRepository->getById($createdProfileId);
        $this->assertEquals($userId, $createdProfile->userId->value);
    }
}
