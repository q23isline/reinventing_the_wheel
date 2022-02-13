<?php
declare(strict_types=1);

namespace App\UseCase\Profiles;

use App\Domain\Models\Profile\IProfileRepository;
use App\Domain\Models\Profile\Type\BirthDay;
use App\Domain\Models\Profile\Type\CellPhoneNumber;
use App\Domain\Models\Profile\Type\FirstName;
use App\Domain\Models\Profile\Type\FirstNameKana;
use App\Domain\Models\Profile\Type\LastName;
use App\Domain\Models\Profile\Type\LastNameKana;
use App\Domain\Models\Profile\Type\ProfileId;
use App\Domain\Models\Profile\Type\Remarks;
use App\Domain\Models\Profile\Type\Sex;

/**
 * class ProfileUpdateUseCase
 */
class ProfileUpdateUseCase
{
    /**
     * constructor
     *
     * @param \App\Domain\Models\Profile\IProfileRepository $profileRepository profileRepository
     */
    public function __construct(private IProfileRepository $profileRepository)
    {
    }

    /**
     * プロフィールを更新する
     *
     * @param \App\UseCase\Profiles\ProfileUpdateCommand $command command
     * @return \App\Domain\Models\Profile\Type\ProfileId
     * @throws \App\Domain\Shared\Exception\ValidateException
     */
    public function handle(ProfileUpdateCommand $command): ProfileId
    {
        $data = $this->profileRepository->getById(new ProfileId($command->profileId));

        $birthDay = $command->birthDay;
        $cellPhoneNumber = $command->cellPhoneNumber;
        $remarks = $command->remarks;

        $data = $data->update(
            new FirstName($command->firstName),
            new LastName($command->lastName),
            new FirstNameKana($command->firstNameKana),
            new LastNameKana($command->lastNameKana),
            new Sex($command->sex),
            empty($birthDay) ? null : new BirthDay($birthDay),
            empty($cellPhoneNumber) ? null : new CellPhoneNumber($cellPhoneNumber),
            empty($remarks) ? null : new Remarks($remarks),
        );

        return $this->profileRepository->update($data);
    }
}
