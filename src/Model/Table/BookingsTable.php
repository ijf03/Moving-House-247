<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Table;
use Cake\Validation\Validator;

class BookingsTable extends Table
{
    public function initialize(array $config): void
    {
        parent::initialize($config);

        $this->setTable('bookings');
        $this->setDisplayField('booking_id');
        $this->setPrimaryKey('booking_id');

        $this->belongsTo('Customers', [
            'foreignKey' => 'customer_id',
            'joinType' => 'INNER',
        ]);

        $this->belongsTo('JobTypes', [
            'foreignKey' => 'job_type_id',
            'joinType' => 'INNER',
        ]);
    }

    public function validationDefault(Validator $validator): Validator
    {
        $validator
            ->integer('customer_id')
            ->requirePresence('customer_id', 'create')
            ->notEmptyString('customer_id', 'Customer is required');

        $validator
            ->integer('job_type_id')
            ->requirePresence('job_type_id', 'create')
            ->notEmptyString('job_type_id', 'Job type is required');

        $validator
            ->scalar('pickup_address')
            ->maxLength('pickup_address', 95)
            ->requirePresence('pickup_address', 'create')
            ->notEmptyString('pickup_address', 'Pickup address is required');

        $validator
            ->scalar('dropoff_address')
            ->maxLength('dropoff_address', 95)
            ->requirePresence('dropoff_address', 'create')
            ->notEmptyString('dropoff_address', 'Dropoff address is required');

        $validator
            ->date('job_date')
            ->requirePresence('job_date', 'create')
            ->notEmptyDate('job_date', 'Job date is required');

        $validator
            ->time('job_time')
            ->requirePresence('job_time', 'create')
            ->notEmptyTime('job_time', 'Job time is required');

        $validator
            ->scalar('status')
            ->maxLength('status', 20)
            ->requirePresence('status', 'create')
            ->notEmptyString('status', 'Status is required');

        $validator
            ->scalar('message')
            ->allowEmptyString('message');

        return $validator;
    }
}
