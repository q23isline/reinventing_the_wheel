<?php
declare(strict_types=1);

namespace App\Test\TestCase\UseCase\Profiles;

use App\Domain\Models\Profile\Type\ProfileId;
use App\Infrastructure\InMemory\Profiles\InMemoryProfileRepository;
use App\UseCase\Profiles\ProfileDeleteCommand;
use App\UseCase\Profiles\ProfileDeleteUseCase;
use Cake\Datasource\Exception\RecordNotFoundException;
use Cake\TestSuite\TestCase;

/**
 * App\UseCase\Profiles\ProfileDeleteUseCase Test Case
 *
 * @uses \App\UseCase\Profiles\ProfileDeleteUseCase
 */
final class ProfileDeleteUseCaseTest extends TestCase
{
    /**
     * Test handle method
     *
     * @return void
     */
    public function test_プロフィールが削除されること(): void
    {
        // Arrange
        $profileRepository = new InMemoryProfileRepository();
        $profileDeleteUseCase = new ProfileDeleteUseCase($profileRepository);

        $profileId = 'c2e37627-ac0a-45e0-9dfd-eb5d703d8989';
        $profile = (new TestProfileFactory())->create(profileId: $profileId);
        $profileRepository->save($profile);
        $inputData = new ProfileDeleteCommand($profileId);

        // Act
        $profileDeleteUseCase->handle($inputData);

        // Assert
        // 正しく削除されているか（存在しない ID エラーになること）
        $this->expectException(RecordNotFoundException::class);
        $profileRepository->getById(new ProfileId($profileId));
    }

    /**
     * Test handle method
     *
     * @return void
     */
    public function test_プロフィールが削除できないこと：存在しないプロフィールID(): void
    {
        // Arrange
        $profileRepository = new InMemoryProfileRepository();
        $profileDeleteUseCase = new ProfileDeleteUseCase($profileRepository);

        $inputData = new ProfileDeleteCommand('01509588-3882-42dd-9ab2-485e8e579a8e');

        // Assert
        // 削除に失敗するか
        $this->expectException(RecordNotFoundException::class);

        // Act
        $profileDeleteUseCase->handle($inputData);
    }
}
