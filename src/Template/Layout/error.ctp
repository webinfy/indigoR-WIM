<?php
$cakeDescription = 'agentpayment';
?>
<!DOCTYPE html>
<html>
    <head>
        <title>Agent Payment</title>       
        <?= $this->Html->charset() ?>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <base href="<?= HTTP_ROOT; ?>" target="">

        <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" />
        <link rel="stylesheet" href="<?php echo HTTP_ROOT; ?>css/style.css" />

        <script> var siteUrl = '<?= HTTP_ROOT ?>';</script>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.4/jquery.min.js"></script>
        <script>window.jQuery || document.write('<script src="js/jquery-2.2.4.min.js"><\/script>')</script>
        <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
        <script src="<?php echo HTTP_ROOT; ?>js/common.js"></script>     
    </head>
    <body>
        <?= $this->element('header') ?>       
        <?= $this->fetch('content') ?>
        <input type="hidden" id="siteUrl" value="<?php echo HTTP_ROOT; ?>" />
        <footer>
            <!-- Footer Content-->
        </footer>  
    </body>
</html>
