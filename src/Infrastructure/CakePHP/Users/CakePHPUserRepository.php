<?php
declare(strict_types=1);

namespace App\Infrastructure\CakePHP\Users;

use App\Domain\Models\User\IUserRepository;
use App\Domain\Models\User\Type\MailAddress;
use App\Domain\Models\User\Type\Password;
use App\Domain\Models\User\Type\RoleName;
use App\Domain\Models\User\Type\UserId;
use App\Domain\Models\User\User;
use App\Domain\Models\User\UserCollection;
use Cake\ORM\TableRegistry;
use Cake\Utility\Text;

/**
 * class CakePHPUserRepository
 */
final class CakePHPUserRepository implements IUserRepository
{
    /**
     * @inheritDoc
     */
    public function assignId(): UserId
    {
        return new UserId(Text::uuid());
    }

    /**
     * @inheritDoc
     */
    public function getById(UserId $userId): User
    {
        /** @var \App\Model\Table\UsersTable $model */
        $model = TableRegistry::getTableLocator()->get('Users');
        $record = $model->get($userId->value);

        // パスワード等 Entity の hidden 項目を toArray() で返すようにする
        $record->setHidden([]);

        return $this->buildEntity($record->toArray());
    }

    /**
     * @inheritDoc
     */
    public function findByMailAddress(MailAddress $mailAddress): ?User
    {
        /** @var \App\Model\Table\UsersTable $model */
        $model = TableRegistry::getTableLocator()->get('Users');
        $records = $model->find()
            ->where(['mail_address' => $mailAddress->value])
            ->toArray();

        if (empty($records)) {
            return null;
        }

        $record = $records[0]->setHidden([]);

        return $this->buildEntity($record->toArray());
    }

    /**
     * @inheritDoc
     */
    public function findAll(): UserCollection
    {
        /** @var \App\Model\Table\UsersTable $model */
        $model = TableRegistry::getTableLocator()->get('Users');
        $records = $model->find()->all()->toArray();
        $data = new UserCollection();
        foreach ($records as $record) {
            $record->setHidden([]);
            $data->add($this->buildEntity($record->toArray()));
        }

        return $data;
    }

    /**
     * @inheritDoc
     */
    public function save(User $user): UserId
    {
        /** @var \App\Model\Table\UsersTable $model */
        $model = TableRegistry::getTableLocator()->get('Users');

        $saveData = [
            'Users' => [
                'mail_address' => $user->mailAddress->value,
                'password' => $user->password->value,
                'role' => $user->roleName->value,
            ],
        ];

        $entity = $model->newEmptyEntity();
        $entity = $model->patchEntity($entity, $saveData);
        // $saveData に id を設定しても patchEntity() 時に id が消え去るため、明示的に設定
        $entity->id = $user->id->value;
        $saved = $model->saveOrFail($entity);

        return new UserId($saved->id);
    }

    /**
     * @inheritDoc
     */
    public function update(User $user): UserId
    {
        /** @var \App\Model\Table\UsersTable $model */
        $model = TableRegistry::getTableLocator()->get('Users');

        $saveData = [
            'Users' => [
                'mail_address' => $user->mailAddress->value,
                'password' => $user->password->value,
                'role' => $user->roleName->value,
            ],
        ];

        $entity = $model->get($user->id->value);
        $entity = $model->patchEntity($entity, $saveData);
        $saved = $model->saveOrFail($entity);

        return new UserId($saved->id);
    }

    /**
     * @inheritDoc
     */
    public function delete(UserId $userId): void
    {
        /** @var \App\Model\Table\UsersTable $model */
        $model = TableRegistry::getTableLocator()->get('Users');
        $entity = $model->get($userId->value);
        $model->deleteOrFail($entity);
    }

    /**
     * @param array<string,mixed> $record record
     * @return \App\Domain\Models\User\User
     */
    private function buildEntity(array $record): User
    {
        return User::reconstruct(
            new UserId($record['id']),
            new MailAddress($record['mail_address']),
            new Password($record['password']),
            new RoleName($record['role']),
        );
    }
}
