<?php
declare(strict_types=1);

namespace App\Test\TestCase\UseCase\Profiles;

use App\Infrastructure\InMemory\Profiles\InMemoryProfileRepository;
use App\UseCase\Profiles\ProfileData;
use App\UseCase\Profiles\ProfileListCommand;
use App\UseCase\Profiles\ProfileListUseCase;
use Cake\TestSuite\TestCase;

/**
 * App\UseCase\Profiles\ProfileListUseCase Test Case
 *
 * @uses \App\UseCase\Profiles\ProfileListUseCase
 */
final class ProfileListUseCaseTest extends TestCase
{
    /**
     * Test handle method
     *
     * @return void
     */
    public function test_プロフィール一覧が参照できること(): void
    {
        // Arrange
        $profileRepository = new InMemoryProfileRepository();
        $profileListUseCase = new ProfileListUseCase($profileRepository);

        $profileId1 = '01509588-3882-42dd-9ab2-485e8e579a8e';
        $profile1 = (new TestProfileFactory())->create(profileId: $profileId1);
        $profileRepository->save($profile1);

        $profileId2 = '99999999-3882-42dd-9ab2-485e8e579a8e';
        $profile2 = (new TestProfileFactory())->create(profileId: $profileId2);
        $profileRepository->save($profile2);

        // テスト実行を sqlite にしているため、FULLTEXT INDEX のテストができない
        // 検索条件なしのテストのみを行う
        $command = new ProfileListCommand(null);

        // Act
        $actualProfileDtos = $profileListUseCase->handle($command);

        // Assert
        // 正しく参照できるか
        $expectDto1 = new ProfileData($profile1);
        $expectDto2 = new ProfileData($profile2);
        $this->assertEquals(2, count($actualProfileDtos));
        $this->assertEquals($expectDto1, $actualProfileDtos[0]);
        $this->assertEquals($expectDto2, $actualProfileDtos[1]);
    }
}
