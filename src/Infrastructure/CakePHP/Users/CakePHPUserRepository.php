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
     * @inheritdoc
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
}
