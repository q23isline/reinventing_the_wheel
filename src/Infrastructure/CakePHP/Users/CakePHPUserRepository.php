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
use Cake\ORM\TableRegistry;

/**
 * class CakePHPUserRepository
 */
final class CakePHPUserRepository implements IUserRepository
{
    /**
     * @inheritDoc
     */
    public function findByLoginId(LoginId $loginId): ?User
    {
        $model = TableRegistry::getTableLocator()->get('Users');
        $record = $model->find()
            ->where([
                'username' => $loginId->getValue(),
            ])
            ->first();

        if (is_null($record)) {
            return null;
        }

        return new User(
            new UserId($record->id),
            new LoginId($record->username),
            null,
            new RoleName($record->role),
            new FirstName($record->first_name),
            new LastName($record->last_name),
            new AuditDate((string)$record->created),
            new AuditDate((string)$record->modified)
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
                'username' => $user->getLoginId()->getValue(),
                'password' => $user->getPassword()->getValue(),
                'role' => $user->getRoleName()->getValue(),
                'first_name' => $user->getFirstName()->getValue(),
                'last_name' => $user->getLastName()->getValue(),
            ],
        ];

        $entity = $model->newEmptyEntity();
        $entity = $model->patchEntity($entity, $saveData);
        $saved = $model->saveOrFail($entity);

        return new UserId($saved->id);
    }
}
