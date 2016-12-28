<?php

namespace App\Controller\Admin;

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
        $this->loadModel('MailTemplates');
        $this->loadModel('AdminSettings');
        $this->loadModel('FailedTransactions');
    }

    public function beforeRender(Event $event) {
        $this->viewBuilder()->layout('admin');
    }

    public function beforeFilter(Event $event) {
        parent::beforeFilter($event);
        $this->Auth->allow(['login', 'logout', 'home', 'agentAuthentication', 'authenticationFailure', 'naviatorStatus', 'landing']);
    }

    public function dashboard() {

        if ($this->request->is('post')) {
            $data = $this->request->data;
            if ($data['chk_btn'] == 'approve') {
                foreach ($data['chk'] as $chk) {
                    $this->Cards->query()->update()->set(['is_approve' => '1'])->where(['card_token' => $chk])->execute();
                    $this->_cardApproveEmail($chk);
                }
                $this->Flash->success(__("Card is approved"));
                return $this->redirect($this->referer());
            } else {
                foreach ($data['chk'] as $chk) {
                    $this->Cards->query()->update()->set(['is_approve' => '0'])->where(['card_token' => $chk])->execute();
                    $this->_cardDisapproveEmail($chk);
                }
                $this->Flash->success(__("Card is disapproved"));
                return $this->redirect($this->referer());
            }
        }

        $data = $this->request->query;
        $userList = $this->Cards->find('all')->select(['user_id']);
        $getUsers = $this->Users->find('all')->where(['Users.id IN' => $userList]);

        $key = KEY;
        $salt = SALT;
        $command = "get_user_cards";

        $conditions = ['Cards.user_id !=' => '0', 'Cards.card_token !=' => ''];
        $config = [
            'limit' => 20,
            'order' => ['Cards.id' => 'DESC'],
            'contain' => [],
            'conditions' => $conditions
        ];
        $cards = $this->Paginator->paginate($this->Cards->find(), $config);
        foreach ($cards as $card) {
            $var1 = "{$key}:{$card->user_id}"; // User Credentials
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
            $returnData = curl_exec($c);
            curl_close($c);
            $userCards = json_decode($returnData, TRUE);
            if ($userCards['status'] == 1) {
                $allCards = $userCards['user_cards'];
            }
            $card->card_detail = $this->_mapCard($allCards, $card->card_token);
        }
        $this->set(compact('cards'));
    }

    public function _mapCard($allCards, $token) {
        foreach ($allCards as $key => $value) {
            if ($key == $token) {
                return $allCards[$key];
            }
        }
        return NULL;
    }

    public function cardapprove($token) {
        if ($token) {
            $status = $this->Cards->query()->update()->set(['is_approve' => 1])->where(['card_token' => $token])->execute();
            if ($status) {
                $this->_cardApproveEmail($token);
                $this->Flash->success(__("Card is approved"));
            } else {
                $this->Flash->error(__("Some error occured. Please try again."));
            }
            return $this->redirect($this->referer());
            exit;
        }
    }

    public function _cardApproveEmail($token) {
        if ($token) {
            //Send Email//
            $cardDetails = $this->Cards->find()->where(['Cards.card_token' => $token])->contain(['Users'])->first();
            $mailTemplate = $this->MailTemplates->find()->where(['name' => 'CARD_APPROVED', 'is_active' => 1])->first();
            $adminSetting = $this->AdminSettings->find()->where()->first();
            $message = $this->Custom->formatEmail($mailTemplate['content'], [
                'NAME' => $cardDetails->user->firstname . " " . $cardDetails->user->lastname,
                'CARD_NO' => $cardDetails->card_no,
                'LOGIN_ID' => $cardDetails->login_id,
                'AGENCY_ID' => $cardDetails->agency_id,
                'BANK_NAME' => $cardDetails->bank_name,
                'EMAIL' => $cardDetails->email
            ]);
            $to = $adminSetting->card_approve_email;
            $bcc = $adminSetting->bcc_email;
            $from = $adminSetting->from_email;
            if ($cardDetails->mandate_form) {
                $files[] = MANDATE_FORM . $cardDetails->mandate_form;
            }
            if ($cardDetails->scanned_credit_card) {
                $files[] = SCANNED_CREDIT_CARD . $cardDetails->scanned_credit_card;
            }
            if ($cardDetails->document3) {
                $files[] = DOCUMENT3 . $cardDetails->document3;
            }
            $this->Custom->sendEmail($to, $from, $mailTemplate->subject, $message, $bcc, $files);
            //Send Email End//
        }
        return TRUE;
    }

    public function carddisapprove($token) {
        if ($token) {
            $status = $this->Cards->query()->update()->set(['is_approve' => 2])->where(['card_token' => $token])->execute();
            if ($status) {
                $this->_cardDisapproveEmail($token);
                $this->Flash->success(__("Card is disapproved"));
            } else {
                $this->Flash->error(__("Some error occured. Please try again."));
            }
            return $this->redirect($this->referer());
        }
        exit;
    }

    public function _cardDisapproveEmail($token) {
        if ($token) {
            //Send Email//
            $cardDetails = $this->Cards->find()->where(['Cards.card_token' => $token])->contain(['Users'])->first();
            $mailTemplate = $this->MailTemplates->find()->where(['name' => 'CARD_DECLINED', 'is_active' => 1])->first();
            $adminSetting = $this->AdminSettings->find()->where()->first();
            $message = $this->Custom->formatEmail($mailTemplate['content'], [
                'NAME' => $cardDetails->user->firstname . " " . $cardDetails->user->lastname,
                'CARD_NO' => $cardDetails->card_no,
                'LOGIN_ID' => $cardDetails->login_id,
                'AGENCY_ID' => $cardDetails->agency_id,
                'BANK_NAME' => $cardDetails->bank_name,
                'EMAIL' => $cardDetails->email
            ]);
            $to = $adminSetting->card_approve_email;
            $bcc = $adminSetting->bcc_email;
            $from = $adminSetting->from_email;
            if ($cardDetails->mandate_form) {
                $files[] = MANDATE_FORM . $cardDetails->mandate_form;
            }
            if ($cardDetails->scanned_credit_card) {
                $files[] = SCANNED_CREDIT_CARD . $cardDetails->scanned_credit_card;
            }
            if ($cardDetails->document3) {
                $files[] = DOCUMENT3 . $cardDetails->document3;
            }
            $this->Custom->sendEmail($to, $from, $mailTemplate->subject, $message, $bcc, $files);
            //Send Email End//
        }
        return TRUE;
    }

    public function transactions() {

        if ($this->request->is('post')) {
            $data = $this->request->data;
            foreach ($data as $key => $value) {
                if ($value != '') {
                    $qs[$key] = $value;
                }
            }
            return $this->redirect(["controller" => "Users", "action" => "transactions", '?' => $qs]);
        }

        $conditions = [];
        $data = $this->request->query;

        if (!empty($data['transaction_id'])) {
            $conditions[] = array('Transactions.transaction_id' => trim($data['transaction_id']));
        }
        /*
          if (!empty($data['payment_status'])) {
          if ($data['payment_status'] == 3) {
          $conditions[] = array('Transactions.payment_status IN' => [0, 3]);
          } else {
          $conditions[] = array('Transactions.payment_status' => $data['payment_status']);
          }
          } else {
          $conditions[] = array('Transactions.payment_status' => 1);
          }
         */

        if (!empty($data['from_date'])) {
            $fromDate = urldecode($data['from_date']);
            $conditions[] = ['DATE(Transactions.created) >=' => $fromDate];
        }
        if (!empty($data['to_date'])) {
            $doDate = urldecode($data['to_date']);
            $conditions[] = ['DATE(Transactions.created) <=' => $doDate];
        }

        if (isset($data['payu_status']) && $data['payu_status'] != '') {
            $conditions[] = array('Transactions.unmappedstatus' => $data['payu_status']);
        }

        if (isset($data['navitor_status']) && $data['navitor_status'] != '') {
            $conditions[] = array('Transactions.navitor_status' => $data['navitor_status']);
        }

        $user_id = $this->Auth->user('id');
        $this->Transactions->belongsTo('Users', [
            'className' => 'Users',
            'foreignKey' => 'user_id'
        ]);

        if (isset($data['download_report'])) {
            include ROOT . DS . 'vendor' . DS . 'phpexcel' . DS . 'vendor' . DS . 'autoload.php';

            $transactions = $this->Transactions->find('all')->where($conditions)->contain(['Users'])->limit(1000);

            $objPHPExcel = new \PHPExcel();
            $objPHPExcel->setActiveSheetIndex(0);

            $style = [
                'alignment' => [
                    'horizontal' => \PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                ]
            ];

            $objPHPExcel->getActiveSheet()->getStyle('A1:H1')->getFont()->setBold(true);
            $objPHPExcel->getActiveSheet()->getStyle("A1:H1")->applyFromArray($style);
            foreach (range('A', 'H') as $columnID) {
                $objPHPExcel->getActiveSheet()->getColumnDimension($columnID)->setAutoSize(true);
            }
            ///SetHeading//  
            $objPHPExcel->getActiveSheet()->SetCellValue('A1', "Date");
            $objPHPExcel->getActiveSheet()->SetCellValue('B1', "Agent Name");
            $objPHPExcel->getActiveSheet()->SetCellValue('C1', "Txn ID");
            $objPHPExcel->getActiveSheet()->SetCellValue('D1', "Amount");
            $objPHPExcel->getActiveSheet()->SetCellValue('E1', "Card No");
            $objPHPExcel->getActiveSheet()->SetCellValue('F1', "PayU Status");
            $objPHPExcel->getActiveSheet()->SetCellValue('G1', "IndiGo Status");
            $objPHPExcel->getActiveSheet()->SetCellValue('H1', "Action");

            //Set Content
            $rowCount = 2;
            foreach ($transactions as $transaction) {
                $objPHPExcel->getActiveSheet()->SetCellValue('A' . $rowCount, date("M d, Y", strtotime($transaction->created)));
                $objPHPExcel->getActiveSheet()->SetCellValue('B' . $rowCount, $transaction->user->firstname . ' ' . $transaction->user->lastname);
                $objPHPExcel->getActiveSheet()->SetCellValue('C' . $rowCount, " " . $transaction->transaction_id . " ");
                $objPHPExcel->getActiveSheet()->SetCellValue('D' . $rowCount, "Rs." . $this->Custom->formatMoney($transaction->amount));
                $objPHPExcel->getActiveSheet()->SetCellValue('E' . $rowCount, $transaction->card_number);
                $objPHPExcel->getActiveSheet()->SetCellValue('F' . $rowCount, $transaction->unmappedstatus);
                $objPHPExcel->getActiveSheet()->SetCellValue('G' . $rowCount, $this->Custom->navitorStatus($transaction));
                $retry = "";
                if ($transaction->unmappedstatus == 'captured' && $transaction->pending_url_hit != 1) {
                    $retry = "Retry";
                }
                $objPHPExcel->getActiveSheet()->SetCellValue('H' . $rowCount, $retry);

                $objPHPExcel->getActiveSheet()->getStyle("A$rowCount:H$rowCount")->applyFromArray($style);
                $rowCount++;
            }

            $filename = "Transaction-Report-" . time() . ".xlsx";
            $objWriter = new \PHPExcel_Writer_Excel2007($objPHPExcel);
            $objWriter->save("files/reports/$filename");

            ob_clean();
            $filePath = 'files/reports/' . $filename;
            $size = filesize($filePath);
            header('Content-Description: File Transfer');
            header('Content-Type: application/octet-stream');
            header('Content-Disposition: attachment; filename=' . $filename);
            header('Content-Transfer-Encoding: binary');
            header('Connection: Keep-Alive');
            header('Expires: 0');
            header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
            header('Pragma: public');
            header('Content-Length: ' . $size);
            readfile($filePath);

            $file = new \Cake\Filesystem\File($filePath);
            $file->delete();
            exit();

            return $this->redirect($this->referer());
        }

        $config = [
            'limit' => 20,
            'order' => ['Transactions.id' => 'desc'],
            'contain' => ['Users'],
            'conditions' => $conditions
        ];
        $transactions = $this->Paginator->paginate($this->Transactions->find(), $config);
        $this->set(compact('transactions'));
    }

    public function failedTransactions() {
        $conditions = [];
        $data = $this->request->query;

        if (!empty($data['transaction_id'])) {
            $conditions[] = array('Transactions.transaction_id' => trim($data['transaction_id']));
        }
        if (!empty($data['payment_status'])) {
            if ($data['payment_status'] == 3) {
                $conditions[] = array('Transactions.payment_status IN' => [0, 3]);
            } else {
                $conditions[] = array('Transactions.payment_status' => $data['payment_status']);
            }
        }
        if (isset($data['navitor_status']) && $data['navitor_status'] != '') {
            $conditions[] = array('Transactions.navitor_status' => $data['navitor_status']);
        }

        $user_id = $this->Auth->user('id');
        $this->Transactions->belongsTo('Users', [
            'className' => 'Users',
            'foreignKey' => 'user_id'
        ]);

        if (isset($data['download_report'])) {
            include ROOT . DS . 'vendor' . DS . 'phpexcel' . DS . 'vendor' . DS . 'autoload.php';

            $failedTransactions = $this->FailedTransactions->find('all')->where($conditions)->contain(['Transactions', 'Transactions.Users'])->limit(1000);

            $objPHPExcel = new \PHPExcel();
            $objPHPExcel->setActiveSheetIndex(0);

            $style = [
                'alignment' => [
                    'horizontal' => \PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                ]
            ];

            $objPHPExcel->getActiveSheet()->getStyle('A1:G1')->getFont()->setBold(true);
            $objPHPExcel->getActiveSheet()->getStyle("A1:G1")->applyFromArray($style);
            foreach (range('A', 'G') as $columnID) {
                $objPHPExcel->getActiveSheet()->getColumnDimension($columnID)->setAutoSize(true);
            }
            ///SetHeading//  
            $objPHPExcel->getActiveSheet()->SetCellValue('A1', "Date");
            $objPHPExcel->getActiveSheet()->SetCellValue('B1', "Agent Name");
            $objPHPExcel->getActiveSheet()->SetCellValue('C1', "Txn ID");
            $objPHPExcel->getActiveSheet()->SetCellValue('D1', "Amount");
            $objPHPExcel->getActiveSheet()->SetCellValue('E1', "Card No");
            $objPHPExcel->getActiveSheet()->SetCellValue('F1', "Txn Status");
            $objPHPExcel->getActiveSheet()->SetCellValue('G1', "Indigo Navitor Status");
            //Set Content
            $rowCount = 2;
            foreach ($failedTransactions as $failedTransaction) {
                $objPHPExcel->getActiveSheet()->SetCellValue('A' . $rowCount, $failedTransaction->transaction->created);
                $objPHPExcel->getActiveSheet()->SetCellValue('B' . $rowCount, $failedTransaction->transaction->user->firstname . ' ' . $failedTransaction->transaction->user->lastname);
                $objPHPExcel->getActiveSheet()->SetCellValue('C' . $rowCount, $failedTransaction->transaction->transaction_id);
                $objPHPExcel->getActiveSheet()->SetCellValue('D' . $rowCount, $failedTransaction->transaction->amount);
                $objPHPExcel->getActiveSheet()->SetCellValue('E' . $rowCount, $failedTransaction->transaction->card_number);
                $objPHPExcel->getActiveSheet()->SetCellValue('F' . $rowCount, $this->Custom->paymentStatus($failedTransaction->transaction->payment_status));
                $objPHPExcel->getActiveSheet()->SetCellValue('G' . $rowCount, $this->Custom->navitorStatus($failedTransaction->transaction->navitor_status));
                $objPHPExcel->getActiveSheet()->getStyle("A$rowCount:G$rowCount")->applyFromArray($style);
                $rowCount++;
            }

            $filename = "Failed-Transaction-Report-" . time() . ".xlsx";
            $objWriter = new \PHPExcel_Writer_Excel2007($objPHPExcel);
            $objWriter->save("files/reports/$filename");

            ob_clean();
            $filePath = 'files/reports/' . $filename;
            $size = filesize($filePath);
            header('Content-Description: File Transfer');
            header('Content-Type: application/octet-stream');
            header('Content-Disposition: attachment; filename=' . $filename);
            header('Content-Transfer-Encoding: binary');
            header('Connection: Keep-Alive');
            header('Expires: 0');
            header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
            header('Pragma: public');
            header('Content-Length: ' . $size);
            readfile($filePath);

            $file = new \Cake\Filesystem\File($filePath);
            $file->delete();
            exit();

            return $this->redirect($this->referer());
        }

        $config = [
            'limit' => 2,
            'order' => ['FailedTransactions.id' => 'desc'],
            'contain' => ['Transactions', 'Transactions.Users'],
            'conditions' => $conditions
        ];
        $failedTransactions = $this->Paginator->paginate($this->FailedTransactions->find(), $config);
        $this->set(compact('failedTransactions'));
    }

    public function retry($transactionId) {
        $query = $this->Transactions->find()->where(['Transactions.transaction_id' => $transactionId])->contain(['Users']);
        if ($query->count() <= 0) {
            $this->Flash->error(__("Invalid Transaction Id"));
            return $this->redirect($this->referer());
        }
        $transaction = $query->first();

        $transactionDate = date('Y-m-d', strtotime($transaction->created));
        $transactionAmount = $transaction->amount;
        $agentID = $transaction->user->agent_id;
        $cardNum = $transaction->card_number;

        $data = [
            "HandlerID" => $transaction->mihpayid,
            "TransactionType" => "Card",
            "TransactionID" => $transactionId,
            "TransactionDate" => $transactionDate,
            "Amount" => $transactionAmount,
            "Currency" => "INR",
            "CardType" => "VISA",
            "AgentID" => $agentID,
            "CreditCardNo" => $cardNum
        ];

        $jsonData = json_encode($data);
        require_once(ROOT . DS . 'vendor' . DS . 'aes' . DS . 'AES.php');
        $aes = new \AES($jsonData, ENCRYPTION_KEY, ENCRYPTION_BLOCK_SIZE, ENCRYPTION_MODE);
        $encryptedData = $aes->encrypt();

        $url = ESB_PENDING_URL;
        $ch = curl_init();
        $curlConfig = array(
            CURLOPT_URL => $url,
            CURLOPT_POST => true,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_TIMEOUT => 40,
            CURLOPT_POSTFIELDS => $encryptedData,
            CURLOPT_USERPWD => "payu:payu@123",
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

        if (isset($response->messageCode) && $response->messageCode == 200) {
            $status = $this->Transactions->query()->update()->set(['pending_url_hit' => 1, 'navitor_status' => 2])->where(['transaction_id' => $transactionId])->execute();
            $this->Flash->success(__("Transaction details pushed to ESB Pending Url Successfully!!.."));
        } else if (isset($response->error) && strpos($response->error, 'Transaction already exist') !== false) {
            $status = $this->Transactions->query()->update()->set(['pending_url_hit' => 1, 'navitor_status' => 2])->where(['transaction_id' => $transactionId])->execute();
            $this->Flash->success(__("Transaction details pushed to ESB Pending Url Successfully!!.."));
        } else {
            $this->Flash->error(__("Some error occured, try later"));
        }
        return $this->redirect($this->referer());
    }

    public function login() {
        if ($this->Auth->user('id')) {
            if ($this->Auth->user('type') == '1') {
                return $this->redirect(HTTP_ROOT . 'admin');
            } else if ($this->Auth->user('type') == '2') {
                return $this->redirect(['action' => 'card-register']);
            }
        } else {
            return $this->redirect(HTTP_ROOT);
        }
    }

    public function logout() {
        $this->Auth->logout();
        return $this->redirect(HTTP_ROOT . "login");
    }

}
