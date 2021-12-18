<?php
declare(strict_types=1);

namespace App\Infrastructure\InMemory\Users;

use App\Domain\Models\User\IUserRepository;
use App\Domain\Models\User\Type\LoginId;
use App\Domain\Models\User\Type\UserId;
use App\Domain\Models\User\User;
use App\Domain\Models\User\UserCollection;
use Cake\Datasource\Exception\RecordNotFoundException;

/**
 * class InMemoryUserRepository
 *
 * @property array<string,\App\Domain\Models\User\User> $store store
 */
final class InMemoryUserRepository implements IUserRepository
{
    public array $store = [];

    /**
     * @inheritDoc
     */
    public function assignId(): UserId
    {
        $uuid = (string)mt_rand(0, 99999999) . '-3882-42dd-9ab2-485e8e579a8e';

        return new UserId($uuid);
    }

    /**
     * @inheritDoc
     */
    public function getById(UserId $userId): User
    {
        if (array_key_exists($userId->value, $this->store)) {
            return $this->clone($this->store[$userId->value]);
        } else {
            throw new RecordNotFoundException();
        }
    }

    /**
     * @inheritDoc
     */
    public function findByLoginId(LoginId $loginId): ?User
    {
        foreach ($this->store as $elem) {
            if ($elem->loginId->value === $loginId->value) {
                return $this->clone($elem);
            }
        }

        return null;
    }

    /**
     * @inheritDoc
     */
    public function findAll(?string $searchKeyword = null): UserCollection
    {
        $data = new UserCollection();
        foreach ($this->store as $elem) {
            $record = $this->clone($elem);
            $data->add($record);
        }

        return $data;
    }

    /**
     * @inheritDoc
     */
    public function save(User $user): UserId
    {
        $this->store[$user->id->value] = $this->clone($user);

        return $user->id;
    }

    /**
     * @inheritDoc
     */
    public function update(User $user): UserId
    {
        $this->store[$user->id->value] = $this->clone($user);

        return $user->id;
    }

    /**
     * @inheritDoc
     */
    public function delete(UserId $userId): void
    {
        if (array_key_exists($userId->value, $this->store)) {
            unset($this->store[$userId->value]);
        } else {
            throw new RecordNotFoundException();
        }
    }

    /**
     * @param \App\Domain\Models\User\User $user user
     * @return \App\Domain\Models\User\User
     */
    private function clone(User $user): User
    {
        $birthDay = $user->birthDay;
        $cellPhoneNumber = $user->cellPhoneNumber;
        $remarks = $user->remarks;

        return User::reconstruct(
            $user->id,
            $user->loginId,
            $user->password,
            $user->roleName,
            $user->firstName,
            $user->lastName,
            $user->firstNameKana,
            $user->lastNameKana,
            $user->mailAddress,
            $user->sex,
            empty($birthDay) ? null : $birthDay,
            empty($cellPhoneNumber) ? null : $cellPhoneNumber,
            empty($remarks) ? null : $remarks,
        );
    }
}
