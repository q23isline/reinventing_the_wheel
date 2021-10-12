<?php
declare(strict_types=1);

namespace App\Infrastructure\CakePHP\Users;

use App\Domain\Models\User\IUserRepository;
use App\Domain\Models\User\Type\FirstName;
use App\Domain\Models\User\Type\LastName;
use App\Domain\Models\User\Type\LoginId;
use App\Domain\Models\User\Type\RoleName;
use App\Domain\Models\User\Type\UserId;
use App\Domain\Models\User\User;
use App\Domain\Models\User\UserCollection;
use App\Domain\Shared\AuditDate;
use Cake\Datasource\Exception\RecordNotFoundException;
use Cake\ORM\TableRegistry;

/**
 * class CakePHPUserRepository
 */
final class CakePHPUserRepository implements IUserRepository
{
    /**
     * @inheritDoc
     */
    public function getById(UserId $userId): User
    {
        $model = TableRegistry::getTableLocator()->get('Users');
        $record = $model->get($userId->getValue())->toArray();

        return new User(
            new UserId($record['id']),
            new LoginId($record['username']),
            null,
            new RoleName($record['role']),
            new FirstName($record['first_name']),
            new LastName($record['last_name']),
            new AuditDate((string)$record['created']),
            new AuditDate((string)$record['modified'])
        );
    }

    /**
     * @inheritDoc
     */
    public function findByLoginId(LoginId $loginId): ?User
    {
        $model = TableRegistry::getTableLocator()->get('Users');
        $record = $model->find()
            ->where(['username' => $loginId->getValue()])
            ->first();

        if (is_null($record)) {
            return null;
        }

        return new User(
            new UserId($record['id']),
            new LoginId($record['username']),
            null,
            new RoleName($record['role']),
            new FirstName($record['first_name']),
            new LastName($record['last_name']),
            new AuditDate((string)$record['created']),
            new AuditDate((string)$record['modified'])
        );
    }

    /**
     * @inheritDoc
     */
    public function findAll(): UserCollection
    {
        $model = TableRegistry::getTableLocator()->get('Users');
        $records = $model->find()->all();

        $data = new UserCollection();
        foreach ($records as $record) {
            $data->add(
                new User(
                    new UserId($record->id),
                    new LoginId($record->username),
                    null,
                    new RoleName($record->role),
                    new FirstName($record->first_name),
                    new LastName($record->last_name),
                    new AuditDate((string)$record->created),
                    new AuditDate((string)$record->modified)
                )
            );
        }

        return $data;
    }

    /**
     * @inheritDoc
     */
    public function save(User $user): UserId
    {
        $model = TableRegistry::getTableLocator()->get('Users');

        $saveData = [
            'Users' => [
                'username' => is_null($user->getLoginId()) ? null : $user->getLoginId()->getValue(),
                'password' => is_null($user->getPassword()) ? null : $user->getPassword()->getValue(),
                'role' => is_null($user->getRoleName()) ? null : $user->getRoleName()->getValue(),
                'first_name' => is_null($user->getFirstName()) ? null : $user->getFirstName()->getValue(),
                'last_name' => is_null($user->getLastName()) ? null : $user->getLastName()->getValue(),
            ],
        ];

        $entity = $model->newEmptyEntity();
        $entity = $model->patchEntity($entity, $saveData);
        $saved = $model->saveOrFail($entity);

        return new UserId($saved->id);
    }

    /**
     * @inheritDoc
     */
    public function update(User $user): UserId
    {
        $model = TableRegistry::getTableLocator()->get('Users');

        $saveData = [];

        // null チェックが多すぎるが…

        if (!is_null($user->getLoginId())) {
            $saveData['Users']['username'] = $user->getLoginId()->getValue();
        }

        if (!is_null($user->getPassword())) {
            $saveData['Users']['password'] = $user->getPassword()->getValue();
        }

        if (!is_null($user->getRoleName())) {
            $saveData['Users']['role'] = $user->getRoleName()->getValue();
        }

        if (!is_null($user->getFirstName())) {
            $saveData['Users']['first_name'] = $user->getFirstName()->getValue();
        }

        if (!is_null($user->getLastName())) {
            $saveData['Users']['last_name'] = $user->getLastName()->getValue();
        }

        if (is_null($user->getId())) {
            throw new RecordNotFoundException();
        }

        $entity = $model->get($user->getId()->getValue());
        $entity = $model->patchEntity($entity, $saveData);
        $saved = $model->saveOrFail($entity);

        return new UserId($saved->id);
    }

    /**
     * @inheritDoc
     */
    public function delete(UserId $userId): void
    {
        $model = TableRegistry::getTableLocator()->get('Users');
        $entity = $model->get($userId->getValue());
        $model->deleteOrFail($entity);
    }
}
