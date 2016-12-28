<?php

namespace App\Controller;

use Cake\Controller\Controller;
use Cake\Event\Event;

class AppController extends Controller {

    public function initialize() {
        parent::initialize();

        header('Access-Control-Allow-Origin: *');

        $this->loadComponent('RequestHandler');
        $this->loadComponent('Flash');
        $this->loadComponent('Auth');
        
        //require_once(ROOT . DS . 'vendor' . DS . 'aes' . DS . 'AES.php');
        //$aes = new \AES("Jay Jagannath", ENCRYPTION_KEY, ENCRYPTION_BLOCK_SIZE, ENCRYPTION_MODE);
        //echo $enc = $aes->encrypt();      

//        $this->loadComponent('Auth', [
//            'authenticate' => [
//                'Form' => [
//                    'fields' => [
//                        'username' => 'email',
//                        'password' => 'password'
//                    ],
//                    'userModel' => 'Admins'
//                ]
//            ]
//        ]);

        $this->loadModel('Users');

        $query = $this->Users->find()->where(['Users.id' => $this->Auth->user('id')]);
        if ($query->count() > 0) {
            $agentData = $query->first();
        }
        $this->set(compact('agentData'));
    }

    public function beforeFilter(Event $event) {
//        $this->Auth->allow(); //Allow All
    }

    public function beforeRender(Event $event) {
        
    }

}
