<?php

namespace App\Shell;

use Cake\Console\Shell;

//use Cake\Mailer\Email;

require_once(ROOT . DS . 'vendor' . DS . 'aes' . DS . 'AES.php');

class TransactionShell extends Shell {

    public function main() {
        $this->out('Jay Jagannath.........');
    }

    /*
     * Dev : Pradeepta Khatoi
     * Date : 15 Nov 2016
     * Desc:  Check Failied Transaction
     */

    public function chekFailedTransactions() {

        //mail('pradeepta20@gmail.com', 'Cron Test', 'Jay Jagannath');

        $this->loadModel('Transactions');
        $this->loadModel('FailedTransactions');

        $conditions = ['Transactions.payment_status IN' => [1, 2], 'Transactions.unmappedstatus IN' => ['auth', 'pending', 'bounced', 'dropped']];
        $transactionList = $this->Transactions->find('list', ['keyField' => 'transaction_id', 'valueField' => 'transaction_id'])->where($conditions)->order(['Transactions.id' => 'DESC'])->limit(1000)->toArray();
        if (!empty($transactionList)) {
            $var1 = implode('|', $transactionList);
            $key = KEY;
            $salt = SALT;
            $command = "verify_payment";
            $hash_str = $key . '|' . $command . '|' . $var1 . '|' . $salt;
            $hash = strtolower(hash('sha512', $hash_str));
            $r = ['key' => $key, 'hash' => $hash, 'var1' => $var1, 'command' => $command];
            $qs = http_build_query($r);
            $apiUrl = SAVE_CARD_URL;
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $apiUrl);
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $qs);
            curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 30);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
            $jsonData = curl_exec($ch);
            if (curl_errno($ch)) {
                $sad = curl_error($ch);
                throw new \Exception($sad);
            }
            curl_close($ch);

            $data = json_decode($jsonData, TRUE);
            if ($data['status'] == 1) {
                $transactionDetails = $data['transaction_details'];
                foreach ($transactionDetails as $transactionDetail) {


                    if ($transactionDetail['status'] == 'success') {

                        $transactionId = $transactionDetail['txnid'];

                        $status = $this->Transactions->query()->update()->set(['unmappedstatus' => $transactionDetail['unmappedstatus']])->where(['transaction_id' => $transactionId])->execute();

                        if ($transactionDetail['unmappedstatus'] == 'captured') {

                            $transactionDate = date('Y-m-d', strtotime($transactionDetail['addedon']));
                            $transactionAmount = $transactionDetail['transaction_amount'];
                            $cardNum = $transactionDetail['card_no'];
                            $status = $this->Transactions->query()->update()->set(['payment_status' => 1, 'unmappedstatus' => 'captured'])->where(['transaction_id' => $transactionId])->execute();

                            if ($status) {
                                $transaction = $this->Transactions->find()->where(['Transactions.transaction_id' => $transactionId])->contain(['Users'])->first();

                                $failedTransaction = $this->FailedTransactions->newEntity();
                                $failedTransaction->transaction_id = $transaction->id;
                                $failedTransaction->is_recovered = 1;
                                $failedTransaction->recovered_at = date('Y-m-d H:i:s');
                                $this->FailedTransactions->save($failedTransaction);

                                $agentID = $transaction->user->agent_id;

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
                                if ($response->messageCode == 200) {
                                    $status = $this->Transactions->query()->update()->set(['pending_url_hit' => 1, 'navitor_status' => 2])->where(['transaction_id' => $transactionId])->execute();
                                }
                            }
                        }
                    }
                }
            }
        }

        $this->out('Cron Executed!!');
    }

}
