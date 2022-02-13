<?php
declare(strict_types=1);

namespace App\UseCase\Profiles;

use App\Domain\Models\Profile\IProfileRepository;
use App\Domain\Models\Profile\Type\ProfileId;

/**
 * class ProfileGetUseCase
 */
class ProfileGetUseCase
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
     * プロフィール詳細を取得する
     *
     * @param \App\UseCase\Profiles\ProfileGetCommand $command command
     * @return \App\UseCase\Profiles\ProfileData
     */
    public function handle(ProfileGetCommand $command): ProfileData
    {
        $profileId = new ProfileId($command->profileId);
        $profile = $this->profileRepository->getById($profileId);

        return new ProfileData($profile);
    }
}
