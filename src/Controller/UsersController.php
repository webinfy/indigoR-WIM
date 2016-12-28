<?php

namespace App\Controller;

use App\Controller\AppController;
use Cake\Event\Event;
use Cake\Mailer\Email;
use Cake\Network\Request;
use Cake\ORM\TableRegistry;
use Cake\Core\App;
use Cake\Datasource\ConnectionManager;

class UsersController extends AppController {

    public function initialize() {
        parent::initialize();
        $this->viewBuilder()->layout('default');

        $this->loadComponent('RequestHandler');
        $this->loadComponent('Paginator');
        $this->loadComponent('Custom');

        $this->loadModel('Users');
        $this->loadModel('Cards');
        $this->loadModel('Airlines');
        $this->loadModel('Transactions');
        $this->loadModel('Admins');
        $this->loadModel('MailTemplates');
        $this->loadModel('AdminSettings');

        header('Access-Control-Allow-Origin: *');
    }

    public function beforeFilter(Event $event) {
        parent::beforeFilter($event);
        $this->Auth->allow(['login', 'home', 'agentAuthentication', 'authenticationFailure', 'naviatorStatus', 'landing', 'tstEmail', 'tstEncryption']);
    }

    public function home() {
        $this->viewBuilder()->layout('');
        if ($this->Auth->user('id')) {
            if ($this->Auth->user('type') == 2) {
                return $this->redirect(HTTP_ROOT . 'recharge');
            } else {
                return $this->redirect(HTTP_ROOT . 'admin');
            }
        } else {
            return $this->redirect(HTTP_ROOT . 'login');
        }
    }

    /*
     * Dev : Pradeepta Khatoi
     * Date : 13 Dec 2016
     * Desc:  This Page Contains 4 Tab
     * 1.Register New Card
     * 2.Lositing Of Registered Cards
     * 3.Make Payment Tab
     * 4.Transaction History Tab
     */

