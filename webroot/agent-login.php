<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);

include 'AES.php';

$data = [
    'token' => '12DDF445SHHHS33',
    'agent_id' => '11111111',
    'username' => 'indigo',
    'password' => '9W@qTuML!7<#=3l',
    'surl' => 'https://middleware.goindigo.in/uat/api/pendingURL/payu',
    'furl' => 'https://middleware.goindigo.in/uat/api/FailureURL/payu',
    'rurl' => 'https://book.goindigo.in/'
];
$jsonData = json_encode($data);

$aes = new AES($jsonData, 'AGVYP34HDSLSNRB5', '128', "cbc");
$encryptedData = $aes->encrypt();


$ch = curl_init();
$url = "https://testindigo.payu.in:5004/agent-authentication";
$curlConfig = array(
    CURLOPT_URL => $url,
    CURLOPT_POST => true,
    CURLOPT_CONNECTTIMEOUT => 30,
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_POSTFIELDS => $encryptedData,
    CURLOPT_HTTPHEADER => array('Content-Type:application/json')
);
curl_setopt_array($ch, $curlConfig);
$result = curl_exec($ch);
if (curl_errno($ch)) {
    echo $ch;
}
curl_close($ch);


$response = json_decode($result, true);

if (!empty($response['status']) && $response['status'] == 'success') {
    header("Location: " . $response['data']['url']);
    die();
} else {
    print_r($response);
}
exit;
?>
