<div id="re" class="tab-pane fade">               
    <div class="ra">
        <?php
        if (!empty($userCards)) {
            $tnxt = rand(111, 999) . time();
            $email = "soumyadas02009@gmail.com";
            ?>
            <?php echo $this->Form->create('null', array('method' => 'post', 'url' => HTTP_ROOT . 'users/payment', 'onsubmit' => 'return validateForm();', 'class' => 'form-horizontal')); ?>
            <div class="col-sm-12 form-group">
                <label class="control-label col-sm-3 aligen-right">Enter Recharge Amount:</label>
                <div class="col-sm-4">
                    <?= $this->Form->input('amount', ['type' => 'text', 'id' => 'amount', 'div' => FALSE, 'label' => FALSE, 'class' => 'form-control', 'required' => 'required']) ?>
                </div>															
            </div>

            <div class="col-sm-12 form-group">                            
                <?php
                $j = 0;
                if (!empty($userCards)) {
                    foreach ($userCards as $cardInformation) {
                        ?>
                        <div class="col-sm-6 margin-bottom1" style="margin-bottom: 25px;">
                            <?= $this->Form->input('key', ['type' => 'hidden', 'id' => 'key', 'value' => KEY]) ?>
                            <?= $this->Form->input('txnid', ['type' => 'hidden', 'id' => 'txnid', 'value' => $tnxt]) ?>
                            <?= $this->Form->input('card_no', ['type' => 'hidden', 'id' => 'key', 'value' => $cardInformation['card_no']]) ?>
                            <?= $this->Form->input('nameOnCard', ['type' => 'hidden', 'id' => 'key', 'value' => $cardInformation['name_on_card']]) ?>
                            <?= $this->Form->input('email', ['type' => 'hidden', 'id' => 'key', 'value' => $email]) ?>
                            <?= $this->Form->input('hash', ['type' => 'hidden', 'id' => 'hash', 'value' => @$hash]) ?>								
                            <div class="col-sm-2 min-wdth">
                                <?php if (empty($chkApprove[$j])) { ?>
                                    <input type="radio" class="chk_type" name="card_type" id="ctype<?php echo $j; ?>" disabled='disabled' required="" value="<?php echo $cardInformation['card_type']; ?>">
                                <?php } else { ?>
                                    <input type="radio" class="chk_type" name="card_type" id="ctype<?php echo $j; ?>" required="" value="<?php echo $cardInformation['card_type']; ?>">
                                <?php } ?>
                            </div>
                            <div class="col-sm-2">
                                <img src="<?php echo HTTP_ROOT; ?>img/mc.jpg">
                            </div>
                            <div class="col-sm-6">
                                <input type="text" class="form-control" value="<?php echo $cardInformation['card_no']; ?>" disabled id="cnum" >
                                <span><?php echo $cardInformation['name_on_card'] . '&nbsp; &nbsp; &nbsp; &nbsp;' . $cardInformation['expiry_month'] . '-' . $cardInformation['expiry_year']; ?></span>
                            </div>
                            <div class="col-sm-2"><input type="text" class="form-control" placeholder="CVV" id="cnum<?php echo $j; ?>"></div>
                        </div>
                        <?php
                        $j++;
                    }
                }
                ?>  
            </div>
        </div>   
        <div class="form-group col-sm-12 aligen-center">
            <input type="hidden" class="form-control"  id="cards_no" value="<?php echo $j; ?>">
            <?= $this->Form->submit('PAY NOW', ['type' => 'submit', 'name' => 'payment', 'class' => 'btn btn-lg btn-primary']) ?>
        </div>
        <?php echo $this->Form->end(); ?>
    <?php } else { ?>
        <div class="card-number" style="margin-bottom: 20px; text-align: center; color: #FF0000; font-size: 14px;">
            No Card Present. Add New Card to Recharge.
        </div>
    <?php } ?>
</div>
 