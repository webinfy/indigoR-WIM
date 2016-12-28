<?php $cakeDescription = 'Agent Payment'; ?>
<!DOCTYPE html>
<html>
    <head>
        <title><?= SITE_NAME ?> : Agent Dashboard</title>       
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
        <?= $this->element('header') ?>
        <?php //$this->Flash->render();  ?>
        <?= $this->fetch('content') ?>
        <input type="hidden" id="siteUrl" value="<?php echo HTTP_ROOT; ?>" />
        <footer>
            <!-- Footer Content-->
        </footer> 
        <script src="js/masked-input.min.js"></script> 
        <?php if ($this->request->session()->read('Auth.User.id') && $this->request->session()->read('Auth.User.type') == 2) { ?>
            <script type="text/javascript">
            /*Disable Back Button*/
            history.pushState(null, null, document.URL);
            window.addEventListener('popstate', function () {
                console.log(document.URL);
                history.pushState(null, null, document.URL);
            });
            </script>   
            <script type="text/javascript">
                /*Logout After 3 min of Inactivity*/
                var idleTime = 0;
                $(document).ready(function () {
                    //Increment the idle time counter every minute.
                    var idleInterval = setInterval(timerIncrement, 60000); // 1 minute

                    //Zero the idle timer on mouse movement.
                    $(this).mousemove(function (e) {
                        idleTime = 0;
                    });
                    $(this).keypress(function (e) {
                        idleTime = 0;
                    });
                });

                function timerIncrement() {
                    idleTime = idleTime + 1;
                    if (idleTime >= 3) { // 3 minutes
                        location.href = '<?= HTTP_ROOT . 'logout'; ?>';
                    }
                }
            </script>   
        <?php } ?>
    </body>
</html>
