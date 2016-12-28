<?php

namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

class TransactionsTable extends Table {

    public function initialize(array $config) {
        parent::initialize($config);

        $this->table('transactions');
        $this->displayField('id');
        $this->primaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('Users', [
            'foreignKey' => 'user_id',
            'joinType' => 'INNER'
        ]);
    }

    public function validationDefault(Validator $validator) {


        $validator
                ->requirePresence('amount', 'create')
                ->notEmpty('amount');

        $validator
                ->integer('transaction_id')
                ->requirePresence('transaction_id', 'create')
                ->notEmpty('transaction_id');

        $validator
                ->requirePresence('card_number', 'create')
                ->notEmpty('card_number');


        return $validator;
    }

    public function buildRules(RulesChecker $rules) {
        $rules->add($rules->existsIn(['user_id'], 'Users'));

        return $rules;
    }

}
