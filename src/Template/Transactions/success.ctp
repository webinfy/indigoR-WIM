<div class="clear"></div>
<div class="ad">
    <?php if (!empty($data)) { ?>
        <h1 style="text-align: center;color: green;font-size: 25px;">Thank You. Your transaction status is <?= $data['status'] ?>.</h1>
        <h2 style="text-align: center;color: #2C3A97;font-size: 18px;">Your Transaction ID for this transaction is <?= $data['txnid'] ?>.</h2>
        <h2 style="text-align: center;color: #2C3A97;font-size: 18px;">We have received a payment of Rs. <?= $data['amount'] ?>.</h2>
        <h3 style="text-align: center;color: green;font-size: 17px;"><a href="<?= HTTP_ROOT ?>"> Back to Homepage </a></h3>
    <?php } else if ($error) { ?>
        <h1 style="text-align: center;color: red;font-size: 25px;">Invalid Transaction. Please try again.</h1>
        <h3 style="text-align: center;color: green;font-size: 18px;"><a href="<?= HTTP_ROOT ?>"> Back to Homepage </a></h3>
    <?php } ?>
</div>