<?php

namespace App\Controller;

use App\Controller\AppController;
use Cake\Event\Event;
use Cake\Datasource\ConnectionManager;

class TransactionsController extends AppController {

    public function initialize() {
        parent::initialize();
        $this->viewBuilder()->layout('default');

        $this->loadComponent('RequestHandler');
        $this->loadComponent('Paginator');

        $this->loadModel('Users');
        $this->loadModel('Transactions');
    }

    public function beforeFilter(Event $event) {
        parent::beforeFilter($event);
//        $this->Auth->allow();
    }

    public function ajaxGetTransactions() {
        $this->viewBuilder()->layout('ajax');
        $conditions = ['Transactions.user_id' => $this->Auth->user('id')];
        $data = $this->request->query;
        $page = !empty($data['page']) ? $data['page'] : 1;

        if (!empty($data['keyword'])) {
            $keyword = trim(urldecode($data['keyword']));
            $conditions[] = ['OR' => [['Transactions.transaction_id' => $keyword]]];
        }
        if (!empty($data['from_date'])) {
            $fromDate = urldecode($data['from_date']);
            $conditions[] = ['DATE(Transactions.created) >=' => $fromDate];
        }
        if (!empty($data['to_date'])) {
            $doDate = urldecode($data['to_date']);
            $conditions[] = ['DATE(Transactions.created) <=' => $doDate];
        }

        $limit = 20;
        $config = [
            'limit' => $limit,
            'order' => ['Transactions.id' => 'DESC'],
            'contain' => [],
            'conditions' => $conditions,
            'page' => $page
        ];
        $transactions = $this->Paginator->paginate($this->Transactions->find(), $config);
        $this->set(compact('transactions', 'page', 'limit'));
    }

    public function success($id = null) {
        $this->request->allowMethod(['post']);
        //pr($_POST); exit;

        if ($id) {
            //Update DB//           

            $status = $_POST["status"];
            $firstname = $_POST["firstname"];
            $amount = $_POST["amount"];
            $txnid = $_POST["txnid"];
            $key = $_POST["key"];
            $productinfo = $_POST["productinfo"];
            $email = $_POST["email"];
            $salt = SALT;
            $key = KEY;

            $postedHash = $_POST["hash"];

            $retHashSeq = $salt . '|' . $status . '|||||||||||' . $email . '|' . $firstname . '|' . $productinfo . '|' . $amount . '|' . $txnid . '|' . $key;
            $hash = hash("sha512", $retHashSeq);

            if ($hash == $postedHash) {

                $transaction = $this->Transactions->get($id);
                $transaction->payment_status = 1;
                $transaction->unmappedstatus = $_POST['unmappedstatus'];
                $transaction->mihpayid = $_POST['mihpayid'];
                $transaction->id = $id;
                $this->Transactions->save($transaction);


                $handlerID = $_POST['mihpayid'];
                $transactionId = $transaction->transaction_id;
                $transactionDate = date('Y-m-d', strtotime($transaction->created));
                $cardnum = str_replace("X", "-", $_POST['cardnum']);

                $username = $this->request->session()->read('AGENT_DATA.username');
                $password = $this->request->session()->read('AGENT_DATA.password');

                $data = [
                    "HandlerID" => $handlerID,
                    "TransactionType" => "Card",
                    "TransactionID" => $transactionId,
                    "TransactionDate" => $transactionDate,
                    "Amount" => $transaction->amount,
                    "Currency" => "INR",
                    "CardType" => "VISA",
                    "AgentID" => $this->Auth->user('agent_id'),
                    "CreditCardNo" => $cardnum
                ];

                require_once(ROOT . DS . 'vendor' . DS . 'aes' . DS . 'AES.php');
                $jsonData = json_encode($data);
                $aes = new \AES($jsonData, ENCRYPTION_KEY, ENCRYPTION_BLOCK_SIZE, ENCRYPTION_MODE);
                $encryptedData = $aes->encrypt();


                //dropped/bounced/captured/auth/failed/usercancelled/pending 
                if ($_POST['unmappedstatus'] == 'captured') {
                    //ESB Pending URL Start//  
                    $url = $this->request->session()->read('AGENT_DATA.surl');
                    $ch = curl_init();
                    $curlConfig = array(
                        CURLOPT_URL => $url,
                        CURLOPT_POST => true,
                        CURLOPT_RETURNTRANSFER => true,
                        CURLOPT_TIMEOUT => 40,
                        CURLOPT_POSTFIELDS => $encryptedData,
                        CURLOPT_USERPWD => "$username:$password",
                        CURLOPT_HTTPHEADER => array(
                            'Content-Type: application/json'
                        )
                    );
                    curl_setopt_array($ch, $curlConfig);
                    $result = curl_exec($ch);

                    if (curl_errno($ch)) {
                        echo 'Curl error: ' . curl_error($ch);
                    }
                    curl_close($ch);

                    $response = json_decode($result);
                    if ($response->messageCode == 200) {
                        $status = $this->Transactions->query()->update()->set(['pending_url_hit' => 1, 'navitor_status' => 2])->where(['transaction_id' => $transactionId])->execute();
                    }

                    echo "<pre>";
                    echo "ESB Pending URL Response";
                    echo "<br/>";
                    print_r($result);
                    echo "</pre>";
                    //ESB Pending URL End//
                } else {
                    //ESB Failure URL End// 
                    $url = $this->request->session()->read('AGENT_DATA.furl');
                    //  Initiate curl
                    $ch = curl_init();
                    $curlConfig = array(
                        CURLOPT_URL => $url,
                        CURLOPT_POST => true,
                        CURLOPT_RETURNTRANSFER => true,
                        CURLOPT_TIMEOUT => 40,
                        CURLOPT_POSTFIELDS => $encryptedData,
                        CURLOPT_USERPWD => "$username:$password",
                        CURLOPT_HTTPHEADER => array(
                            'Content-Type: application/json'
                        )
                    );
                    curl_setopt_array($ch, $curlConfig);
                    $result = curl_exec($ch);
                    if (curl_errno($ch)) {
                        echo 'Curl error: ' . curl_error($ch);
                    }
                    curl_close($ch);
                    echo "<pre>";
                    echo "ESB Failure URL Response";
                    echo "<br/>";
                    print_r($result);
                    echo "</pre>";
                    //ESB Failure URL End//  
                }

                $this->set('data', $_POST);
            } else {
                $this->set('error', "Invalid Transaction. Please try again");
            }
        }
    }

