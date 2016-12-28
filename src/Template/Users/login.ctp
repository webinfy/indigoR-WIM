<div class="clear"></div>
<div class="container">
    <?php echo $this->Flash->render(); ?>
    <div class="card card-container">
        <img  class="img-rounded" alt="Cinque Terre"  src="<?php echo HTTP_ROOT; ?>img/login.png">
        <p id="profile-name" class="profile-name-card"></p>
        <?php echo $this->Form->create("User", array('data-toggle' => "validator", 'class' => 'form-signin')) ?>               
        <span id="reauth-email" class="reauth-email"></span>

        <div class="form-group has-feedback">
            <?= $this->Form->input('email', ['type' => 'email', 'label' => false, 'placeholder' => 'Email', 'class' => 'form-control', 'required' => 'required', 'sutocomplete'=>'off']) ?>
            <div class="help-block with-errors"></div>
        </div>

        <div class="form-group has-feedback">
            <?= $this->Form->input('password', ['type' => 'password', 'label' => false, 'escape' => false, 'placeholder' => 'Password', 'class' => 'form-control', 'required' => 'required']) ?>
            <div class="help-block with-errors"></div>
        </div>
        <!--
        <div id="remember" class="checkbox">
            <label>
                <input type="checkbox" value="remember-me"> Remember me
            </label>
        </div>
        -->
        <?= $this->Form->submit('Sign In', ['type' => 'submit', 'class' => 'login-btn btn-lg btn-primary btn-block signin']) ?>

        <?php echo $this->Form->end(); ?>
        <div style="color:white;">
            <a href="#" class="forget-pass">Forgot the password?</a>
        </div>
    </div>
</div>