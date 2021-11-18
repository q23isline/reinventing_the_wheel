<?php
declare(strict_types=1);

namespace App\Infrastructure\CakePHP\Profiles;

use App\Domain\Models\Profile\IProfileRepository;
use App\Domain\Models\Profile\Profile;
use App\Domain\Models\Profile\ProfileCollection;
use App\Domain\Models\Profile\Type\BirthDay;
use App\Domain\Models\Profile\Type\CellPhoneNumber;
use App\Domain\Models\Profile\Type\FirstName;
use App\Domain\Models\Profile\Type\FirstNameKana;
use App\Domain\Models\Profile\Type\LastName;
use App\Domain\Models\Profile\Type\LastNameKana;
use App\Domain\Models\Profile\Type\ProfileId;
use App\Domain\Models\Profile\Type\Remarks;
use App\Domain\Models\Profile\Type\Sex;
use App\Domain\Models\User\Type\UserId;
use Cake\ORM\TableRegistry;
use Cake\Utility\Text;

/**
 * class CakePHPProfileRepository
 */
final class CakePHPProfileRepository implements IProfileRepository
{
    /**
     * @inheritDoc
     */
    public function assignId(): ProfileId
    {
        return new ProfileId(Text::uuid());
    }

    /**
     * @inheritDoc
     */
    public function getById(ProfileId $profileId): Profile
    {
        $model = TableRegistry::getTableLocator()->get('Profiles');
        $record = $model->get($profileId->value);

        return $this->buildEntity($record->toArray());
    }

    /**
     * @inheritDoc
     */
    public function findAll(?string $searchKeyword = null): ProfileCollection
    {
        $model = TableRegistry::getTableLocator()->get('Profiles');
        $query = $model->find();

        if (!empty($searchKeyword)) {
            // TODO: テストのための条件分岐になっているので なんとかする
            if ($model->getConnection()->config()['driver'] === 'Cake\Database\Driver\Mysql') {
                // @codeCoverageIgnoreStart
                // PHPUnit では SQLite でのテストとなるため、カバレッジ対象外
                $remarksQuery = 'MATCH (remarks) AGAINST (:searchKeywordForFulltext IN BOOLEAN MODE)';
                // @codeCoverageIgnoreEnd
            } else {
                $remarksQuery = 'remarks MATCH :searchKeywordForFulltext';
            }

            $query = $query->where([
                'OR' => [
                    'last_name LIKE :searchKeywordForLike',
                    'first_name LIKE :searchKeywordForLike',
                    'last_name_kana LIKE :searchKeywordForLike',
                    'first_name_kana LIKE :searchKeywordForLike',
                    $remarksQuery,
                ],
            ])->bind(':searchKeywordForLike', '%' . $searchKeyword . '%', 'string')
            ->bind(':searchKeywordForFulltext', $searchKeyword, 'string');
        }

        $records = $query->all()->toArray();

        $data = new ProfileCollection();
        foreach ($records as $record) {
            $data->add($this->buildEntity($record->toArray()));
        }

        return $data;
    }

    /**
     * @inheritDoc
     */
    public function save(Profile $profile): ProfileId
    {
        $model = TableRegistry::getTableLocator()->get('Profiles');

        $saveData = [
            'Profiles' => [
                'user_id' => $profile->userId->value,
                'first_name' => $profile->firstName->value,
                'last_name' => $profile->lastName->value,
                'first_name_kana' => $profile->firstNameKana->value,
                'last_name_kana' => $profile->lastNameKana->value,
                'sex' => $profile->sex->value,
                'birth_day' => $profile->birthDay?->value,
                'cell_phone_number' => $profile->cellPhoneNumber?->value,
                'remarks' => $profile->remarks?->value,
            ],
        ];

        $entity = $model->newEmptyEntity();
        $entity = $model->patchEntity($entity, $saveData);
        // $saveData に id を設定しても patchEntity() 時に id が消え去るため、明示的に設定
        $entity->id = $profile->id->value;
        $saved = $model->saveOrFail($entity);

        // プロフィール画像がなければ終了
        if (is_null($profile->profileImage)) {
            return new ProfileId($saved->id);
        }

        $profileFilesModel = TableRegistry::getTableLocator()->get('ProfileFiles');

        $profileFilesSaveData = [
            'UserFiles' => [
                'user_id' => $profile->id->value,
                'file_id' => $profile->profileImage->id->value,
            ],
        ];

        $profileFileEntity = $profileFilesModel->newEmptyEntity();
        $profileFileEntity = $profileFilesModel->patchEntity($profileFileEntity, $profileFilesSaveData);
        $profileFilesModel->saveOrFail($profileFileEntity);

        return new ProfileId($saved->id);
    }

    /**
     * @inheritDoc
     */
    public function update(Profile $profile): ProfileId
    {
        $model = TableRegistry::getTableLocator()->get('Profiles');

        $saveData = [
            'Profiles' => [
                'first_name' => $profile->firstName->value,
                'last_name' => $profile->lastName->value,
                'first_name_kana' => $profile->firstNameKana->value,
                'last_name_kana' => $profile->lastNameKana->value,
                'sex' => $profile->sex->value,
                'birth_day' => $profile->birthDay?->value,
                'cell_phone_number' => $profile->cellPhoneNumber?->value,
                'remarks' => $profile->remarks?->value,
            ],
        ];

        $entity = $model->get($profile->id->value);
        $entity = $model->patchEntity($entity, $saveData);
        $saved = $model->saveOrFail($entity);

        return new ProfileId($saved->id);
    }

    /**
     * @inheritDoc
     */
    public function delete(ProfileId $profileId): void
    {
        $model = TableRegistry::getTableLocator()->get('Profiles');
        $entity = $model->get($profileId->value);
        $model->deleteOrFail($entity);
    }

    /**
     * @param array<string,mixed> $record record
     * @return \App\Domain\Models\Profile\Profile
     */
    private function buildEntity(array $record): Profile
    {
        $birthDay = $record['birth_day'];
        $cellPhoneNumber = $record['cell_phone_number'];
        $remarks = $record['remarks'];

        return Profile::reconstruct(
            new ProfileId($record['id']),
            new UserId($record['user_id']),
            new FirstName($record['first_name']),
            new LastName($record['last_name']),
            new FirstNameKana($record['first_name_kana']),
            new LastNameKana($record['last_name_kana']),
            new Sex($record['sex']),
            empty($birthDay) ? null : new BirthDay($birthDay->format('Y-m-d')),
            empty($cellPhoneNumber) ? null : new CellPhoneNumber($cellPhoneNumber),
            empty($remarks) ? null : new Remarks($remarks),
        );
    }
}
