<?php

namespace App\Controller\Component;

use Cake\Mailer\Email;
use Cake\Controller\Component;

class CustomComponent extends Component {

    function __construct($prompt = null) {
        
    }

    public function formatMoney($money) {
        return number_format($money, 2);
    }

    public function cardStatus($status) {
        if ($status == 2) {
            return "Declined";
        } else if ($status == 1) {
            return "Active";
        } else if ($status == 0) {
            return "In-Active";
        }
    }

    public function paymentStatus($transaction) {
        if ($transaction->payment_status == 1) {
            return "Success";
        } else if ($transaction->payment_status == 2) {
            return 'Pending';
        } else if ($transaction->payment_status == 3) { //For Status = 3 & 0
            return 'Failure';
        } else {
            return 'Canceled';
        }
    }

    public function navitorStatus($transaction) {
        if ($transaction->unmappedstatus == 'captured') {
            if ($transaction->navitor_status == 1) {
                return "Success";
            } else if ($transaction->navitor_status == 2) {
                return "Pending";
            } else {
                return '--';
            }
        } else {
            return '--';
        }
    }

    public function curlExecute($url, $data) {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 30);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        $result = curl_exec($ch);
        if (curl_errno($ch)) {
            curl_close($ch);
            return FALSE;
        } else {
            curl_close($ch);
            return $result;
        }
    }

    public function file_get_contents_curl($url) {
        $ch = curl_init();

        curl_setopt($ch, CURLOPT_AUTOREFERER, TRUE);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, TRUE);

        $data = curl_exec($ch);
        curl_close($ch);

        return $data;
    }

    function generateAuthToken($id = NULL) {
        if ($id) {
            return md5(uniqid(rand(1111111111, 99999999999)) . time() . $id) . md5(time());
        } else {
            return md5(uniqid(rand(1111111111, 99999999999)) . time()) . md5(time());
        }
    }

    function formatEmail($msg, $arrData) {
        foreach ($arrData as $key => $value) {
            if (strstr($msg, "[" . $key . "]")) {
                $msg = str_replace("[" . $key . "]", $value, $msg);
            }
        }
        if (strstr($msg, "[SITE_NAME]")) {
            $msg = str_replace('[SITE_NAME]', "<a href='" . HTTP_ROOT . "'>" . SITE_NAME . "</a>", $msg);
        }
        if (strstr($msg, "[SUPPORT_EMAIL]")) {
            $msg = str_replace('[SUPPORT_EMAIL]', "<a href='mailto:" . SUPPORT_EMAIL . "'>" . SUPPORT_EMAIL . "</a>", $msg);
        }
        return $msg;
    }

    function uploadFile($tmpName, $name, $path) {
        if ($name) {
            $file = strtolower($name);
            $fileExtention = pathinfo($file, PATHINFO_EXTENSION);
            if (!in_array($fileExtention, ['gif', 'jpg', 'jpeg', 'png', 'bmp', 'doc', 'docx', 'pdf'])) {
                return false;
            } else {
                if (!is_dir($path)) {
                    mkdir($path);
                }
                $fileName = md5(time() . rand(100, 999)) . "." . $fileExtention;
                move_uploaded_file($tmpName, "$path/$fileName");
                return $fileName;
            }
        }
    }

    function sendEmail($to, $from, $subject, $message, $bcc = null, $files = null, $header = 1, $footer = 1) {
        if ($header) {
            $hdr = '<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01//EN">
    <html>
    <head>
    <title>Free4lancer</title>
    </head>
    <body>
    <table width="750" style="font-family:arial helvetica sans-serif" border="0" cellspacing="0" cellpadding="0">
    <tbody>
        <tr>
        <td><table width="750" border="0" cellspacing="0" cellpadding="0">
            <tbody>
            <tr>
                <td style="text-align:center;"><a href="' . HTTP_ROOT . '"><img alt="" src="' . HTTP_ROOT . 'img/logo.png"/></a> </td>
                <td align="right" valign="bottom" style="font-family:arial;color:#0093dd;font-size:20px;padding:0 10px 10px 0">
                    <table border="0" align="right" cellspacing="0" cellpadding="0">
                    <tbody><tr><td height="25"></td></tr></tbody></table>
                </td>
                <td>&nbsp;</td>
            </tr>
            </tbody>
        </table></td>
        </tr>
        <tr> <td bgcolor="#0077b1"><div style="font-size:3px;color:#28a4e2">&nbsp;</div></td></tr>
        <!--<tr><td bgcolor="#b3efae"><div style="font-size:3px;color:#a6d9f3">&nbsp;</div></td></tr>-->
        <tr> <td colspan="3" style="border:1px solid #c6c6c6"><table width="100%" border="0" cellspacing="0" cellpadding="0"> <tbody>
            <tr>
                <td colspan="2" style="padding-left:12px;padding-right:12px;font-family:trebuchet ms,arial;font-size:13px">';
        }
        if ($footer) {

            $ftr = '</td>
            </tr>
            </tbody>
        </table></td>
        </tr>
        <tr>
        <td height="34" bgcolor="#f1f1f1" style="border:solid 1px #c6c6c6;border-top:0px;font-family:arial;font-size:13px;text-align:center"><p>
        <table width="100%" border="0" cellspacing="0" cellpadding="0"><tbody><tr>
    <td style="font:12px Helvetica,sans-serif;color:#7b7b7b;text-align:left; margin-left:10px; display:block"">EMAIL:<a target="_blank" style="text-decoration:none" href="' . SUPPORT_EMAIL . '"><font color="#f67d2c"> ' . SUPPORT_EMAIL . ' </font></a></td>
    <td width="150" style="font:12px Helvetica,sans-serif;color:#7b7b7b">&nbsp;</td>
    <!--
    <td width="70" align="left" style="font:12px Helvetica,sans-serif;color:#7b7b7b;text-transform:uppercase"><strong>Follow Us On</strong></td>
    <td width="26" align="right"><a target="_blank" style="text-decoration:none" href=""><img width="26" height="26" border="0" title="Facebook" style="display:block;color:#ffffff" alt="Facebook" src="' . HTTP_ROOT . '/img/social/facebook.png"></a></td>
    <td width="26" align="right"><a target="_blank" style="text-decoration:none" href=""><img width="26" height="26" border="0" title="Google Plus" style="display:block;color:#ffffff" alt="Google Plus" src="' . HTTP_ROOT . '/img/social/twitter_bird.png"></a></td>
    <td width="26" align="right"><a target="_blank" style="text-decoration:none" href=""><img width="26" height="26" border="0" title="Pinterest" style="display:block;color:#ffffff" alt="Pinterest" src="' . HTTP_ROOT . '/img/social/googleplus.png"></a></td>
    <td width="26" align="right"><a target="_blank" style="text-decoration:none" href=""><img width="26" height="26" border="0" title="YouTube" style="display:block;color:#ffffff" alt="YouTube" src="' . HTTP_ROOT . '/img/social/pinterest.png"></a></td>
    <td width="26" align="right"><a target="_blank" style="text-decoration:none" href=""><img width="26" height="26" border="0" title="Instagram" style="display:block;color:#ffffff" alt="Instagram" src="' . HTTP_ROOT . '/img/social/youtube.png"></a></td>
    -->
    </tr></tbody></table>
        </p></td>
        </tr>
    </tbody>
    </table>
    </body>
    </html>';
        }

        $message = $hdr . $message . $ftr;
        $to = $this->emailText($to);
        $bcc = !empty($bcc) ? $this->emailText($bcc) : 'pradeepta.raddyx@gmail.com';
        $subject = $this->emailText($subject);
        $message = $this->emailText($message);
        $message = str_replace("<script>", "&lt;script&gt;", $message);
        $message = str_replace("</script>", "&lt;/script&gt;", $message);
        $message = str_replace("<SCRIPT>", "&lt;script&gt;", $message);
        $message = str_replace("</SCRIPT>", "&lt;/script&gt;", $message);

        //echo $message;  exit;
        //Send Email by using Cakephp3.x
        $email = new Email('default');
        $email->from([$from => SITE_NAME]);
        if (!empty($files)) {
            $email->attachments($files);
        }
        $email->emailFormat('html');
        $email->template(NULL);
        $email->to($to);
        $email->bcc($bcc);
        $email->subject($subject);
        $email->send($message);
        return true;
//
//        $logFile = fopen("files/temp-email/" . md5(uniqid()) . time() . ".html", "w") or die("Unable to open file!");
//        $txt = "$message  \n";
//        fwrite($logFile, $txt);
//        fclose($logFile);
        //Send Email by core php 
        /*
          $from = "PayuAirline<" . $from . ">";
          $bcc = "pradeepta.raddyx@gmail.com";
          $headers = 'MIME-Version: 1.0' . "\r\n";
          $headers.= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
          $headers.= 'From:' . $from . "\r\n";
          $headers.= 'BCC:' . $bcc . "\r\n";
          //echo $to.$subject.$message;exit;
          if (mail($to, $subject, $message, $headers)) {
          return true;
          } else {
          return false;
          }
         */
    }

    function emailText($value) {
        $value = stripslashes(trim($value));
        $value = str_replace('"', "\"", $value);
        $value = str_replace('"', "\"", $value);
        $value = preg_replace('/[^(\x20-\x7F)\x0A]*/', '', $value);
        return stripslashes($value);
    }

}
