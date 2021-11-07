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
use App\Domain\Models\User\Type\Remarks;
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
                'remarks' => is_null($user->getRemarks()) ? null : $user->getRemarks()->getValue(),
            ],
        ];

        $entity = $model->newEmptyEntity();
        $entity = $model->patchEntity($entity, $saveData);
        // $saveData に id を設定しても patchEntity() 時に id が消え去るため、明示的に設定
        $entity->id = $user->getId()->getValue();
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
                'remarks' => is_null($user->getRemarks()) ? null : $user->getRemarks()->getValue(),
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
        $birthDay = null;
        if (!empty($record['birth_day'])) {
            $birthDay = new BirthDay($record['birth_day']->format('Y-m-d'));
        }

        $cellPhoneNumber = null;
        if (!empty($record['cell_phone_number'])) {
            $cellPhoneNumber = new CellPhoneNumber($record['cell_phone_number']);
        }

        $remarks = null;
        if (!empty($record['remarks'])) {
            $remarks = new Remarks($record['remarks']);
        }

        return User::reconstruct(
            new UserId($record['id']),
            new LoginId($record['username']),
            new Password($record['password']),
            new RoleName($record['role']),
            new FirstName($record['first_name']),
            new LastName($record['last_name']),
            new FirstNameKana($record['first_name_kana']),
            new LastNameKana($record['last_name_kana']),
            new MailAddress($record['mail_address']),
            new Sex($record['sex']),
            $birthDay,
            $cellPhoneNumber,
            $remarks,
        );
    }
}
