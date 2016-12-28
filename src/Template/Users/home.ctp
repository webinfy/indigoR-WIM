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

        <header>
            <div class="logo-part">
                <div class="wrapper">
                    <a href="<?php echo HTTP_ROOT; ?>"><img src="<?php echo HTTP_ROOT; ?>img/logo.png" alt="" class="name"/></a>
                    <a href="javascript:void(0);"><img src="<?php echo HTTP_ROOT; ?>img/logo-icon.png" alt="" class="logo"/></a>
                </div>
            </div>           
        </header>        

        <?= $this->fetch('content') ?>

        <div class="container">     
            <div class="span12" style="position: relative; width: 400px; margin: auto;">   
                <h1 style="margin-top: 250px; color: #2C3A97;">Welcome to <?= SITE_NAME ?></h1>
            </div> 
        </div>


        <footer>
            <!--Footer Content-->
        </footer>
    </body>
</html>
