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
                <a href="<?php echo HTTP_ROOT; ?>users/logout" class="login">Go Back To Indigo</a>
            <?php } ?>
        </div>
    </div>
</header>
