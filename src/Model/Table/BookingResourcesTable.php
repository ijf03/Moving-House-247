<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query\SelectQuery;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * BookingResources Model
 *
 * @property \App\Model\Table\BookingsTable&\Cake\ORM\Association\BelongsTo $Bookings
 *
 * @method \App\Model\Entity\BookingResource newEmptyEntity()
 * @method \App\Model\Entity\BookingResource newEntity(array $data, array $options = [])
 * @method array<\App\Model\Entity\BookingResource> newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\BookingResource get(mixed $primaryKey, array|string $finder = 'all', \Psr\SimpleCache\CacheInterface|string|null $cache = null, \Closure|string|null $cacheKey = null, mixed ...$args)
 * @method \App\Model\Entity\BookingResource findOrCreate($search, ?callable $callback = null, array $options = [])
 * @method \App\Model\Entity\BookingResource patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method array<\App\Model\Entity\BookingResource> patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\BookingResource|false save(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method \App\Model\Entity\BookingResource saveOrFail(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method iterable<\App\Model\Entity\BookingResource>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\BookingResource>|false saveMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\BookingResource>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\BookingResource> saveManyOrFail(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\BookingResource>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\BookingResource>|false deleteMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\BookingResource>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\BookingResource> deleteManyOrFail(iterable $entities, array $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class BookingResourcesTable extends Table
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

        $this->setTable('booking_resources');
        $this->setDisplayField('resource_type');
        $this->setPrimaryKey('booking_resource_id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('Bookings', [
            'foreignKey' => 'booking_id',
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
            ->integer('booking_id')
            ->allowEmptyString('booking_id');

        $validator
            ->scalar('resource_type')
            ->maxLength('resource_type', 30)
            ->requirePresence('resource_type', 'create')
            ->notEmptyString('resource_type');

        $validator
            ->integer('resource_id')
            ->requirePresence('resource_id', 'create')
            ->notEmptyString('resource_id');

        $validator
            ->decimal('quantity')
            ->notEmptyString('quantity');

        $validator
            ->scalar('notes')
            ->allowEmptyString('notes');

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
        $rules->add($rules->existsIn(['booking_id'], 'Bookings'), ['errorField' => 'booking_id']);

        return $rules;
    }
}
