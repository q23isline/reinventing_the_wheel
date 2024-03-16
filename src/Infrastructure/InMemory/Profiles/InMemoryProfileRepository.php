<?php
declare(strict_types=1);

namespace App\Infrastructure\InMemory\Profiles;

use App\Domain\Models\Profile\IProfileRepository;
use App\Domain\Models\Profile\Profile;
use App\Domain\Models\Profile\ProfileCollection;
use App\Domain\Models\Profile\Type\ProfileId;
use Cake\Datasource\Exception\RecordNotFoundException;

/**
 * class InMemoryProfileRepository
 */
final class InMemoryProfileRepository implements IProfileRepository
{
    /**
     * @var array<string,\App\Domain\Models\Profile\Profile> $store store
     */
    public array $store = [];

    /**
     * @inheritDoc
     */
    public function assignId(): ProfileId
    {
        $uuid = (string)mt_rand(0, 99999999) . '-3882-42dd-9ab2-485e8e579a8e';

        return new ProfileId($uuid);
    }

    /**
     * @inheritDoc
     */
    public function getById(ProfileId $profileId): Profile
    {
        if (array_key_exists($profileId->value, $this->store)) {
            return $this->clone($this->store[$profileId->value]);
        } else {
            throw new RecordNotFoundException();
        }
    }

    /**
     * @inheritDoc
     */
    public function findAll(?string $searchKeyword = null): ProfileCollection
    {
        $data = new ProfileCollection();
        foreach ($this->store as $elem) {
            $record = $this->clone($elem);
            $data->add($record);
        }

        return $data;
    }

    /**
     * @inheritDoc
     */
    public function save(Profile $profile): ProfileId
    {
        $this->store[$profile->id->value] = $this->clone($profile);

        return $profile->id;
    }

    /**
     * @inheritDoc
     */
    public function update(Profile $profile): ProfileId
    {
        $this->store[$profile->id->value] = $this->clone($profile);

        return $profile->id;
    }

    /**
     * @inheritDoc
     */
    public function delete(ProfileId $profileId): void
    {
        if (array_key_exists($profileId->value, $this->store)) {
            unset($this->store[$profileId->value]);
        } else {
            throw new RecordNotFoundException();
        }
    }

    /**
     * @param \App\Domain\Models\Profile\Profile $profile profile
     * @return \App\Domain\Models\Profile\Profile
     */
    private function clone(Profile $profile): Profile
    {
        $birthDay = $profile->birthDay;
        $cellPhoneNumber = $profile->cellPhoneNumber;
        $remarks = $profile->remarks;

        return Profile::reconstruct(
            $profile->id,
            $profile->userId,
            $profile->firstName,
            $profile->lastName,
            $profile->firstNameKana,
            $profile->lastNameKana,
            $profile->sex,
            empty($birthDay) ? null : $birthDay,
            empty($cellPhoneNumber) ? null : $cellPhoneNumber,
            empty($remarks) ? null : $remarks,
        );
    }
}
