<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * ProfileFiles Model
 *
 * @property \App\Model\Table\ProfilesTable&\Cake\ORM\Association\BelongsTo $Profiles
 * @property \App\Model\Table\FilesTable&\Cake\ORM\Association\BelongsTo $Files
 * @method \App\Model\Entity\ProfileFile newEmptyEntity()
 * @method \App\Model\Entity\ProfileFile newEntity(array $data, array $options = [])
 * @method array<\App\Model\Entity\ProfileFile> newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\ProfileFile get(mixed $primaryKey, array|string $finder = 'all', \Psr\SimpleCache\CacheInterface|string|null $cache = null, \Closure|string|null $cacheKey = null, mixed ...$args)
 * @method \App\Model\Entity\ProfileFile findOrCreate($search, ?callable $callback = null, array $options = [])
 * @method \App\Model\Entity\ProfileFile patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method array<\App\Model\Entity\ProfileFile> patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\ProfileFile|false save(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method \App\Model\Entity\ProfileFile saveOrFail(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method iterable<\App\Model\Entity\ProfileFile>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\ProfileFile>|false saveMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\ProfileFile>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\ProfileFile> saveManyOrFail(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\ProfileFile>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\ProfileFile>|false deleteMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\ProfileFile>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\ProfileFile> deleteManyOrFail(iterable $entities, array $options = [])
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class ProfileFilesTable extends Table
{
    /**
     * Initialize method
     *
     * @param array<string, mixed> $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config): void
    {
        parent::initialize($config);

        $this->setTable('profile_files');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('Profiles', [
            'foreignKey' => 'profile_id',
            'joinType' => 'INNER',
        ]);
        $this->belongsTo('Files', [
            'foreignKey' => 'file_id',
            'joinType' => 'INNER',
        ]);
    }

    /**
     * Default validation rules.
     *
     * @param \Cake\Validation\Validator $validator Validator instance.
     * @return \Cake\Validation\Validator
     */
    public function validationDefault(Validator $validator): Validator
    {
        $validator
            ->integer('id')
            ->allowEmptyString('id', null, 'create');

        $validator
            ->uuid('profile_id')
            ->notEmptyString('profile_id');

        $validator
            ->uuid('file_id')
            ->notEmptyString('file_id');

        return $validator;
    }

    /**
     * Returns a rules checker object that will be used for validating
     * application integrity.
     *
     * @param \Cake\ORM\RulesChecker $rules The rules object to be modified.
     * @return \Cake\ORM\RulesChecker
     */
    public function buildRules(RulesChecker $rules): RulesChecker
    {
        $rules->add($rules->existsIn(['profile_id'], 'Profiles'), ['errorField' => 'profile_id']);
        $rules->add($rules->existsIn(['file_id'], 'Files'), ['errorField' => 'file_id']);

        return $rules;
    }
}