    public function cardRegister() {

        $user_id = $this->Auth->user('id');
        $key = KEY;
        $salt = SALT;

        //Form Post Start//
        if ($this->request->is('post')) {
            $data = $this->request->data;
            $cardNo = str_replace(' ', '', $data['cardNo']);
            if (!$this->_validateCard($cardNo)) {
                $this->Flash->error(__('Invalid Card No.'));
                return $this->redirect(HTTP_ROOT . 'recharge/#rnc');
            }
            $command = "save_user_card";
            $var1 = "{$key}:{$user_id}"; // User_Credentials
            $var2 = 'my_card';
            $var3 = 'CC';
            $var4 = 'CC';
            $var5 = $data['nameOnCard'];
            $var6 = $cardNo;
            $var7 = $data['cardExpMon'];
            $var8 = $data['cardExpYr'];
            $hash_str = $key . '|' . $command . '|' . $var1 . '|' . $salt;
            $hash = strtolower(hash('sha512', $hash_str));
            $r = array('key' => $key, 'hash' => $hash, 'var1' => $var1, 'var2' => $var2, 'var3' => $var3, 'var4' => $var4, 'var5' => $var5, 'var6' => $var6, 'var7' => $var7, 'var8' => $var8, 'command' => $command);

            $qs = http_build_query($r);
            $apiUrl = SAVE_CARD_URL;
            $cd = curl_init();
            curl_setopt($cd, CURLOPT_URL, $apiUrl);
            curl_setopt($cd, CURLOPT_POST, 1);
            curl_setopt($cd, CURLOPT_POSTFIELDS, $qs);
            curl_setopt($cd, CURLOPT_CONNECTTIMEOUT, 30);
            curl_setopt($cd, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($cd, CURLOPT_SSL_VERIFYHOST, 0);
            curl_setopt($cd, CURLOPT_SSL_VERIFYPEER, 0);
            $saveCard = curl_exec($cd);
            if (curl_errno($cd)) {
                $sad = curl_error($cd);
                throw new Exception($sad);
            }
            curl_close($cd);

            $saveCardObj = json_decode($saveCard);

            if ($saveCardObj->status == 1) {

                /* Save to card table  **** Sanjib ***  */
                $cardDetails = $this->Cards->newEntity();
                $cardDetails = $this->Cards->patchEntity($cardDetails, $data);
                if (!empty($data['mandate_form_file']['name'])) {
                    $mandate_form = $this->Custom->uploadFile($data['mandate_form_file']['tmp_name'], $data['mandate_form_file']['name'], MANDATE_FORM);
                    if ($mandate_form) {
                        $cardDetails->mandate_form = $mandate_form;
                    }
                }
                if (!empty($data['scanned_credit_card_file']['name'])) {
                    $scanned_credit_card = $this->Custom->uploadFile($data['scanned_credit_card_file']['tmp_name'], $data['scanned_credit_card_file']['name'], SCANNED_CREDIT_CARD);
                    if ($scanned_credit_card) {
                        $cardDetails->scanned_credit_card = $scanned_credit_card;
                    }
                }
                if (!empty($data['document3_file']['name'])) {
                    $document3 = $this->Custom->uploadFile($data['document3_file']['tmp_name'], $data['document3_file']['name'], DOCUMENT3);
                    if ($document3) {
                        $cardDetails->document3 = $document3;
                    }
                }
                $cardDetails->user_id = $this->Auth->user('id');
                $cardDetails->card_token = $saveCardObj->cardToken;
                $cardDetails->is_approve = 0;
                $cardDetails->card_no = $saveCardObj->card_number;
                $cardDetails->created = date('Y-m-d H:i:s');
                $this->Cards->save($cardDetails);

                //Send Email//
                $mailTemplate = $this->MailTemplates->find()->where(['name' => 'CARD_REGISTERED', 'is_active' => 1])->first();
                $adminSetting = $this->AdminSettings->find()->where()->first();
                $getAgentDetails = $this->Users->find()->where(['Users.id' => $this->Auth->user('id')])->first();
                $message = $this->Custom->formatEmail($mailTemplate['content'], [
                    'NAME' => $getAgentDetails->firstname . " " . $getAgentDetails->lastname,
                    'CARD_NO' => $var6,
                    'LOGIN_ID' => $cardDetails->login_id,
                    'AGENCY_ID' => $cardDetails->agency_id,
                    'BANK_NAME' => $cardDetails->bank_name,
                    'EMAIL' => $cardDetails->email
                ]);
                $to = $adminSetting->newcard_notify_email;
                $bcc = $adminSetting->bcc_email;
                $from = $adminSetting->from_email;
                $files = [];
                if ($cardDetails->mandate_form) {
                    $files[] = MANDATE_FORM . $cardDetails->mandate_form;
                }
                if (!empty($cardDetails->scanned_credit_card)) {
                    $files[] = SCANNED_CREDIT_CARD . $cardDetails->scanned_credit_card;
                }
                if (!empty($cardDetails->document3)) {
                    $files[] = DOCUMENT3 . $cardDetails->document3;
                }
                $this->Custom->sendEmail($to, $from, $mailTemplate->subject, $message, $bcc, $files);
                //Send Email End//
                //$this->Flash->success(__("Your card is registered successfully, you will be able to make payment once your card details are approved by Admin"));
                return $this->redirect(HTTP_ROOT . 'recharge?status=success#rnc');
            } else if ($saveCardObj->status == 0) {
                $this->Flash->error(__($saveCardObj->msg));
                return $this->redirect(HTTP_ROOT . 'recharge/#rnc');
            }
            return $this->redirect(HTTP_ROOT . 'recharge/#rcards');
        }

        //Form Post End//        
        ///////////// Get All Saved Cards///////////////
        $command = "get_user_cards";
        $var1 = "{$key}:{$user_id}"; // User Credentials
        $hash_str = $key . '|' . $command . '|' . $var1 . '|' . $salt;
        $hash = strtolower(hash('sha512', $hash_str));
        $r = array('key' => $key, 'hash' => $hash, 'var1' => $var1, 'command' => $command);
        $qs = http_build_query($r);

        $apiUrl = SAVE_CARD_URL;
        $c = curl_init();
        curl_setopt($c, CURLOPT_URL, $apiUrl);
        curl_setopt($c, CURLOPT_POST, 1);
        curl_setopt($c, CURLOPT_POSTFIELDS, $qs);
        curl_setopt($c, CURLOPT_CONNECTTIMEOUT, 30);
        curl_setopt($c, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($c, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($c, CURLOPT_SSL_VERIFYPEER, 0);
        $cardDetails = curl_exec($c);
        if (curl_errno($c)) {
            $sad = curl_error($c);
            throw new \Exception($sad);
        }
        curl_close($c);
        $cardInformations = json_decode(json_encode(json_decode($cardDetails)), true);
        if ($cardInformations['status'] == 1) {
            $userCards = $cardInformations['user_cards'];
            $cardDetails = [];
            foreach ($userCards as $userCard) {
                $query = $this->Cards->find()->where(['Cards.card_token' => $userCard['card_token']]);
                if ($query->count() > 0) {
                    $cardDetails[] = $query->first();
                } else {
                    $cardDetails[] = NULL;
                }
            }
            $this->set(compact('userCards', 'cardDetails'));
        }

        ///////////// Get All Saved Cards End///////////////
    }

    public function enable($token) {
        if ($token) {
            $status = $this->Cards->query()->update()->set(['is_enabled' => 1])->where(['card_token' => $token])->execute();
            if ($status) {
                $this->Flash->success(__("Card Enabled Successfully!!"));
            } else {
                $this->Flash->error(__("Some error occured. Please try again."));
            }
            return $this->redirect(HTTP_ROOT . "recharge#rcards");
        }
        exit;
    }

    public function disable($token) {
        if ($token) {
            $status = $this->Cards->query()->update()->set(['is_enabled' => 0])->where(['card_token' => $token])->execute();
            if ($status) {
                $this->Flash->success(__("Card Disabled Successfully!!"));
            } else {
                $this->Flash->error(__("Some error occured. Please try again."));
            }
            return $this->redirect(HTTP_ROOT . "recharge#rcards");
        }
        exit;
    }

    public function ajaxValidateCard($cardNo = NULL) {
        $data = $this->request->data;
        $cardNo = str_replace(' ', '', $data['cardNo']);
        if ($this->_validateCard($cardNo)) {
            echo json_encode(['is_valid' => 1]);
        } else {
            echo json_encode(['is_valid' => 0]);
        }
        exit;
    }

    /*
     * Dev : Pradeepta Khatoi
     * Date : 13 Dec 2016
     * Desc:  This Method will check if a card is valid or not
     */

    public function _validateCard($cardNo = NULL) {

        if (empty($cardNo)) {
            return FALSE;
        }

        $key = KEY;
        $salt = SALT;

        $command = "validateCardNumber";
        $var1 = $cardNo; // Card No.

        $hash_str = $key . '|' . $command . '|' . $var1 . '|' . $salt;
        $hash = strtolower(hash('sha512', $hash_str));

        $r = array('key' => $key, 'hash' => $hash, 'var1' => $var1, 'command' => $command);

        $qs = http_build_query($r);

        $c = curl_init();
        curl_setopt($c, CURLOPT_URL, SAVE_CARD_URL);
        curl_setopt($c, CURLOPT_POST, 1);
        curl_setopt($c, CURLOPT_POSTFIELDS, $qs);
        curl_setopt($c, CURLOPT_CONNECTTIMEOUT, 30);
        curl_setopt($c, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($c, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($c, CURLOPT_SSL_VERIFYPEER, 0);
        $o = curl_exec($c);
        if (curl_errno($c)) {
            $sad = curl_error($c);
            throw new Exception($sad);
        }
        curl_close($c);

        if (strlen($o) == 7) {
            return true;
        }
        return false;
    }

    public function downloadMandateForm() {
        $filePath = WWW_ROOT . "MandateForm.pdf";
        $this->response->file($filePath, ['download' => TRUE, 'name' => "MandateForm.pdf"]);
        return $this->response;
    }

    public function downloadMandateFormSpecimenCopy() {
        $filePath = WWW_ROOT . "CreditCardANNEXURE.docx";
        $this->response->file($filePath, ['download' => TRUE, 'name' => "CreditCardANNEXURE.docx"]);
        return $this->response;
    }

    /*
     * Dev : Sanjin Pradhan
     * Date : 13 Dec 2016
     * Desc:  Delete a card from PayU & from its own db
     */

    public function deleteCard($cardtoken = null) {
        $user_id = $this->Auth->user('id');
        $var2 = $cardtoken;
        $key = KEY;
        $salt = SALT;
        $command = "delete_user_card";
        $var1 = "{$key}:{$user_id}"; // User_Credentials
        $hash_str = $key . '|' . $command . '|' . $var1 . '|' . $salt;
        $hash = strtolower(hash('sha512', $hash_str));
        $r = array('key' => $key, 'hash' => $hash, 'var1' => $var1, 'var2' => $var2, 'command' => $command);
        $qs = http_build_query($r);

        $apiUrl = SAVE_CARD_URL;
        $c = curl_init();
        curl_setopt($c, CURLOPT_URL, $apiUrl);
        curl_setopt($c, CURLOPT_POST, 1);
        curl_setopt($c, CURLOPT_POSTFIELDS, $qs);
        curl_setopt($c, CURLOPT_CONNECTTIMEOUT, 30);
        curl_setopt($c, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($c, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($c, CURLOPT_SSL_VERIFYPEER, 0);
        $deleteCardDetails = curl_exec($c);

        if (curl_errno($c)) {
            $sad = curl_error($c);
            throw new \Exception($sad);
        }
        curl_close($c);

        $deleteCardDetails = json_decode($deleteCardDetails);
        if ($deleteCardDetails->status == 1) {
            $this->Cards->deleteAll(['Cards.card_token' => $cardtoken]);
            $this->Flash->success(__($deleteCardDetails->msg));
        } else {
            $this->Flash->error(__('Some error Occured. Please try again.'));
        }
        return $this->redirect(HTTP_ROOT . "recharge/#rcards");
    }

    public function getCardDetails() {
        // Merchant key here as provided by Payu   
        $key = KEY;
        $salt = SALT;
        $command = "get_user_cards";
        $var1 = "{$key}:1"; // User_Credentials
        $hash_str = $key . '|' . $command . '|' . $var1 . '|' . $salt;
        $hash = strtolower(hash('sha512', $hash_str));
        $r = array('key' => $key, 'hash' => $hash, 'var1' => $var1, 'command' => $command);
        $qs = http_build_query($r);

        $apiUrl = SAVE_CARD_URL;
        $c = curl_init();
        curl_setopt($c, CURLOPT_URL, $apiUrl);
        curl_setopt($c, CURLOPT_POST, 1);
        curl_setopt($c, CURLOPT_POSTFIELDS, $qs);
        curl_setopt($c, CURLOPT_CONNECTTIMEOUT, 30);
        curl_setopt($c, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($c, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($c, CURLOPT_SSL_VERIFYPEER, 0);
        $cardDetails = curl_exec($c);

        if (curl_errno($c)) {
            $sad = curl_error($c);
            throw new \Exception($sad);
        }
        curl_close($c);


        $valueSerialized = @unserialize($cardDetails);
        if ($cardDetails === 'b:cardDetails;' || $valueSerialized !== false) {
            pj($valueSerialized);
        }

        $this->set('cardDetails', $cardDetails);
    }

    /*
     * Dev : Sanjin Pradhan
     * Date : 13 Dec 2016
     * Desc:  Edit Card
     */

    public function editCard($cardToken = null) {

        $var2 = $cardToken;
        $key = KEY;
        $salt = SALT;

        $command = "get_user_cards";
        $var1 = "{$key}:1"; // User_Credentials          
        $hash_str = $key . '|' . $command . '|' . $var1 . '|' . $salt;
        $hash = strtolower(hash('sha512', $hash_str));
        $r = array('key' => $key, 'hash' => $hash, 'var1' => $var1, 'var2' => $var2, 'command' => $command);

        $qs = http_build_query($r);
        $apiUrl = SAVE_CARD_URL;
        $c = curl_init();
        curl_setopt($c, CURLOPT_URL, $apiUrl);
        curl_setopt($c, CURLOPT_POST, 1);
        curl_setopt($c, CURLOPT_POSTFIELDS, $qs);
        curl_setopt($c, CURLOPT_CONNECTTIMEOUT, 30);
        curl_setopt($c, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($c, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($c, CURLOPT_SSL_VERIFYPEER, 0);
        $getCard = curl_exec($c);
        if (curl_errno($c)) {
            $sad = curl_error($c);
            throw new \Exception($sad);
        }
        curl_close($c);

        $valueSerialized = @unserialize($getCard);
        if ($getCard === 'b:getCard;' || $valueSerialized !== false) {
            pj($valueSerialized);
        }

        $this->set(compact('getCard', 'cardToken'));

        if ($this->request->is('post')) {
            $data = $this->request->data;
            $key = KEY;
            $salt = SALT;
            $command = "edit_user_card";
            $var1 = "{$key}:1"; // User_Credentials
            $var2 = $data['cardToken'];
            $var3 = 'my_card';
            $var4 = 'CC';
            $var5 = 'CC';
            $var6 = $data['nameOnCard'];
            $var7 = $data['cardNo'];
            $var8 = $data['cardExpMon'];
            $var9 = $data['cardExpYr'];
            $hash_str = $key . '|' . $command . '|' . $var1 . '|' . $salt;
            $hash = strtolower(hash('sha512', $hash_str));
            $r = array('key' => $key, 'hash' => $hash, 'var1' => $var1, 'var2' => $var2, 'var3' => $var3, 'var4' => $var4, 'var5' => $var5, 'var6' => $var6, 'var7' => $var7, 'var8' => $var8, 'var9' => $var9, 'command' => $command);

            $qs = http_build_query($r);
            $apiUrl = SAVE_CARD_URL;
            $c = curl_init();
            curl_setopt($c, CURLOPT_URL, $apiUrl);
            curl_setopt($c, CURLOPT_POST, 1);
            curl_setopt($c, CURLOPT_POSTFIELDS, $qs);
            curl_setopt($c, CURLOPT_CONNECTTIMEOUT, 30);
            curl_setopt($c, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($c, CURLOPT_SSL_VERIFYHOST, 0);
            curl_setopt($c, CURLOPT_SSL_VERIFYPEER, 0);
            $editCard = curl_exec($c);
            if (curl_errno($c)) {
                $sad = curl_error($c);
                throw new \Exception($sad);
            }
            curl_close($c);

            $valueSerialized = @unserialize($editCard);
            if ($editCard === 'b:editCard;' || $valueSerialized !== false) {
                pj($valueSerialized);
            }

            if (!empty($editCard)) {
                //$_SESSION['token'] = $saveCard;
                $this->Flash->success(__('Card edited succesfully'));
                return $this->redirect(['action' => 'getCardDetails']);
            } else {
                $this->Flash->error(__('Card edited failed'));
                return $this->redirect($this->referer());
            }
        }
    }

    /*
     * Dev : Sanjin Pradhan
     * Date : 13 Dec 2016
     * Desc:  This page contain the form which will redirect to Payumoney fro payment
     */

    public function payment() {
        $this->viewBuilder()->layout('default');

        if (strtolower($this->request->method()) != 'post') {
            $this->redirect($this->referer());
        }

        if ($this->request->is('post')) {
            $data = $this->request->data;
            try {
                $transaction = $this->Transactions->newEntity();
                $transaction->amount = $data['amount'];
                $transaction->user_id = $this->Auth->user('id');
                $transaction->card_number = $data['card_no'];
                $transaction->token = $this->request->session()->read('AGENT_DATA.token');
                //$transaction->payment_status = 0;
                $transaction->transaction_id = rand(1111, 9999) . time();
                $transaction->created = date('Y-m-d H:i:s');
                $transaction->modified = date('Y-m-d H:i:s');
                if ($this->Transactions->save($transaction)) {
//                    $sql = "UPDATE `transactions` SET `amount` = \'" . $data['amount'] . "\' WHERE `transactions`.`id` = $transaction->id";
//                    $conn = ConnectionManager::get('default');
//                    $conn->query($sql);
//                    $this->Transactions->query()->update()->set(['amount' => "'" . $data['amount'] . "'"])->where(['id' => $transaction->id])->execute();
                    $this->set(compact('transaction', 'data'));
                } else {
                    $this->Flash->error(_('Some Error Occured.Please try again!!'));
                    $this->redirect($this->referer());
                }
            } catch (\Exception $ex) {
                $this->Flash->error(_('Some Error Occured.Please try again!!'));
                $this->redirect($this->referer());
            }
        }
    }

    public function agentDashboard() {
        $this->viewBuilder()->layout('default');
        $transactions = $this->Transactions->find('all')->order(['id' => 'DESC'])->limit(100);
        $this->set(compact('transactions'));
    }

    public function ajaxSearchSuggestions() {
        $this->viewBuilder()->layout('ajax');
        $keyword = urldecode($this->request->query['keyword']);
        $suggestions = $this->Users->find('all')->select(['id', 'name'])->limit(10)->where(['Users.name LIKE' => "%" . $keyword . "%", 'Users.type' => '2']);
        if ($suggestions->count() > 0) {
            $this->set(compact('suggestions'));
        } else {
            exit(0);
        }
    }

    /*
     * Dev : Pradeepta Khatoi
     * Date : 13 Dec 2016
     * Desc:  Admin Login 
     */

    public function login() {
        if ($this->Auth->user('id')) {
            if ($this->Auth->user('type') == '2') {
                return $this->redirect(['action' => 'card-register']);
            } else {
                return $this->redirect(HTTP_ROOT . 'admin');
            }
        }
        if ($this->request->is('post')) {
            $data = $this->request->data;

            $email = $data['email'];
            $password = $data['password'];

            if ($email == "" && $password == "") {
                $this->Flash->error(__('Please enter email and password'));
            } else if ($email == "") {
                $this->Flash->error(__('Please enter email'));
            } else if ($password == "") {
                $this->Flash->error(__('Please enter password'));
            } else {

                $this->Auth->config('authenticate', [
                    'Form' => [
                        'fields' => ['username' => 'email'],
                        'userModel' => 'Admins'
                    ]
                ]);
                $this->Auth->constructAuthenticate();

                $user = $this->Auth->identify();
                if ($user && $user['is_active'] == 1) {
                    $this->Auth->setUser($user);
                    $this->Flash->success(__('Login successfull'));
                    return $this->redirect(HTTP_ROOT . 'admin');
                } else {
                    $this->Flash->error(__('Invalid username or password, try again'));
                    $this->redirect($this->referer());
                }
            }
        }
    }

    public function logout() {
        //$this->Flash->success(__('See u again'));
        if ($this->Auth->user('type') == 1) {
            $returnURL = HTTP_ROOT;
        } else {
            $returnURL = "https://book.goindigo.in/"; //$this->request->session()->read('AGENT_DATA.rurl');
        }
        $this->Auth->logout();
        return $this->redirect($returnURL);
    }

    //***Pradeepta Code***//


    /*
     * Dev : Pradeepta Khatoi
     * Date : 13 Dec 2016
     * Desc:  Check if agent is valid or not
     */
    public function _agentAuthenticate($data) {

        if (!isset($data['token'])) {
            return ['status' => 'error', 'msg' => 'Token not found'];
        }
        if (!isset($data['agent_id'])) {
            return ['status' => 'error', 'msg' => 'Agent Id no found'];
        }
        if (!isset($data['username'])) {
            return ['status' => 'error', 'msg' => 'Username not found'];
        }
        if (!isset($data['password'])) {
            return ['status' => 'error', 'msg' => 'Password not found'];
        }
        if (!isset($data['surl'])) {
            return ['status' => 'error', 'msg' => 'Success URL not found'];
        }
        if (!isset($data['furl'])) {
            return ['status' => 'error', 'msg' => 'Failure URL not found.'];
        }
        if (!isset($data['rurl'])) {
            return ['status' => 'error', 'msg' => 'Return URL not found'];
        }

        $token = filter_var($data['token'], FILTER_SANITIZE_STRING);
        $agentId = filter_var($data['agent_id'], FILTER_SANITIZE_NUMBER_INT);
        $username = filter_var($data['username'], FILTER_SANITIZE_STRING);
        $password = trim($data['password']);

        $successUrl = filter_var($data['surl'], FILTER_SANITIZE_URL);
        $failureUrl = filter_var($data['furl'], FILTER_SANITIZE_URL);
        $returnUrl = filter_var($data['rurl'], FILTER_SANITIZE_URL);

        if (empty($token)) {
            return ['status' => 'error', 'msg' => 'Token is empty'];
        }
        if (empty($agentId)) {
            return ['status' => 'error', 'msg' => 'Agent is empty'];
        }
        if (empty($username)) {
            return ['status' => 'error', 'msg' => 'Username is empty'];
        }
        if (empty($password)) {
            return ['status' => 'error', 'msg' => 'Password is empty'];
        }
        if (empty($successUrl)) {
            return ['status' => 'error', 'msg' => 'Success URL not found'];
        }

        if (filter_var($successUrl, FILTER_VALIDATE_URL) === false) {
            return ['status' => 'error', 'msg' => 'Success URL is invalid.'];
        }
        if (empty($failureUrl)) {
            return ['status' => 'error', 'msg' => 'Failure URL not found.'];
        }
        if (filter_var($failureUrl, FILTER_VALIDATE_URL) === false) {
            return ['status' => 'error', 'msg' => 'Failure URL is invalid.'];
        }
        if (empty($returnUrl)) {
            return ['status' => 'error', 'msg' => 'Return URL not found.'];
        }
        if (filter_var($returnUrl, FILTER_VALIDATE_URL) === false) {
            return ['status' => 'error', 'msg' => 'Return URL is invalid.'];
        }

        $query = $this->Airlines->find()->where(['username' => $username, 'password' => md5($password)]);

        if ($query->count() <= 0) {
            return ['status' => 'error', 'msg' => 'Invalid Username or Password.'];
        } else {
            return ['status' => 'success', 'airline' => $query->first()];
        }
    }

    /*
     * Dev : Pradeepta Khatoi
     * Date : 13 Dec 2016
     * Desc:  Check if agent is valid or not
     * Return Landing url if valid
     */

    public function agentAuthentication() {
        $this->viewBuilder()->layout('');

        $encryptedData = file_get_contents('php://input');
        require_once(ROOT . DS . 'vendor' . DS . 'aes' . DS . 'AES.php');
        $aes = new \AES($encryptedData, ENCRYPTION_KEY, ENCRYPTION_BLOCK_SIZE, ENCRYPTION_MODE);
        $jsonData = $aes->decrypt();

        if ($jsonData == "" || $jsonData == NULL) {
            echo json_encode([ "error" => "No Data Available. Input Fields are not provided."]);
            exit;
        }

        if (!is_object(json_decode($jsonData))) {
            echo json_encode([ "error" => "Invalid Json passed as input"]);
            exit;
        }

        $data = json_decode($jsonData, TRUE);

        $statusData = $this->_agentAuthenticate($data);

        if ($statusData['status'] == 'success') {

            $token = filter_var($data['token'], FILTER_SANITIZE_STRING);
            $agentId = filter_var($data['agent_id'], FILTER_SANITIZE_NUMBER_INT);
            $username = filter_var($data['username'], FILTER_SANITIZE_STRING);
            $password = trim($data['password']);

            $airline = $statusData['airline']; //$this->Airlines->find()->where(['username' => $username, 'password' => md5($password)])->first();
            $query = $this->Users->find()->where(['airline_id' => $airline->id, 'agent_id' => $agentId]);

            $authToken = $this->Custom->generateAuthToken();

            if ($query->count() > 0) {
                $user = $query->first();
                $updateData = [
                    'last_login_date' => date('Y-m-d H:i:s'),
                    'token' => $token,
                    'auth_token' => $authToken,
                    'agent_data' => json_encode($data)
                ];
                $this->Users->query()->update()->set($updateData)->where(['id' => $user->id])->execute();
            } else {
                $user = $this->Users->newEntity();
                $user->agent_id = $agentId;
                $user->airline_id = $airline->id;
                $user->auth_token = $authToken;
                $user->agent_data = json_encode($data);
                $user->token = $token;
                $user->created = date('Y-m-d H:i:s');
                $user->last_login_date = date('Y-m-d H:i:s');
                $this->Users->save($user);
            }
            $data = json_encode(['status' => 'success', 'data' => ['session_id' => $authToken, 'url' => HTTP_ROOT . "users/landing/?authtoken={$authToken}"]]);
            header('Content-type: application/json');
            echo $data;
            exit;
        } else {
            $data = json_encode(['status' => 'failed', 'data' => ['session_id' => null, 'url' => null, 'msg' => $statusData['msg']]]);
            header('Content-type: application/json');
            echo $data;
            exit;
        }
        exit;
    }

    /*
     * Dev : Pradeepta Khatoi
     * Date : 13 Dec 2016
     * Desc:  If Url is corrrect i.e. present in DB then login that agent into the website automatically
     */

    public function landing() {
        $authtoken = urldecode($_GET['authtoken']);
        $query = $this->Users->find()->where(['auth_token' => $authtoken]);
        if ($query->count() > 0) {
            $user = $this->Users->get($query->first()->id);
            $this->Auth->setUser($user->toArray());
            $agentData = json_decode($user->agent_data, TRUE);
            $this->request->session()->write('AGENT_DATA', $agentData);
            $user->auth_token = "";
            $user->agent_data = "";
            $this->Users->save($user);
            $this->redirect(HTTP_ROOT . "recharge");
        } else {
            $this->redirect($this->referer());
        }
    }

    /*
     * Dev : Pradeepta Khatoi
     * Date : 13 Dec 2016
     * Desc: This Method used for Acknowledgement URL.
     * If correct data is sent then it will update the navitor_status
     */

    public function naviatorStatus($id = null) {

        if (!$this->request->is('post')) {
            echo json_encode([ "error" => "Method Not Allowed"]);
            exit;
        }

        if (!isset($_SERVER['PHP_AUTH_USER'])) {
            echo json_encode([ "error" => "Add Authorization key in header!"]);
            exit;
        }

        if ($_SERVER['PHP_AUTH_USER'] != 'indigo' || $_SERVER['PHP_AUTH_PW'] != '9W@qTuML!7<#=3l') {
            echo json_encode([ "error" => "Basic Authentication Failed."]);
            exit;
        }

        $encryptedData = file_get_contents('php://input');
        require_once(ROOT . DS . 'vendor' . DS . 'aes' . DS . 'AES.php');
        $aes = new \AES($encryptedData, ENCRYPTION_KEY, ENCRYPTION_BLOCK_SIZE, ENCRYPTION_MODE);
        $jsonData = $aes->decrypt();

        if ($jsonData == "" || $jsonData == NULL) {
            echo json_encode([ "error" => "No Data Available. Input Fields are not provided."]);
            exit;
        }

        if (!is_object(json_decode($jsonData))) {
            echo json_encode([ "error" => "Invalid Json passed as input"]);
            exit;
        }

        $data = json_decode($jsonData, TRUE);

        $transactionId = $data['TransactionID'];
        $handlerID = $data['HandlerID'];

        $query = $this->Transactions->find('all')->where(['transaction_id' => $transactionId, 'mihpayid' => $handlerID]);

        if ($query->count() <= 0) {
            echo json_encode([ "error" => "Invalid Transaction ID."]);
            exit;
        }
        $conn = ConnectionManager::get('default');
        $sql = "UPDATE `transactions` SET `navitor_status` = '1' WHERE `transaction_id` = '$transactionId' AND `mihpayid` = '$handlerID'";
        $stmt = $conn->prepare($sql);
        header('Content-type: application/json');
        if ($stmt->execute()) {
            echo json_encode([ "messageCode" => 200, "message" => "Status Updated Successfully"]);
        } else {
            echo json_encode([ "messageCode" => 505, "message" => "Internal Server Error"]);
        }
        exit;
    }

    /*
     * Dev : Pradeepta Khatoi
     * Date : 13 Dec 2016
     * Desc: Update Agent Info
     */

    public function updateAgentInfo() {
        $user = $this->Users->newEntity();
        if ($this->request->is('post')) {
            $data = $this->request->data;

            $email = filter_var($data['email'], FILTER_SANITIZE_EMAIL);
            $query = $this->Users->find()->where(['Users.email' => $email, 'Users.id !=' => $this->Auth->user('id')]);
            if ($query->count() > 0) {
                $this->Flash->error(__("Email already exist."));
                return $this->redirect($this->referer());
            }
            $user->id = $this->Auth->user('id');
            $user->firstname = $data['firstname'];
            $user->lastname = $data['lastname'];
            $user->email = $email;
            $user->mobile = $data['mobile'];
            if ($this->Users->save($user)) {
                $this->Flash->success(__("Profile Updated Successfully."));
            } else {
                $this->Flash->error(__("Some error occured. Please try again."));
            }
            return $this->redirect($this->referer());
        }
    }

    public function downloadFile($filePath) {
        $this->response->file($filePath, ['download' => TRUE, 'name' => "SampleExcel.xlsx"]);
        return $this->response;
        exit;
    }

    public function previewFile($filePath) {
        $file = basename($filePath);
        $this->response->file($filePath, ['name' => $file]);
        return $this->response;
        exit;
    }

    /*
     * Dev : Pradeepta Khatoi
     * Date : 13 Dec 2016
     * Desc:  Test Encryption & Decryption
     */

    public function tstEncryption($enc = 'ssMgUJzIFG5hPLNFbU/+9BQJzU9xsAbZjkKOU1P3bPe2e6g1oI27ZFJn3tvIXQXHQUrNjZRQcWwtsnj8Jti69O2zyaJExX5aM4m6Pr+zcYe50PlDS01T3H2JEOPwguJt') {
        require_once(ROOT . DS . 'vendor' . DS . 'aes' . DS . 'AES.php');
        $aes = new \AES($jsonData, ENCRYPTION_KEY, ENCRYPTION_BLOCK_SIZE, ENCRYPTION_MODE);
        $enc = "ssMgUJzIFG5hPLNFbU/+9BQJzU9xsAbZjkKOU1P3bPe2e6g1oI27ZFJn3tvIXQXHQUrNjZRQcWwtsnj8Jti69O2zyaJExX5aM4m6Pr+zcYe50PlDS01T3H2JEOPwguJt";
        $aes->setData($enc);
        $dec = $aes->decrypt();

        echo $dec;
        echo strlen($dec);

        exit;

        $result = json_decode($dec);
        var_dump($result);

        $json = stripslashes("'$dec'");
        $postarray = json_decode($json);
        print_r($postarray);

        print_r(json_decode($dec));
        print_r(json_decode($dec, true));

        exit;
    }

    /*
     * Dev : Pradeepta Khatoi
     * Date : 13 Dec 2016
     * Desc:  Test Sample Email
     */

    public function tstEmail($to = 'pradeepta.raddyx@gmail.com') {
        $status = $this->Custom->sendEmail($to, 'someone@xyz.com', 'Test Image', 'Jay Jagannath', 'pradeepta.raddyx@gmail.com');
        if ($status) {
            echo "Email Sent";
        } else {
            echo "Not Sent";
        }
        exit;
    }

    //***Pradeepta Code End***//
}
