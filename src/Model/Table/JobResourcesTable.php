<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query\SelectQuery;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * JobResources Model
 *
 * @property \App\Model\Table\JobsTable&\Cake\ORM\Association\BelongsTo $Jobs
 *
 * @method \App\Model\Entity\JobResource newEmptyEntity()
 * @method \App\Model\Entity\JobResource newEntity(array $data, array $options = [])
 * @method array<\App\Model\Entity\JobResource> newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\JobResource get(mixed $primaryKey, array|string $finder = 'all', \Psr\SimpleCache\CacheInterface|string|null $cache = null, \Closure|string|null $cacheKey = null, mixed ...$args)
 * @method \App\Model\Entity\JobResource findOrCreate($search, ?callable $callback = null, array $options = [])
 * @method \App\Model\Entity\JobResource patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method array<\App\Model\Entity\JobResource> patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\JobResource|false save(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method \App\Model\Entity\JobResource saveOrFail(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method iterable<\App\Model\Entity\JobResource>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\JobResource>|false saveMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\JobResource>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\JobResource> saveManyOrFail(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\JobResource>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\JobResource>|false deleteMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\JobResource>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\JobResource> deleteManyOrFail(iterable $entities, array $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class JobResourcesTable extends Table
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

        $this->setTable('job_resources');
        $this->setDisplayField('resource_type');
        $this->setPrimaryKey('job_resource_id');

        $this->belongsTo('Jobs', [
            'foreignKey' => 'job_id',
        ]);

        $this->belongsTo('Trucks', [
            'foreignKey' => 'truck_id',
            'joinType' => 'LEFT',
        ]);

        $this->belongsTo('Equipment', [
            'foreignKey' => 'equipment_id',
            'joinType' => 'LEFT',
        ]);

        $this->belongsTo('StorageUnits', [
            'foreignKey' => 'storage_unit_id',
            'joinType' => 'LEFT',
        ]);

        $this->belongsTo('InventoryItems', [
            'foreignKey' => 'inventory_id',
            'bindingKey' => 'inventory_item_id',
            'joinType' => 'LEFT',
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
            ->integer('job_id')
            ->requirePresence('job_id', 'create')
            ->notEmptyString('job_id');

        $validator
            ->integer('truck_id')
            ->allowEmptyString('truck_id');

        $validator
            ->integer('equipment_id')
            ->allowEmptyString('equipment_id');

        $validator
            ->integer('storage_unit_id')
            ->allowEmptyString('storage_unit_id');

        $validator
            ->integer('inventory_id')
            ->allowEmptyString('inventory_id');

        $validator
            ->decimal('quantity')
            ->notEmptyString('quantity');

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
        $rules->add($rules->existsIn(['job_id'], 'Jobs'), ['errorField' => 'job_id']);

        return $rules;
    }
}
