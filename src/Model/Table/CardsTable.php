<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

class CardsTable extends Table {

    public function initialize(array $config) {
        parent::initialize($config);

        $this->table('cards');
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
                ->allowEmpty('card_token');

        $validator
                ->email('email')
                ->allowEmpty('email');


        return $validator;
    }

    public function buildRules(RulesChecker $rules) {
        $rules->add($rules->existsIn(['user_id'], 'Users'));
        return $rules;
    }

}

