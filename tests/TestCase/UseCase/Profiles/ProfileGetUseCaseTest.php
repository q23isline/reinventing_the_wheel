<?php
declare(strict_types=1);

namespace App\Test\TestCase\UseCase\Profiles;

use App\Infrastructure\InMemory\Profiles\InMemoryProfileRepository;
use App\UseCase\Profiles\ProfileData;
use App\UseCase\Profiles\ProfileGetCommand;
use App\UseCase\Profiles\ProfileGetUseCase;
use Cake\Datasource\Exception\RecordNotFoundException;
use Cake\TestSuite\TestCase;

/**
 * App\UseCase\Profiles\ProfileGetUseCase Test Case
 *
 * @uses \App\UseCase\Profiles\ProfileGetUseCase
 */
final class ProfileGetUseCaseTest extends TestCase
{
    /**
     * Test handle method
     *
     * @return void
     */
    public function test_プロフィール詳細が参照できること(): void
    {
        // Arrange
        $profileRepository = new InMemoryProfileRepository();
        $profileGetUseCase = new ProfileGetUseCase($profileRepository);

        $profileId = '01509588-3882-42dd-9ab2-485e8e579a8e';
        $profile = (new TestProfileFactory())->create(profileId: $profileId);
        $profileRepository->save($profile);
        $inputData = new ProfileGetCommand(profileId: $profileId);

        // Act
        $actualProfileDto = $profileGetUseCase->handle($inputData);

        // Assert
        // 正しく参照できるか
        $expectDto = new ProfileData($profile);
        $this->assertEquals($expectDto, $actualProfileDto);
    }

    /**
     * Test handle method
     *
     * @return void
     */
    public function test_プロフィール詳細が参照できないこと：存在しないプロフィールID(): void
    {
        // Arrange
        $profileRepository = new InMemoryProfileRepository();
        $profileGetUseCase = new ProfileGetUseCase($profileRepository);

        $inputData = new ProfileGetCommand(profileId: '01509588-3882-42dd-9ab2-485e8e579a8e');

        // Assert
        // 参照に失敗するか
        $this->expectException(RecordNotFoundException::class);

        // Act
        $profileGetUseCase->handle($inputData);
    }
}
