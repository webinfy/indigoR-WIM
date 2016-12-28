<?php
//echo "<pre>";
$data = json_decode($cardDetails);
$cardInformations = json_decode(json_encode($data), true);
//print_r($cardInformations);
//exit;
?>

<div class="register-card-data" style="position:relative;top:-40px;">
    <h2><div class="wrapper">Register cards<span style="float: right;" class="top_links"><a href="<?php echo HTTP_ROOT; ?>users/card-register">Recharge Now</a>&nbsp;&nbsp; OR&nbsp;&nbsp; <a href="<?php echo HTTP_ROOT; ?>users/card-register">Register new card</a></span></div></h2>
    <div class="wrapper">
        <h3>Personal Details</h3>
        <div class="left-side">
            <p><label>Agent Id :</label><span> <?php echo $this->request->session()->read('Auth.User.user_id'); ?></span><p>
            <p><label>Email Id :</label><span> <?php echo $this->request->session()->read('Auth.User.email'); ?></span><p>
        </div>
        <div class="right-side">
            <p><label>Name :</label><span> <?php echo $this->request->session()->read('Auth.User.username'); ?></span><p>
            <p><label>Mobile :</label><span>9895756875</span><p>
        </div>
    </div>
</div>
<div class="clear"></div>
<div class="wrapper">
    <?php if (!empty($cardInformations['user_cards'])) { ?>
        <!--    <h4 class="header4">Congratulations Card Registered Successfully</h4>-->
        <h5 class="header5"><?php echo $this->Flash->render(); ?></h5>

        <?php
        foreach ($cardInformations['user_cards'] as $cardInformation) {
            //pr($cardInformation);
            ?>

            <div class="add-visa-panel">
                <div class="visa-title"><span><?php echo $cardInformation['card_brand']; ?></span> 

                            <!--<span style="float: right;margin-left: 10px;"><?php // echo $this->Html->link('Edit Card', ['controller' => 'Users', 'action' => 'editCard', $cardInformation['card_token']]);  ?></span>-->
                    <span class="remove_card"><?php echo $this->Html->link('Remove Card', ['controller' => 'Users', 'action' => 'deleteCard', $cardInformation['card_token']], ['confirm' => __('Are you sure you want to remove this card?')]); ?></span>


                    <!--<button>Remove Card</button>-->
                </div>

                <div class="card-number" style="margin-bottom: 20px;">
					
                    <?php if ($cardInformation['card_brand'] == 'MASTERCARD') { ?>
                        <img style="width: 10%;margin-bottom: 10px; float: left;" src = "<?php echo HTTP_ROOT; ?>img/mc.jpg" />
                        
                    <?php } else if ($cardInformation['card_brand'] == 'MAESTROCARD') { ?>
                        <img src = "<?php echo HTTP_ROOT; ?>img/maestro.jpg" />
                    <?php } else if ($cardInformation['card_brand'] == 'VISA') { ?>
                        <img src = "<?php echo HTTP_ROOT; ?>img/visa-icon.png" />
                    <?php } else if ($cardInformation['card_brand'] == 'RUPAYCARD') { ?>                        
                        <img src = "<?php echo HTTP_ROOT; ?>img/rupay.jpg" />                   
                    <?php } ?>
                    <span><b>Card no: </b><?php echo $cardInformation['card_no'];?></span>
					<span><b>Card Name: </b><?php echo $cardInformation['name_on_card'];?></span>
					<span><b>Exp Date: </b><?php echo $cardInformation['expiry_month'].'-'.$cardInformation['expiry_year'];?></span>
					
					
					</span>
                        <br clear="all" />
                </div>
            </div>

        <?php } //exit;    ?>


        <br><br>
        <div style="position: relative;left: 20%; width: 60%; margin-top:9%;margin-bottom:20%; display:none;">
            <button class="btn btn-lg btn-primary" style="position:relative;float:left;"onclick="location.href = '#';">Recharge Now</button>
            <button class="btn btn-lg btn-primary" style="position:relative;float:right;"onclick="location.href = '#'">Logout</button>
        </div>
    <?php } else { ?>
        <span style="color:red;text-align: center;">No Card present.</span>
    <?php } ?>
</div>