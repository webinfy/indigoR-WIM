<?php

namespace Cake\View\Helper;

use Cake\View\Helper;
use Cake\Datasource\ConnectionManager;

class CustomHelper extends Helper {

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

    public function dateDisplay($datetime) {
        if ($datetime != "" && $datetime != "NULL" && $datetime != "0000-00-00 00:00:00") {
            return date("M d, Y", strtotime($datetime));
        } else {
            return false;
        }
    }

    public function dateTimeDisplay($datetime) {
        if ($datetime != "" && $datetime != "NULL" && $datetime != "0000-00-00 00:00:00") {
            return date("M d, Y h:i A", strtotime($datetime));
        } else {
            return false;
        }
    }

}
