<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

class ContactFormRepliesTable extends Table
{
    public function initialize(array $config): void
    {
        parent::initialize($config);

        $this->setTable('contact_form_replies');
        $this->setDisplayField('contact_form_reply_id');
        $this->setPrimaryKey('contact_form_reply_id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('ContactForms', [
            'foreignKey' => 'contact_form_id',
            'joinType' => 'INNER',
        ]);
    }

    public function validationDefault(Validator $validator): Validator
    {
        $validator
            ->nonNegativeInteger('contact_form_id')
            ->requirePresence('contact_form_id', 'create')
            ->notEmptyString('contact_form_id');

        $validator
            ->scalar('sender_type')
            ->requirePresence('sender_type', 'create')
            ->notEmptyString('sender_type')
            ->inList('sender_type', ['customer', 'admin']);

        $validator
            ->scalar('message')
            ->requirePresence('message', 'create')
            ->notEmptyString('message');

        return $validator;
    }

    public function buildRules(RulesChecker $rules): RulesChecker
    {
        $rules->add(
            $rules->existsIn(['contact_form_id'], 'ContactForms'),
            ['errorField' => 'contact_form_id']
        );

        return $rules;
    }
}
