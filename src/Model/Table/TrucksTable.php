<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query\SelectQuery;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Trucks Model
 *
 * @method \App\Model\Entity\Truck newEmptyEntity()
 * @method \App\Model\Entity\Truck newEntity(array $data, array $options = [])
 * @method array<\App\Model\Entity\Truck> newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Truck get(mixed $primaryKey, array|string $finder = 'all', \Psr\SimpleCache\CacheInterface|string|null $cache = null, \Closure|string|null $cacheKey = null, mixed ...$args)
 * @method \App\Model\Entity\Truck findOrCreate($search, ?callable $callback = null, array $options = [])
 * @method \App\Model\Entity\Truck patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method array<\App\Model\Entity\Truck> patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\Truck|false save(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method \App\Model\Entity\Truck saveOrFail(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method iterable<\App\Model\Entity\Truck>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Truck>|false saveMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\Truck>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Truck> saveManyOrFail(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\Truck>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Truck>|false deleteMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\Truck>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Truck> deleteManyOrFail(iterable $entities, array $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class TrucksTable extends Table
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

        $this->setTable('trucks');
        $this->setDisplayField('name');
        $this->setPrimaryKey('truck_id');

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
            ->scalar('rego')
            ->maxLength('rego', 6, 'Registration must be 6 characters long.')
            ->requirePresence('rego', 'create')
            ->notEmptyString('rego', 'Please enter a registration number.')
            ->add('rego', 'validFormat', [
                'rule' => function ($value, $context) {
                    $value = strtoupper(trim((string)$value));

                    $normalRegistration = '/^[0-9][A-Z]{2}[0-9][A-Z]{2}$/';
                    $nationalHeavyVehicleRegistration = '/^[A-Z]{2}[0-9]{2}[A-Z]{2}$/';

                    return preg_match($normalRegistration, $value) === 1
                        || preg_match($nationalHeavyVehicleRegistration, $value) === 1;
                },
                'message' => 'Registration must match either normal format 1AB2CD or national heavy vehicle format FB23CA.',
            ]);

        $validator
            ->decimal('capacity_m3')
            ->greaterThan('capacity_m3', 0, 'Capacity must be greater than 0.')
            ->allowEmptyString('capacity_m3');

        $validator
            ->decimal('max_payload_kg')
            ->greaterThan('max_payload_kg', 0, 'Max payload must be greater than 0.')
            ->allowEmptyString('max_payload_kg');

        $validator
            ->scalar('status')
            ->maxLength('status', 30)
            ->notEmptyString('status');

        $validator
            ->scalar('current_location')
            ->requirePresence('current_location', 'create')
            ->notEmptyString('current_location', 'Please select a depot location.')
            ->inList('current_location', [
                'Clayton Depot',
                'Springvale Depot',
                'Dandenong Depot',
                'Moorabbin Depot',
                'Melbourne Depot',
                'Other',
            ], 'Please select a valid depot location.');

        $validator
            ->date('next_service_date')
            ->allowEmptyDate('next_service_date');

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
        $rules->add($rules->isUnique(['rego']), ['errorField' => 'rego']);

        return $rules;
    }
}
