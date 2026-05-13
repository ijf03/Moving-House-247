<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query\SelectQuery;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * InventoryItems Model
 *
 * @method \App\Model\Entity\InventoryItem newEmptyEntity()
 * @method \App\Model\Entity\InventoryItem newEntity(array $data, array $options = [])
 * @method array<\App\Model\Entity\InventoryItem> newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\InventoryItem get(mixed $primaryKey, array|string $finder = 'all', \Psr\SimpleCache\CacheInterface|string|null $cache = null, \Closure|string|null $cacheKey = null, mixed ...$args)
 * @method \App\Model\Entity\InventoryItem findOrCreate($search, ?callable $callback = null, array $options = [])
 * @method \App\Model\Entity\InventoryItem patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method array<\App\Model\Entity\InventoryItem> patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\InventoryItem|false save(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method \App\Model\Entity\InventoryItem saveOrFail(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method iterable<\App\Model\Entity\InventoryItem>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\InventoryItem>|false saveMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\InventoryItem>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\InventoryItem> saveManyOrFail(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\InventoryItem>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\InventoryItem>|false deleteMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\InventoryItem>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\InventoryItem> deleteManyOrFail(iterable $entities, array $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class InventoryItemsTable extends Table
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

        $this->setTable('inventory_items');
        $this->setDisplayField('name');
        $this->setPrimaryKey('inventory_item_id');

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
            ->scalar('name')
            ->maxLength('name', 100)
            ->requirePresence('name', 'create')
            ->notEmptyString('name');

        $validator
            ->scalar('category')
            ->maxLength('category', 50)
            ->requirePresence('category', 'create')
            ->notEmptyString('category');

        $validator
            ->integer('quantity_on_hand')
            ->greaterThanOrEqual('quantity_on_hand', 0, 'Quantity on hand cannot be negative.')
            ->notEmptyString('quantity_on_hand');

        $validator
            ->integer('reorder_threshold')
            ->greaterThanOrEqual('reorder_threshold', 0, 'Reorder threshold cannot be negative.')
            ->notEmptyString('reorder_threshold');

        $validator
            ->scalar('unit')
            ->maxLength('unit', 20)
            ->notEmptyString('unit');

        $validator
            ->scalar('storage_location')
            ->maxLength('storage_location', 100)
            ->allowEmptyString('storage_location');

        $validator
            ->boolean('is_active')
            ->notEmptyString('is_active');

        return $validator;
    }
}
