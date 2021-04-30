<?php
declare(strict_types=1);

namespace App\Infrastructure\CakePHP\Users;

use App\Domain\Models\User\IUserRepository;
use App\Domain\Models\User\Type\Data;
use App\Domain\Models\User\Type\FirstName;
use App\Domain\Models\User\Type\LastName;
use App\Domain\Models\User\Type\LoginId;
use App\Domain\Models\User\Type\RoleName;
use App\Domain\Models\User\Type\UserId;
use App\Domain\Models\User\User;
use Cake\ORM\TableRegistry;

/**
 * class CakePHPUserRepository
 */
final class CakePHPUserRepository implements IUserRepository
{
    /**
     * @inheritdoc
     */
    public function findAll(): array
    {
        $model = TableRegistry::getTableLocator()->get('Users');
        $records = $model->find()->all();

        $data = [];
        foreach ($records as $record) {
            $data[] = new User(
                new UserId($record->id),
                new LoginId($record->username),
                new RoleName($record->role),
                new FirstName($record->first_name),
                new LastName($record->last_name),
                new Data((string)$record->created),
                new Data((string)$record->modified)
            );
        }

        return $data;
    }
}
