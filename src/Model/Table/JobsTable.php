<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query\SelectQuery;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Jobs Model
 *
 * @property \App\Model\Table\JobTypesTable&\Cake\ORM\Association\BelongsTo $JobTypes
 * @property \App\Model\Table\CustomersTable&\Cake\ORM\Association\BelongsTo $Customers
 *
 * @method \App\Model\Entity\Job newEmptyEntity()
 * @method \App\Model\Entity\Job newEntity(array $data, array $options = [])
 * @method array<\App\Model\Entity\Job> newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Job get(mixed $primaryKey, array|string $finder = 'all', \Psr\SimpleCache\CacheInterface|string|null $cache = null, \Closure|string|null $cacheKey = null, mixed ...$args)
 * @method \App\Model\Entity\Job findOrCreate($search, ?callable $callback = null, array $options = [])
 * @method \App\Model\Entity\Job patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method array<\App\Model\Entity\Job> patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\Job|false save(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method \App\Model\Entity\Job saveOrFail(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method iterable<\App\Model\Entity\Job>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Job>|false saveMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\Job>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Job> saveManyOrFail(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\Job>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Job>|false deleteMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\Job>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Job> deleteManyOrFail(iterable $entities, array $options = [])
 */
class JobsTable extends Table
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

        $this->setTable('jobs');
        $this->setDisplayField('pickup_address');
        $this->setPrimaryKey('job_id');

        $this->belongsTo('JobTypes', [
            'foreignKey' => 'job_type_id',
            'joinType' => 'INNER',
        ]);
        $this->belongsTo('Customers', [
            'foreignKey' => 'customer_id',
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
            ->integer('job_type_id')
            ->notEmptyString('job_type_id');

        $validator
            ->scalar('description')
            ->requirePresence('description', 'create')
            ->notEmptyString('description');

        $validator
            ->scalar('pickup_address')
            ->maxLength('pickup_address', 95)
            ->requirePresence('pickup_address', 'create')
            ->notEmptyString('pickup_address');

        $validator
            ->scalar('dropoff_address')
            ->maxLength('dropoff_address', 95)
            ->requirePresence('dropoff_address', 'create')
            ->notEmptyString('dropoff_address');

        $validator
            ->scalar('job_date')
            ->maxLength('job_date', 11)
            ->requirePresence('job_date', 'create')
            ->notEmptyString('job_date');

        $validator
            ->scalar('job_time')
            ->maxLength('job_time', 5)
            ->requirePresence('job_time', 'create')
            ->notEmptyString('job_time');

        $validator
            ->integer('customer_id')
            ->notEmptyString('customer_id');

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
        $rules->add($rules->existsIn(['job_type_id'], 'JobTypes'), ['errorField' => 'job_type_id']);
        $rules->add($rules->existsIn(['customer_id'], 'Customers'), ['errorField' => 'customer_id']);

        return $rules;
    }
}
