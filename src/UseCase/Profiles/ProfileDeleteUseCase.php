<?php
declare(strict_types=1);

namespace App\UseCase\Profiles;

use App\Domain\Models\Profile\IProfileRepository;
use App\Domain\Models\Profile\Type\ProfileId;

/**
 * class ProfileDeleteUseCase
 */
class ProfileDeleteUseCase
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
     * プロフィールを削除する
     *
     * @param \App\UseCase\Profiles\ProfileDeleteCommand $command command
     * @return void
     */
    public function handle(ProfileDeleteCommand $command): void
    {
        $profileId = new ProfileId($command->profileId);
        $this->profileRepository->delete($profileId);
    }
}
