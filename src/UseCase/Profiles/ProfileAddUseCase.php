<?php
declare(strict_types=1);

namespace App\UseCase\Profiles;

use App\Domain\Models\File\IFileRepository;
use App\Domain\Models\File\IFileStorageRepository;
use App\Domain\Models\File\Type\FileId;
use App\Domain\Models\Profile\IProfileRepository;
use App\Domain\Models\Profile\Profile;
use App\Domain\Models\Profile\Type\BirthDay;
use App\Domain\Models\Profile\Type\CellPhoneNumber;
use App\Domain\Models\Profile\Type\FirstName;
use App\Domain\Models\Profile\Type\FirstNameKana;
use App\Domain\Models\Profile\Type\LastName;
use App\Domain\Models\Profile\Type\LastNameKana;
use App\Domain\Models\Profile\Type\ProfileId;
use App\Domain\Models\Profile\Type\ProfileImage;
use App\Domain\Models\Profile\Type\Remarks;
use App\Domain\Models\Profile\Type\Sex;
use App\Domain\Models\User\Type\UserId;

/**
 * class ProfileAddUseCase
 */
class ProfileAddUseCase
{
    /**
     * constructor
     *
     * @param \App\Domain\Models\Profile\IProfileRepository $profileRepository profileRepository
     * @param \App\Domain\Models\File\IFileRepository $fileRepository fileRepository
     * @param \App\Domain\Models\File\IFileStorageRepository $fileStorageRepository fileStorageRepository
     */
    public function __construct(
        private IProfileRepository $profileRepository,
        private IFileRepository $fileRepository,
        private IFileStorageRepository $fileStorageRepository
    ) {
    }

    /**
     * プロフィールを新規追加する
     *
     * @param \App\UseCase\Profiles\ProfileAddCommand $command command
     * @return \App\Domain\Models\Profile\Type\ProfileId
     */
    public function handle(ProfileAddCommand $command): ProfileId
    {
        $birthDay = $command->birthDay;
        $cellPhoneNumber = $command->cellPhoneNumber;
        $remarks = $command->remarks;

        $profileImage = null;
        if (!empty($command->profileImageFileId)) {
            $file = $this->fileRepository->getById(
                new FileId($command->profileImageFileId)
            );

            $profileImage = new ProfileImage(
                $file->id,
                $this->fileStorageRepository->getUrl(
                    $file->fileDirectory,
                    $file->id,
                    $file->fileName,
                )
            );
        }

        $data = Profile::create(
            // TODO: 採番処理を ProfileId ドメインの中でやりたい
            $this->profileRepository->assignId(),
            new UserId($command->userId),
            new FirstName($command->firstName),
            new LastName($command->lastName),
            new FirstNameKana($command->firstNameKana),
            new LastNameKana($command->lastNameKana),
            new Sex($command->sex),
            empty($birthDay) ? null : new BirthDay($birthDay),
            empty($cellPhoneNumber) ? null : new CellPhoneNumber($cellPhoneNumber),
            empty($remarks) ? null : new Remarks($remarks),
            $profileImage,
        );

        return $this->profileRepository->save($data);
    }
}
