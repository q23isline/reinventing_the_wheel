<?php
declare(strict_types=1);

namespace App\Infrastructure\CakePHP\Users;

use App\Domain\Models\User\IUserRepository;
use App\Domain\Models\User\Type\BirthDay;
use App\Domain\Models\User\Type\CellPhoneNumber;
use App\Domain\Models\User\Type\FirstName;
use App\Domain\Models\User\Type\FirstNameKana;
use App\Domain\Models\User\Type\LastName;
use App\Domain\Models\User\Type\LastNameKana;
use App\Domain\Models\User\Type\LoginId;
use App\Domain\Models\User\Type\MailAddress;
use App\Domain\Models\User\Type\Password;
use App\Domain\Models\User\Type\RoleName;
use App\Domain\Models\User\Type\Sex;
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
        $model = TableRegistry::getTableLocator()->get('Users');
        $record = $model->get($userId->getValue());

        // パスワード等 Entity の hidden 項目を toArray() で返すようにする
        $record->setHidden([]);

        return $this->buildEntity($record->toArray());
    }

    /**
     * @inheritDoc
     */
    public function findByLoginId(LoginId $loginId): ?User
    {
        $model = TableRegistry::getTableLocator()->get('Users');
        $records = $model->find()
            ->where(['username' => $loginId->getValue()])
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
        $model = TableRegistry::getTableLocator()->get('Users');

        $saveData = [
            'Users' => [
                'username' => $user->getLoginId()->getValue(),
                'password' => $user->getPassword()->getValue(),
                'role' => $user->getRoleName()->getValue(),
                'first_name' => $user->getFirstName()->getValue(),
                'last_name' => $user->getLastName()->getValue(),
                'first_name_kana' => $user->getFirstNameKana()->getValue(),
                'last_name_kana' => $user->getLastNameKana()->getValue(),
                'mail_address' => $user->getMailAddress()->getValue(),
                'sex' => $user->getSex()->getValue(),
                'birth_day' => is_null($user->getBirthDay()) ? null : $user->getBirthDay()->getValue(),
                'cell_phone_number' =>
                    is_null($user->getCellPhoneNumber()) ? null : $user->getCellPhoneNumber()->getValue(),
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

        $saveData = [
            'Users' => [
                'username' => $user->getLoginId()->getValue(),
                'password' => $user->getPassword()->getValue(),
                'role' => $user->getRoleName()->getValue(),
                'first_name' => $user->getFirstName()->getValue(),
                'last_name' => $user->getLastName()->getValue(),
                'first_name_kana' => $user->getFirstNameKana()->getValue(),
                'last_name_kana' => $user->getLastNameKana()->getValue(),
                'mail_address' => $user->getMailAddress()->getValue(),
                'sex' => $user->getSex()->getValue(),
                'birth_day' => is_null($user->getBirthDay()) ? null : $user->getBirthDay()->getValue(),
                'cell_phone_number' =>
                    is_null($user->getCellPhoneNumber()) ? null : $user->getCellPhoneNumber()->getValue(),
            ],
        ];

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

    /**
     * @param array<string,mixed> $record record
     * @return \App\Domain\Models\User\User
     */
    private function buildEntity(array $record): User
    {
        $user = new User(new UserId($record['id']));

        $user->setLoginId(new LoginId($record['username']));
        $user->setPassword(new Password($record['password']));
        $user->setRoleName(new RoleName($record['role']));
        $user->setFirstName(new FirstName($record['first_name']));
        $user->setLastName(new LastName($record['last_name']));
        $user->setFirstNameKana(new FirstNameKana($record['first_name_kana']));
        $user->setLastNameKana(new LastNameKana($record['last_name_kana']));
        $user->setMailAddress(new MailAddress($record['mail_address']));
        $user->setSex(new Sex($record['sex']));

        if (!empty($record['birth_day'])) {
            $user->setBirthDay(new BirthDay($record['birth_day']->format('Y-m-d')));
        }

        if (!empty($record['cell_phone_number'])) {
            $user->setCellPhoneNumber(new CellPhoneNumber($record['cell_phone_number']));
        }

        return $user;
    }
}
