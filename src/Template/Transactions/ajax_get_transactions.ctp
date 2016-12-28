<?php

$html = $paging = $counter = "";
if ($transactions->count() > 0) {

    $i = 1;
    foreach ($transactions as $transaction) {

        $created = date("M d, Y", strtotime($transaction->created));
        $paymentStatus = $this->Custom->paymentStatus($transaction);
        $navitorStatus = $this->Custom->navitorStatus($transaction);
        $unmappedstatus = !empty($transaction->unmappedstatus) ? $transaction->unmappedstatus : '--';
        $amount = $this->Custom->formatMoney($transaction->amount);

        $no = ($page - 1) * $limit + $i;
        $html .= <<<HTML
        <tr>
            <td>{$no}</td>
            <td style="text-align: center;">{$created}</td>
            <td>{$transaction->transaction_id}</td>
            <td style='width:150px;text-align:right;'><div>Rs.{$amount}</td>
            <td>{$transaction->card_number}</td>
            <td style="text-align: center; text-transform:capitalize;">{$unmappedstatus}</td>
            <!--<td style="text-align: center;">{$paymentStatus}</td>-->
            <td style="text-align: center;">{$navitorStatus}</td>
        </tr>
HTML;
        $i++;
    }

    if ($this->Paginator->numbers()) {
        $paging .= $this->Paginator->prev('< ' . __('previous'));
        $paging .= $this->Paginator->numbers();
        $paging .= $this->Paginator->next(__('next') . ' >');
    }

    $counter = $this->Paginator->counter('Showing {{start}} to {{end}} of {{count}} entries');
} else {
    $html = "<tr><td colspan='8' class='nodata aligen-center'>No transaction found.</td></tr>";
}
echo json_encode(['status' => 'success', 'html' => $html, 'paging' => $paging, 'counter' => $counter]);
?>




