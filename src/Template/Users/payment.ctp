<div class="clear"></div>
<div class="ad">
    <div class="container" id="tab" style="display:block;">

        <ul class="nav nav-tabs">
            <li class="active"><a data-toggle="tab" href="#rnc">Payment Processing</a></li>
            <!--<li><a data-toggle="tab" href="#re">Recharge</a></li>-->
        </ul>

        <div class="tab-content">
            <div id="rnc" class="tab-pane fade in active">
                <div class="nc">

                    <div class="register-card-data">
                        <h2>Payment Processing</h2>
                        <h3>Personal Details</h3>
                        <div class="left-side">
                            <p><label>Agent Id :</label><span> <?= $agentData['agent_id'] ?> </span><p>
                            <p><label>Email Id :</label><span> <?= $agentData['email'] ?> </span><p>
                        </div>
                        <div class="right-side">
                            <p><label>Name :</label><span> <?php echo $agentData['firstname'] . " " . $agentData['lastname']; ?> </span><p>
                            <p><label>Mobile :</label><span><?= $agentData['mobile'] ?></span><p>
                        </div>
                    </div>
                    <div class="table-responsive col-xs-5" style="margin:0% 10%;">
                        <img src="<?php echo HTTP_ROOT . "img/loading.gif"; ?>" style="margin-left:300px; width:150px;" />


                        <?php
                        $key = KEY;
                        $salt = SALT;
                        $txn = microtime();
                        $firstname = $agentData['firstname'];
                        $lastname = $agentData['lastname'];
                        $mobile = $agentData['mobile'];
                        $email = $agentData['email'];
                        $productInfo = "Recharge";
                        $txn = $transaction->transaction_id;
                        $amount = $transaction->amount;

                        //$hashSequence = "key|txnid|amount|productinfo|firstname|email|udf1|udf2|udf3|udf4|udf5|udf6|udf7|udf8|udf9|udf10";
                        $text = "{$key}|{$txn}|{$amount}|{$productInfo}|{$firstname}|{$email}|||||||||||{$salt}";
                        $output = strtolower(hash("sha512", $text));

                        //pr($data); pr($transaction);
                        ?>

                        <form action='https://test.payu.in/_payment' method='post'>        

                            <input type="hidden" name="key" value="<?= $key ?>" />  
                            <input type="hidden" name="hash" value = <?php echo $output; ?> />
                            <input type="hidden" name="txnid" value="<?php echo $txn; ?>" />

                            <input type="hidden" name="firstname" value="<?= $firstname ?>" />
                            <input type="hidden" name="lastname" value="<?= $lastname ?>" />                                
                            <input type="hidden" name="phone" value="<?= $mobile ?>"/> 
                            <input type="hidden" name="productinfo" value="<?= $productInfo ?>" /> <!--Product Info-->                               
                            <input type="hidden" name="email" value="<?= $email ?>" />
                            <input type="hidden" name="amount" value="<?php echo $amount; ?>" /> <!--Payment Amount-->


                            <!--Callback URLS..... -->
                            <input type="hidden" name="surl" value="<?php echo HTTP_ROOT . 'transactions/success/' . $transaction->id; ?>" />
                            <input type="hidden" name="curl" value="<?php echo HTTP_ROOT . 'transactions/cancel/' . $transaction->id; ?>" />
                            <input type="hidden" name="furl" value="<?php echo HTTP_ROOT . 'transactions/failure/' . $transaction->id; ?>" />


                            <!--Extra Fields For Seamless Payment......... -->
                            <input type="hidden" name="pg" value="CC" />
                            <input type="hidden" name="bankcode" value="CC" />                                   
                            <input type="hidden" name="store_card_token" value="<?= $data['card_token'] ?>" />
                            <input type="hidden" name="ccvv" value="<?= $data['ccvv'] ?>" />                             
                            <input type="hidden" name="user_credentials" value="<?= $key . ":" . $this->request->session()->read('Auth.User.id') ?>" />                         

                        </form>
                    </div>
                </div>
            </div>            
        </div>
    </div>
</div>
<script type="text/javascript">
    $(function () {  // document.ready function...
        setTimeout(function () {
            $('form').submit();
        }, 3000);
    });
</script>

