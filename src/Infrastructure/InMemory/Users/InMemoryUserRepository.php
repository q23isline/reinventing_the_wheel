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
 */
class InMemoryUserRepository implements IUserRepository
{
    /**
     * @var array<string,\App\Domain\Models\User\User>
     */
    public $store = [];

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
        if (array_key_exists($userId->getValue(), $this->store)) {
            return $this->clone($this->store[$userId->getValue()]);
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
            if ($elem->getLoginId()->getValue() === $loginId->getValue()) {
                return $this->clone($elem);
            }
        }

        return null;
    }

    /**
     * @inheritDoc
     */
    public function findAll(): UserCollection
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
        $this->store[$user->getId()->getValue()] = $this->clone($user);

        return $user->getId();
    }

    /**
     * @inheritDoc
     */
    public function update(User $user): UserId
    {
        $this->store[$user->getId()->getValue()] = $this->clone($user);

        return $user->getId();
    }

    /**
     * @inheritDoc
     */
    public function delete(UserId $userId): void
    {
        if (array_key_exists($userId->getValue(), $this->store)) {
            unset($this->store[$userId->getValue()]);
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
        $birthDay = null;
        if (!empty($user->getBirthDay())) {
            $birthDay = $user->getBirthDay();
        }

        $cellPhoneNumber = null;
        if (!empty($user->getCellPhoneNumber())) {
            $cellPhoneNumber = $user->getCellPhoneNumber();
        }

        $remarks = null;
        if (!empty($user->getRemarks())) {
            $remarks = $user->getRemarks();
        }

        return User::reconstruct(
            $user->getId(),
            $user->getLoginId(),
            $user->getPassword(),
            $user->getRoleName(),
            $user->getFirstName(),
            $user->getLastName(),
            $user->getFirstNameKana(),
            $user->getLastNameKana(),
            $user->getMailAddress(),
            $user->getSex(),
            $birthDay,
            $cellPhoneNumber,
            $remarks,
        );
    }
}
