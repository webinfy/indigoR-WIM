<?php $cakeDescription = 'Agent Payment'; ?>
<!DOCTYPE html>
<html>
    <head>
        <title>Agent Payment</title>       
        <?= $this->Html->charset() ?>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <base href="<?= HTTP_ROOT; ?>" target="_self">

        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" />
        <link rel="stylesheet" href="<?php echo HTTP_ROOT; ?>css/style.css" />

        <script> var siteUrl = '<?= HTTP_ROOT ?>';</script>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.4/jquery.min.js"></script>
        <script>window.jQuery || document.write('<script src="js/jquery-2.2.4.min.js"><\/script>')</script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
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
            <div class="breadcrumbs">
                <div class="wrapper">
                    <a href="<?php echo HTTP_ROOT; ?>" class="home">Home</a>
                    <?php if ($this->request->session()->read('Auth.User.id')) { ?>
                        <a href="<?php echo HTTP_ROOT; ?>admin/users/logout" class="login">Logout</a>
                    <?php } ?>
                </div>
            </div>
        </header>
        <?php echo $this->Flash->render();  ?>
        <?= $this->fetch('content') ?>
        <input type="hidden" id="siteUrl" value="<?php echo HTTP_ROOT; ?>" />
        <footer>
            <!-- Footer Content-->
        </footer> 
        <script src="js/masked-input.min.js"></script> 
    </body>
</html>