    public function failure($id = null) {
        $this->request->allowMethod(['post']);
        if ($id) {

            $status = $_POST["status"];
            $firstname = $_POST["firstname"];
            $amount = $_POST["amount"];
            $txnid = $_POST["txnid"];
            $key = $_POST["key"];
            $productinfo = $_POST["productinfo"];
            $email = $_POST["email"];
            $salt = SALT;
            $key = KEY;

            $postedHash = $_POST["hash"];

            $retHashSeq = $salt . '|' . $status . '|||||||||||' . $email . '|' . $firstname . '|' . $productinfo . '|' . $amount . '|' . $txnid . '|' . $key;
            $hash = hash("sha512", $retHashSeq);

            if ($hash == $postedHash) {

                //Upadate Transaction Status to Failure//    
                $transaction = $this->Transactions->get($id);
                $transaction->payment_status = 3;
                $transaction->unmappedstatus = $_POST['unmappedstatus'];
                $transaction->mihpayid = $_POST['mihpayid'];
                $transaction->id = $id;
                $this->Transactions->save($transaction);

                //if ($_POST['unmappedstatus'] == 'failed' || $_POST['usercancelled'] == '') {
                //ESB Pending URL Start//  
                $data = $_POST;

                $handlerID = $_POST['mihpayid'];
                $cardnum = !empty($data['cardnum']) ? $data['cardnum'] : '';
                $cardnum = str_replace("X", "-", $cardnum);
                $transactionId = $transaction->transaction_id;
                $transactionDate = date('Y-m-d', strtotime($transaction->created));

                $username = $this->request->session()->read('AGENT_DATA.username');
                $password = $this->request->session()->read('AGENT_DATA.password');

                $data = [
                    "HandlerID" => $handlerID,
                    'TransactionType' => "Card",
                    "TransactionID" => $transactionId,
                    "TransactionDate" => $transactionDate,
                    "Amount" => $transaction->amount,
                    "Currency" => "INR",
                    "CardType" => "VISA",
                    "AgentID" => $this->Auth->user('agent_id'),
                    "CreditCardNo" => $cardnum
                ];

                require_once(ROOT . DS . 'vendor' . DS . 'aes' . DS . 'AES.php');
                $jsonData = json_encode($data);
                $aes = new \AES($jsonData, ENCRYPTION_KEY, ENCRYPTION_BLOCK_SIZE, ENCRYPTION_MODE);
                $encryptedData = $aes->encrypt();

                $url = $this->request->session()->read('AGENT_DATA.furl');
                //  Initiate curl
                $ch = curl_init();
                $curlConfig = array(
                    CURLOPT_URL => $url,
                    CURLOPT_POST => true,
                    CURLOPT_RETURNTRANSFER => true,
                    CURLOPT_TIMEOUT => 40,
                    CURLOPT_POSTFIELDS => $encryptedData,
                    CURLOPT_USERPWD => "$username:$password",
                    CURLOPT_HTTPHEADER => array(
                        'Content-Type: application/json'
                    )
                );
                curl_setopt_array($ch, $curlConfig);
                $result = curl_exec($ch);

                if (curl_errno($ch)) {
                    echo 'Curl error: ' . curl_error($ch);
                }
                curl_close($ch);
                echo "<pre>";
                echo "ESB Failure URL Response";
                echo "<br/>";
                print_r($result);
                echo "</pre>";
                //ESB Pending URL End//   
                //}
            }
        }
    }

