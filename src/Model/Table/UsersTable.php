<?php

namespace App\Model\Table;

use App\Model\Entity\User;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;
use Cake\ORM\TableRegistry;

/**
 * Users Model
 *
 */
class UsersTable extends Table {

    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config) {
        parent::initialize($config);
    }

    public function beforeDelete($event, $entity, $options) {
        
    }

    public function buildRules(RulesChecker $rules) {
        $rules->add($rules->isUnique(['email']));
        return $rules;
    }

    public function check($password, $hashedPassword) {
        return password_verify($password, $hashedPassword);
    }

}
