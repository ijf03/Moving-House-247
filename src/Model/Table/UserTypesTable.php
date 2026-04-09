<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query\SelectQuery;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * UserTypes Model
 *
 * @method \App\Model\Entity\UserType newEmptyEntity()
 * @method \App\Model\Entity\UserType newEntity(array $data, array $options = [])
 * @method array<\App\Model\Entity\UserType> newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\UserType get(mixed $primaryKey, array|string $finder = 'all', \Psr\SimpleCache\CacheInterface|string|null $cache = null, \Closure|string|null $cacheKey = null, mixed ...$args)
 * @method \App\Model\Entity\UserType findOrCreate($search, ?callable $callback = null, array $options = [])
 * @method \App\Model\Entity\UserType patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method array<\App\Model\Entity\UserType> patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\UserType|false save(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method \App\Model\Entity\UserType saveOrFail(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method iterable<\App\Model\Entity\UserType>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\UserType>|false saveMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\UserType>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\UserType> saveManyOrFail(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\UserType>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\UserType>|false deleteMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\UserType>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\UserType> deleteManyOrFail(iterable $entities, array $options = [])
 */
class UserTypesTable extends Table
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

        $this->setTable('user_types');
        $this->setDisplayField('name');
        $this->setPrimaryKey('user_type_id');
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
            ->maxLength('name', 20)
            ->requirePresence('name', 'create')
            ->notEmptyString('name');

        $validator
            ->scalar('description')
            ->requirePresence('description', 'create')
            ->notEmptyString('description');

        return $validator;
    }
}
