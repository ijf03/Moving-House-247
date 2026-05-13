<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

class JobsTable extends Table
{
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

        $this->hasMany('JobTrucks', [
            'foreignKey' => 'job_id',
        ]);

        $this->hasMany('StaffJob', [
            'foreignKey' => 'job_id',
        ]);
    }

    public function validationDefault(Validator $validator): Validator
    {
        $validator
            ->integer('job_type_id')
            ->requirePresence('job_type_id', 'create')
            ->notEmptyString('job_type_id', 'Job type is required')
            ->inList('job_type_id', [1, 2, 3], 'Please select a valid job type');

        $validator
            ->scalar('description')
            ->requirePresence('description', 'create')
            ->notEmptyString('description', 'Description is required');

        $validator
            ->scalar('pickup_address')
            ->maxLength('pickup_address', 95)
            ->requirePresence('pickup_address', 'create')
            ->notEmptyString('pickup_address', 'Pickup address is required');

        $validator
            ->scalar('dropoff_address')
            ->maxLength('dropoff_address', 95)
            ->allowEmptyString('dropoff_address');

        $validator->add('dropoff_address', 'requiredForTransfer', [
            'rule' => function ($value, $context) {
                $jobTypeId = (int)($context['data']['job_type_id'] ?? 0);

                if ($jobTypeId === 3) {
                    return trim((string)$value) !== '';
                }

                return true;
            },
            'message' => 'Dropoff address is required for transfer jobs',
        ]);

        $validator
            ->date('job_date')
            ->requirePresence('job_date', 'create')
            ->notEmptyDate('job_date', 'Job date is required');

        $validator
            ->time('job_time')
            ->requirePresence('job_time', 'create')
            ->notEmptyTime('job_time', 'Job time is required');

        $validator
            ->integer('customer_id')
            ->requirePresence('customer_id', 'create')
            ->notEmptyString('customer_id', 'Customer is required');

        return $validator;
    }

    public function buildRules(RulesChecker $rules): RulesChecker
    {
        $rules->add($rules->existsIn(['job_type_id'], 'JobTypes'), [
            'errorField' => 'job_type_id',
        ]);

        $rules->add($rules->existsIn(['customer_id'], 'Customers'), [
            'errorField' => 'customer_id',
        ]);

        return $rules;
    }
}
