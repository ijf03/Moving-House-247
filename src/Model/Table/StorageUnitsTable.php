<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query\SelectQuery;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * StorageUnits Model
 *
 * @method \App\Model\Entity\StorageUnit newEmptyEntity()
 * @method \App\Model\Entity\StorageUnit newEntity(array $data, array $options = [])
 * @method array<\App\Model\Entity\StorageUnit> newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\StorageUnit get(mixed $primaryKey, array|string $finder = 'all', \Psr\SimpleCache\CacheInterface|string|null $cache = null, \Closure|string|null $cacheKey = null, mixed ...$args)
 * @method \App\Model\Entity\StorageUnit findOrCreate($search, ?callable $callback = null, array $options = [])
 * @method \App\Model\Entity\StorageUnit patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method array<\App\Model\Entity\StorageUnit> patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\StorageUnit|false save(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method \App\Model\Entity\StorageUnit saveOrFail(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method iterable<\App\Model\Entity\StorageUnit>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\StorageUnit>|false saveMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\StorageUnit>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\StorageUnit> saveManyOrFail(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\StorageUnit>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\StorageUnit>|false deleteMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\StorageUnit>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\StorageUnit> deleteManyOrFail(iterable $entities, array $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class StorageUnitsTable extends Table
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

        $this->setTable('storage_units');
        $this->setDisplayField('unit_code');
        $this->setPrimaryKey('storage_unit_id');

        $this->addBehavior('Timestamp');
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
            ->scalar('unit_code')
            ->maxLength('unit_code', 50)
            ->requirePresence('unit_code', 'create')
            ->notEmptyString('unit_code')
            ->add('unit_code', 'unique', ['rule' => 'validateUnique', 'provider' => 'table']);

        $validator
            ->scalar('facility_name')
            ->maxLength('facility_name', 100)
            ->requirePresence('facility_name', 'create')
            ->notEmptyString('facility_name');

        $validator
            ->decimal('unit_size_m3')
            ->allowEmptyString('unit_size_m3');

        $validator
            ->scalar('status')
            ->maxLength('status', 30)
            ->notEmptyString('status');

        $validator
            ->scalar('security_level')
            ->maxLength('security_level', 50)
            ->allowEmptyString('security_level');

        $validator
            ->boolean('is_climate_controlled')
            ->notEmptyString('is_climate_controlled');

        $validator
            ->boolean('is_active')
            ->notEmptyString('is_active');

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
        $rules->add($rules->isUnique(['unit_code']), ['errorField' => 'unit_code']);

        return $rules;
    }
}
