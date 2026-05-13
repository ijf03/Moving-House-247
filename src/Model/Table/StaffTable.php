<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query\SelectQuery;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Staff Model
 *
 * @method \App\Model\Entity\Staff newEmptyEntity()
 * @method \App\Model\Entity\Staff newEntity(array $data, array $options = [])
 * @method array<\App\Model\Entity\Staff> newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Staff get(mixed $primaryKey, array|string $finder = 'all', \Psr\SimpleCache\CacheInterface|string|null $cache = null, \Closure|string|null $cacheKey = null, mixed ...$args)
 * @method \App\Model\Entity\Staff findOrCreate($search, ?callable $callback = null, array $options = [])
 * @method \App\Model\Entity\Staff patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method array<\App\Model\Entity\Staff> patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\Staff|false save(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method \App\Model\Entity\Staff saveOrFail(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method iterable<\App\Model\Entity\Staff>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Staff>|false saveMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\Staff>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Staff> saveManyOrFail(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\Staff>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Staff>|false deleteMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\Staff>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Staff> deleteManyOrFail(iterable $entities, array $options = [])
 */
class StaffTable extends Table
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

        $this->setTable('staff');
        $this->setDisplayField('first_name');
        $this->setPrimaryKey('staff_id');
        $this->hasMany('Availability',[
            'foreignKey' => 'staff_id',
            'dependent' => true,
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
            ->scalar('first_name')
            ->maxLength('first_name', 50)
            ->requirePresence('first_name', 'create')
            ->notEmptyString('first_name');

        $validator
            ->scalar('last_name')
            ->maxLength('last_name', 50)
            ->requirePresence('last_name', 'create')
            ->notEmptyString('last_name');

        $validator
            ->email('email')
            ->requirePresence('email', 'create')
            ->notEmptyString('email');

        $validator
            ->scalar('phone')
            ->maxLength('phone', 15)
            ->requirePresence('phone', 'create')
            ->notEmptyString('phone');

        $validator
            ->boolean('isDriver')
            ->requirePresence('isDriver', 'create')
            ->notEmptyString('isDriver');

        return $validator;
    }
}