    public function cancel($id = null) {
        $this->request->allowMethod(['post']);
        if ($id) {

            $status = $_POST["status"];
            $firstname = $_POST["firstname"];
            $amount = $_POST["amount"];
            $txnid = $_POST["txnid"];
            $key = $_POST["key"];
            $productinfo = $_POST["productinfo"];
            $email = $_POST["email"];
            $salt = SALT;
            $key = KEY;

            $postedHash = $_POST["hash"];

            $retHashSeq = $salt . '|' . $status . '|||||||||||' . $email . '|' . $firstname . '|' . $productinfo . '|' . $amount . '|' . $txnid . '|' . $key;
            $hash = hash("sha512", $retHashSeq);

            if ($hash == $postedHash) {

                //Upadate Transaction Status to Failure//    
                $transaction = $this->Transactions->get($id);
                $transaction->payment_status = 4;
                $transaction->unmappedstatus = $_POST['unmappedstatus'];
                $transaction->mihpayid = $_POST['mihpayid'];
                $transaction->id = $id;
                $this->Transactions->save($transaction);

                //if ($_POST['unmappedstatus'] == 'failed' || $_POST['usercancelled'] == '') {
                //ESB Pending URL Start//  
                $data = $_POST;

                $handlerID = $_POST['mihpayid'];
                $cardnum = !empty($data['cardnum']) ? $data['cardnum'] : '';
                $cardnum = str_replace("X", "-", $cardnum);
                $transactionId = $transaction->transaction_id;
                $transactionDate = date('Y-m-d', strtotime($transaction->created));

                $username = $this->request->session()->read('AGENT_DATA.username');
                $password = $this->request->session()->read('AGENT_DATA.password');

                $data = [
                    "HandlerID" => $handlerID,
                    'TransactionType' => "Card",
                    "TransactionID" => $transactionId,
                    "TransactionDate" => $transactionDate,
                    "Amount" => $transaction->amount,
                    "Currency" => "INR",
                    "CardType" => "VISA",
                    "AgentID" => $this->Auth->user('agent_id'),
                    "CreditCardNo" => $cardnum
                ];

                require_once(ROOT . DS . 'vendor' . DS . 'aes' . DS . 'AES.php');
                $jsonData = json_encode($data);
                $aes = new \AES($jsonData, ENCRYPTION_KEY, ENCRYPTION_BLOCK_SIZE, ENCRYPTION_MODE);
                $encryptedData = $aes->encrypt();

                $url = $this->request->session()->read('AGENT_DATA.furl');
                //  Initiate curl
                $ch = curl_init();
                $curlConfig = array(
                    CURLOPT_URL => $url,
                    CURLOPT_POST => true,
                    CURLOPT_RETURNTRANSFER => true,
                    CURLOPT_TIMEOUT => 40,
                    CURLOPT_POSTFIELDS => $encryptedData,
                    CURLOPT_USERPWD => "$username:$password",
                    CURLOPT_HTTPHEADER => array(
                        'Content-Type: application/json'
                    )
                );
                curl_setopt_array($ch, $curlConfig);
                $result = curl_exec($ch);

                if (curl_errno($ch)) {
                    echo 'Curl error: ' . curl_error($ch);
                }
                curl_close($ch);
                echo "<pre>";
                echo "ESB Failure URL Response";
                echo "<br/>";
                print_r($result);
                echo "</pre>";
                //ESB Pending URL End//   
                //}
            }
        }
    }

    public function cancelOLD($id = null) {
        $this->request->allowMethod(['post']);
        if ($id) {
            /* Upadate Transaction Status to Cancel */
            $transaction = $this->Transactions->newEntity();
            $transaction->payment_status = 4;
            $transaction->id = $id;
            $this->Transactions->save($transaction);
        }
    }

}
