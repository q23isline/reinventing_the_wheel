<?php
declare(strict_types=1);

namespace App\UseCase\Profiles;

use App\Domain\Models\Profile\IProfileRepository;

/**
 * class ProfileListUseCase
 */
class ProfileListUseCase
{
    /**
     * constructor
     *
     * @param \App\Domain\Models\Profile\IProfileRepository $profileRepository profileRepository
     */
    public function __construct(
        private IProfileRepository $profileRepository
    ) {
    }

    /**
     * プロフィール一覧を取得する
     *
     * @param \App\UseCase\Profiles\ProfileListCommand $command command
     * @return \App\UseCase\Profiles\ProfileData[]
     */
    public function handle(ProfileListCommand $command): array
    {
        $searchKeyword = $command->keyword;

        $profiles = $this->profileRepository->findAll($searchKeyword);

        $profileData = [];
        foreach ($profiles as $profile) {
            $profileData[] = new ProfileData($profile);
        }

        return $profileData;
    }
}
