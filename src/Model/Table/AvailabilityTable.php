<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query\SelectQuery;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Availability Model
 *
 * @method \App\Model\Entity\Availability newEmptyEntity()
 * @method \App\Model\Entity\Availability newEntity(array $data, array $options = [])
 * @method array<\App\Model\Entity\Availability> newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Availability get(mixed $primaryKey, array|string $finder = 'all', \Psr\SimpleCache\CacheInterface|string|null $cache = null, \Closure|string|null $cacheKey = null, mixed ...$args)
 * @method \App\Model\Entity\Availability findOrCreate($search, ?callable $callback = null, array $options = [])
 * @method \App\Model\Entity\Availability patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method array<\App\Model\Entity\Availability> patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\Availability|false save(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method \App\Model\Entity\Availability saveOrFail(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method iterable<\App\Model\Entity\Availability>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Availability>|false saveMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\Availability>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Availability> saveManyOrFail(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\Availability>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Availability>|false deleteMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\Availability>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Availability> deleteManyOrFail(iterable $entities, array $options = [])
 */
class AvailabilityTable extends Table
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

        $this->setTable('availability');
        $this->setDisplayField('availability_id');
        $this->setPrimaryKey('availability_id');
        $this->belongsTo('Staffs', [
            'foreignKey' => 'staff_id',
            'className' => 'Staff',
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
            ->integer('staff_id')
            ->notEmptyString('staff_id');

        $validator
            ->dateTime('start_datetime')
            ->requirePresence('start_datetime', 'create')
            ->notEmptyDateTime('start_datetime');

        $validator
            ->dateTime('end_datetime')
            ->requirePresence('end_datetime', 'create')
            ->notEmptyDateTime('end_datetime');

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
        $rules->add($rules->existsIn(['staff_id'], 'Staffs'), ['errorField' => 'staff_id']);

        return $rules;
    }
}
