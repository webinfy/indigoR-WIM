<style>
    /*    div.message {
            position: relative !important;
            left: 0px !important;
            top: 0px !important;
        }*/
</style>
<div class="clear"></div>
<div class="ad">
    <div class="container" id="tab" style="display:block;">

        <ul class="nav nav-tabs">
            <li id="ranc"><a data-toggle="tab" href="#rnc">Register New Card</a></li>
            <li id="recards"><a data-toggle="tab" href="#rcards">Registered Cards</a></li>
            <li id="recharge"  class="active"><a data-toggle="tab" href="#re">Make a Payment</a></li>
            <li id="trans"><a data-toggle="tab" href="#transactions">Transaction History</a></li>
        </ul>

        <div class="tab-content">

            <?php echo $this->Flash->render(); ?>

            <!--Register New Card Start-->
            <div id="rnc" class="tab-pane fade ">
                <div class="nc">

                    <!--
                    <div class="register-card-data">
                        <h2>Card Registration</h2>
                        <h3>Personal Details</h3>
                        <div class="left-side">
                            <p><label>Agent Id :</label><span> <?php echo $agentData['agent_id']; ?></span><p>
                            <p><label>Email Id :</label><span> <?php echo $agentData['email']; ?></span><p>
                        </div>
                        <div class="right-side">
                            <p><label>Name :</label><span> <?php echo $agentData['firstname'] . " " . $agentData['lastname']; ?></span><p>
                            <p><label>Mobile :</label><span><?php echo $agentData['mobile']; ?></span><p>
                        </div>
                    </div>
                    -->                    

                    <div class="table-responsive col-xs-12 credit-card-details" style="margin-top: 20px;" >          
                        <?php echo $this->Form->create('User', ['method' => 'post', 'type' => 'file']); ?>
                        <input name="cardName" id="cardName" value="My_card" type="hidden">  
                        <table class="table table-borderless" cellspacing="0" cellpadding="0">
                            <thead><h3 class="header2">Enter Credit Card Details</h3></thead>
                            <tbody> 
                                <tr>
                                    <td colspan="10" style="border: none !important;">                                     
                                        <?php if (isset($_GET['status']) && $_GET['status'] == 'success') { ?>
                                            <div class="message" style="position: relative !important; left: 0; top: 0;">
                                                <?php // echo $this->Flash->render(); ?>
                                                Your card is registered successfully, you will be able to make payment once your card details are approved by Admin
                                            </div>
                                        <?php } ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <table cellspacing="0" cellpadding="0">
                                            <tbody>   
                                                <tr>
                                                    <td class="col-md-1" style="padding: 10px; width: 20%;">Credit Card No</td>
                                                    <td class="col-md-1" style="padding: 10px; width: 30%;">                            
                                                        <?= $this->Form->input('cardNo', ['type' => 'text', 'id' => 'sel1', 'onblur' => 'checkCard(this)', 'label' => false, 'placeholder' => 'Enter Card No.', 'id' => 'cnum', 'class' => 'form-control number-only', 'required' => true, 'maxlength' => 20, 'data-masked-input' => '9999 9999 9999 9999', 'autocomplete' => 'off']) ?>                                            
                                                        <span id="cardNoMsg" style=""></span>
                                                    </td>
                                                    <td class="col-md-1" style="padding: 10px; width: 20%;">Name on Card</td>
                                                    <td class="col-md-1" style="padding: 10px; width: 30%;">
                                                        <?= $this->Form->input('nameOnCard', ['type' => 'text', 'label' => false, 'placeholder' => "Enter Card Holder's Name", 'id' => 'cname', 'class' => 'form-control', 'required' => 'required']) ?>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class="col-md-1" style="padding: 10px;">Issued Bank Name</td>
                                                    <td class="col-md-1" style="padding: 10px;">                            
                                                        <?= $this->Form->input('bank_name', ['type' => 'text', 'id' => 'bank_name', 'label' => false, 'placeholder' => 'Issued Bank Name', 'class' => 'form-control', 'required' => true]) ?>                                            
                                                    </td>
                                                    <td class="col-md-1" style="padding: 10px;">Expiry Date</td>
                                                    <td class="col-md-1" style="padding: 10px;">
                                                        <div>	
                                                            <div class="fieldBlock">
                                                                <select name="cardExpMon" class="form-control spacing-right" required="required" >
                                                                    <option value=''>Month</option>                                                                   
                                                                    <option value="01">Jan</option>
                                                                    <option value="02">Feb</option>
                                                                    <option value="03">Mar</option>
                                                                    <option value="04">Apr</option>
                                                                    <option value="05">May</option>
                                                                    <option value="06">June</option>
                                                                    <option value="07">July</option>
                                                                    <option value="08">Aug</option>
                                                                    <option value="09">Sep</option>
                                                                    <option value="10">Oct</option>
                                                                    <option value="11">Nov</option>
                                                                    <option value="12">Dec</option>
                                                                </select> 
                                                                <?php //echo $this->Form->input('cardExpMon', ['type' => 'text', 'label' => false, 'placeholder' => "Month", 'maxlength' => 2, 'size' => '25', 'id' => 'month', 'class' => 'form-control number-only spacing-right', 'required' => true]) ?>
                                                            </div>
                                                            <div class="fieldBlock">
                                                                <select name="cardExpYr" class="form-control" required="required" >
                                                                    <option value=''>Year</option>
                                                                    <?php
                                                                    for ($i = date('Y'); $i <= date('Y') + 10; $i++) {
                                                                        echo '<option value="' . $i . '">' . $i . '</option>';
                                                                    }
                                                                    ?>
                                                                </select> 
                                                                <?php //echo  $this->Form->input('cardExpYr', ['type' => 'text', 'label' => false, 'placeholder' => "Year", 'maxlength' => 4, 'size' => '25', 'id' => 'year', 'class' => 'form-control number-only', 'required' => true]) ?>
                                                            </div>
                                                        </div>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class="col-md-1" style="padding: 10px;">Card Type</td>
                                                    <td class="col-md-1" style="padding: 10px;">                                       
                                                        <?= $this->Form->input('card_type', ['type' => 'select', 'id' => 'card_type', 'label' => false, 'escape' => false, 'options' => ['VISA' => 'VISA', 'MASTER' => 'MASTER', 'MAESTRO' => 'MAESTRO', 'AMEX' => 'AMEX', 'RUPAY' => 'RUPAY'], 'class' => 'form-control', 'required' => 'required']) ?>
                                                        <?= $this->Form->input('cardName', ['type' => 'hidden', 'id' => 'cardName', 'value' => "My_card"]) ?>
                                                    </td>
                                                    <td class="col-md-1" style="padding: 10px;">Mode</td>
                                                    <td class="col-md-1" style="padding: 10px;">                                                        
                                                        <div class="fieldBlock">
                                                            <?= $this->Form->input('cardMode', ['type' => 'select', 'id' => 'cardmode', 'label' => false, 'escape' => false, 'options' => ['CC' => 'CC', 'DC' => 'DC'], 'class' => 'form-control', 'required' => TRUE]) ?>
                                                        </div>                                           
                                                    </td>
                                                </tr>   
                                                <tr>
                                                    <td class="col-md-1" style="padding: 10px;"><a href="<?= HTTP_ROOT . "users/downloadMandateFormSpecimenCopy" ?>">Download Mandate Form</a></td>
                                                    <td class="col-md-1" style="padding: 10px;"><a href="<?= HTTP_ROOT . "users/downloadMandateForm" ?>">Specimen Copy of Mandate Form</a></td>
                                                    <td class="col-md-1" style="padding: 10px;">Upload Copy of Mandate Form</a></td>
                                                    <td class="col-md-1" style="padding: 10px;">                                       
                                                        <?= $this->Form->input('mandate_form_file', ['type' => 'file', 'id' => 'mandate_form', 'label' => false, 'class' => 'form-controlXX', 'required' => TRUE]) ?>
                                                    </td>
                                                </tr>  
                                            </tbody>   
                                        </table>   
                                    </td>   
                                    <!--
                                    <td>
                                        <table cellspacing="0" cellpadding="0">
                                            <tbody>                                               
                                                <tr>
                                                    <td class="col-md-1" style="padding: 10px;">Login ID</td>
                                                    <td class="col-md-1" style="padding: 10px;">                            
                                    <?= $this->Form->input('login_id', ['type' => 'text', 'id' => 'login_id', 'label' => false, 'placeholder' => 'Login Id.', 'class' => 'form-control', 'required' => true]) ?>                                            
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class="col-md-1" style="padding: 10px;">IndiGo Agency Id</td>
                                                    <td class="col-md-1" style="padding: 10px;">                            
                                    <?= $this->Form->input('agency_id', ['type' => 'text', 'id' => 'agency_id', 'label' => false, 'placeholder' => 'IndiGo Agency Id', 'class' => 'form-control', 'required' => true]) ?>                                            
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class="col-md-1" style="padding: 10px;">Mail ID</td>
                                                    <td class="col-md-1" style="padding: 10px;">                            
                                    <?= $this->Form->input('email', ['type' => 'email', 'id' => 'email', 'label' => false, 'placeholder' => 'Email.', 'class' => 'form-control']) ?>                                            
                                                    </td>
                                                </tr> 
                                                 <tr>
                                                    <td class="col-md-1" style="padding: 10px;">Scan copy of credit card</td>
                                                    <td class="col-md-1" style="padding: 10px;">                                       
                                    <?= $this->Form->input('scanned_credit_card_file', ['type' => 'file', 'id' => 'scanned_credit_card', 'label' => false, 'class' => 'form-controlXX', 'required' => TRUE]) ?>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class="col-md-1" style="padding: 10px;">Document 3 : </td>
                                                    <td class="col-md-1" style="padding: 10px;">                                       
                                    <?= $this->Form->input('document3_file', ['type' => 'file', 'id' => 'document3', 'label' => false, 'class' => 'form-controlXX', 'required' => TRUE]) ?>
                                                    </td>
                                                </tr>                                                                                             
                                            </tbody>   
                                        </table>   
                                    </td>
                                    -->  
                                </tr>

                                <tr>
                                    <td align="center" colspan="2">
                                        <?= $this->Form->submit('Register', ['type' => 'submit', 'class' => 'btn btn-primary']) ?>
                                    </td>
                                </tr>


                            </tbody>
                        </table>
                        <?php echo $this->Form->end(); ?>
                    </div>
                </div>
            </div> 
            <!--Register New Card End-->

            <!--Card Listing Start-->
            <div id="rcards" class="tab-pane fade">
                <div class="ra"> 
                    <table class="reg-cards table table-striped table-hover">
                        <thead>
                            <tr>
                                <th class="border-right-1 head-th">Type</th>
                                <th class="border-right-1 head-th">Card No.</th>
                                <th class="border-right-1 head-th">Name on Card</th>
                                <th class="border-right-1 head-th">Exp. Dt.</th>
                                <th class="border-right-1 head-th">Status</th>
                                <th class="border-right-1 head-th">&nbsp;</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $i = 0;
                            if (!empty($userCards)) {
                                foreach ($userCards as $cardInformation) {
                                    if (!empty($cardDetails[$i])) {
                                        ?>
                                        <tr>
                                            <td class="border-right-1"><?php echo $cardInformation['card_brand']; ?></td>
                                            <td class="border-right-1"><?php echo $cardInformation['card_no']; ?></td>
                                            <td class="border-right-1"><?php echo $cardInformation['name_on_card']; ?></td>
                                            <td class="border-right-1"><?php echo $cardInformation['expiry_month'] . '-' . $cardInformation['expiry_year']; ?></td>
                                            <td class="border-right-1"><?= $this->Custom->cardStatus($cardDetails[$i]['is_approve']); ?></td>
                                            <td class="border-right-1" style="text-align: center;">
                                                <span class="remove_card" style="margin: 0 5px;"> <a href="javascript:;" data-toggle="modal" data-target="#myModal-<?= $cardInformation['card_token'] ?>"> View </a>  </span>
                                                <!--<span class="remove_card"><?php echo $this->Html->link('Remove Card', ['controller' => 'Users', 'action' => 'deleteCard', $cardInformation['card_token']], ['confirm' => __('Are you sure you want to remove this card?')]); ?></span>-->
                                                <?php if ($cardDetails[$i]['is_enabled'] == 1) { ?>                                               
                                                    <span class="remove_card" style="margin: 0 5px;"> <a onclick="return confirm('Are you sure you want to disable this card ?');" title="Click to Disable" href="<?= HTTP_ROOT . "users/disable/" . $cardInformation['card_token'] ?>"> Disable </a>  </span>
                                                <?php } else { ?>
                                                    <span class="remove_card" style="margin: 0 5px;"> <a onclick="return confirm('Are you sure you want to enable this card ?');" style="background: red !important;" title="Click to Enable" href="<?= HTTP_ROOT . "users/enable/" . $cardInformation['card_token'] ?>"> Enable </a> </span>
                                                <?php } ?>

                                                <!--Popup Code-->
                                                <!-- Modal -->
                                                <div id="myModal-<?= $cardInformation['card_token'] ?>" class="modal fade" role="dialog">
                                                    <div class="modal-dialog">
                                                        <!-- Modal content-->
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                                <h4 class="modal-title">Card Details</h4>
                                                            </div>
                                                            <div class="modal-body">
                                                                <div class="row" style=""> 
                                                                    <table align='center' style="">

                                                                        <tr>
                                                                            <td style="padding: 10px; text-align: left;"> Name on Card </td>
                                                                            <td style="padding: 10px; text-align: left;"> : <?= $cardInformation['name_on_card'] ?></td>
                                                                        </tr>
                                                                        <!--
                                                                        <tr>
                                                                            <td  style="padding: 10px; width: 30%; text-align: left;">Login Id </td>
                                                                            <td style="padding: 10px; text-align: left;"> : <?= $cardDetails[$i]['login_id'] ?></td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td  style="padding: 10px; width: 30%; text-align: left;"> Agency Id</td>
                                                                            <td style="padding: 10px; text-align: left;" > :<?= $cardDetails[$i]['agency_id'] ?></td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td style="padding: 10px; width: 30%; text-align: left;">  Email </td>
                                                                            <td style="padding: 10px; text-align: left;" > : <?= $cardDetails[$i]['email'] ?></td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td  style="padding: 10px; width: 30%; text-align: left;"> Scanned Credit Card </td>
                                                                            <td style="padding: 10px; text-align: left;"> :  <?php if ($cardDetails[$i]['scanned_credit_card']) { ?> <a target="_blank" href="<?= HTTP_ROOT . SCANNED_CREDIT_CARD . $cardDetails[$i]['scanned_credit_card']; ?>">Download</a> <?php } else { ?> Not Available <?php } ?> </td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td  style="padding: 10px; width: 30%; text-align: left;">Document3 </td>
                                                                            <td style="padding: 10px; text-align: left;" > : <?php if ($cardDetails[$i]['document3']) { ?> <a target="_blank" href="<?= HTTP_ROOT . DOCUMENT3 . $cardDetails[$i]['document3']; ?>">Download</a> <?php } else { ?> Not Available <?php } ?> </td>
                                                                        </tr>
                                                                        -->                                                                
                                                                        <tr>
                                                                            <td style="padding: 10px; text-align: left;"> Mandate Form </td>
                                                                            <td style="padding: 10px; text-align: left;" > : <?php if ($cardDetails[$i]['mandate_form']) { ?> <a target="_blank" href="<?= HTTP_ROOT . MANDATE_FORM . $cardDetails[$i]['mandate_form']; ?>">Download</a> <?php } else { ?> Not Available <?php } ?> </td>
                                                                        </tr>                                                                
                                                                        <tr>
                                                                            <td  style="padding: 10px; text-align: left;"> Bank name </td>
                                                                            <td style="padding: 10px; text-align: left;" > :<?= $cardDetails[$i]['bank_name'] ?></td>
                                                                        </tr>


                                                                    </table>                                                                               
                                                                </div>   
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <!--Popup Code End-->

                                            </td>                                   
                                        </tr>

                                        <?php
                                        $i++;
                                    }
                                }
                            } else {
                                ?>
                                <tr>
                                    <td colspan="10">
                                        <div class="card-number" style="margin-bottom: 20px; text-align: center; color: #FF0000; font-size: 14px;">
                                            No Card Present.
                                        </div>
                                    </td>
                                </tr>
                            <?php } ?>


                            <?php /* ?>
                              <div class="add-visa-panel">
                              <div class="visa-title"><span><?php echo $cardInformation['card_brand']; ?></span>
                              <!--<span class="remove_card" style="float: right;margin-left: 10px;"><?php echo $this->Html->link('Edit Card', ['controller' => 'Users', 'action' => 'editCard', $cardInformation['card_token']]); ?></span>-->
                              <span class="remove_card"><?php echo $this->Html->link('Remove Card', ['controller' => 'Users', 'action' => 'deleteCard', $cardInformation['card_token']], ['confirm' => __('Are you sure you want to remove this card?')]); ?></span>
                              <span class="remove_card" style="margin: 0 5px;">
                              <a href="javascript:;" data-toggle="modal" data-target="#myModal-<?= $cardInformation['card_token'] ?>">
                              View
                              </a>
                              </span>
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
                              <span><b>Card No. </b> <br/> <?php echo $cardInformation['card_no']; ?></span>
                              <span><b>Name on Card </b> <br/><?php echo $cardInformation['name_on_card']; ?></span>
                              <span><b>Exp. Date </b> <br/> <?php echo $cardInformation['expiry_month'] . '-' . $cardInformation['expiry_year']; ?></span>
                              <span><b>Status </b> <br/> <?= $this->Custom->cardStatus($cardDetails[$i]['is_approve']); ?></span>
                              <br clear="all" />
                              </div>

                              </div>

                              <?php */ ?>

                        </tbody>
                    </table> 
                </div>
            </div>
            <!--Card Listing End-->

            <!--Make Payment Start-->
            <div id="re" class="tab-pane fade in active">               
                <div class="ra">
                    <?php if (!empty($userCards)) { ?>

                        <?php echo $this->Form->create('null', array('method' => 'post', 'url' => HTTP_ROOT . 'users/payment', 'onsubmit' => 'return validateForm();', 'class' => 'form-horizontal')); ?>

                        <div class="col-sm-12 form-group" style="margin: 40px;">
                            <label class="control-label col-sm-3 aligen-right">Enter Payment Amount:</label>
                            <div class="col-sm-4">
                                <?= $this->Form->input('amount', ['type' => 'text', 'id' => 'amount', 'div' => FALSE, 'label' => FALSE, 'class' => 'form-control decimal', 'required' => 'required', 'maxlength' => 18]) ?>
                            </div>															
                        </div>

                        <div class="col-sm-12 form-group">                            
                            <?php
                            $j = 0;
                            if (!empty($userCards)) {
                                foreach ($userCards as $cardInformation) {
                                    if (!empty($cardDetails[$j])) {
                                        ?>
                                        <div class="col-sm-6 margin-bottom1" style="margin-bottom: 25px;">
                                            <?php echo $this->Form->input('card_token', ['type' => 'hidden', 'id' => 'card_token', 'class' => "card-input card-input-{$j}", 'disabled' => true, 'value' => $cardInformation['card_token']]) ?>
                                            <?php echo $this->Form->input('card_no', ['type' => 'hidden', 'id' => 'card_no', 'class' => "card-input card-input-{$j}", 'disabled' => true, 'value' => $cardInformation['card_no']]) ?>
                                            <?php echo $this->Form->input('ccexpmon', ['type' => 'hidden', 'id' => 'ccexpmon', 'class' => "card-input card-input-{$j}", 'disabled' => true, 'value' => $cardInformation['expiry_month']]) ?>
                                            <?php echo $this->Form->input('ccexpyr', ['type' => 'hidden', 'id' => 'ccexpyr', 'class' => "card-input card-input-{$j}", 'disabled' => true, 'value' => $cardInformation['expiry_year']]) ?>
                                            <?php echo $this->Form->input('ccname', ['type' => 'hidden', 'id' => 'ccname', 'class' => "card-input card-input-{$j}", 'disabled' => true, 'value' => $cardInformation['name_on_card']]) ?>
                                            <div class="col-sm-2 min-wdth">
                                                <?php if ($cardDetails[$j]['is_approve'] == 1 && $cardDetails[$j]['is_enabled'] == 1) { ?>
                                                    <input onclick="$('.card-input , .ccvv').prop('disabled', true), $('.card-input-<?= $j ?>, .ccvv-<?= $j ?>').prop('disabled', false);" type="radio" class="chk_type" name="card_type" id="ctype<?php echo $j; ?>" required="" value="<?php echo $cardInformation['card_type']; ?>">
                                                <?php } else { ?>
                                                    <input type="radio" class="chk_type" name="card_type" id="ctype<?php echo $j; ?>" disabled='disabled' required="" value="<?php echo $cardInformation['card_type']; ?>">
                                                <?php } ?>
                                            </div>

                                            <div class="col-sm-2">
                                                <img src="<?php echo HTTP_ROOT; ?>img/mc.jpg">
                                            </div>
                                            <div class="col-sm-6">
                                                <input type="text" class="form-control" value="<?php echo $cardInformation['card_no']; ?>" disabled id="cnum" >
                                                <span>Name &nbsp;: <?php echo $cardInformation['name_on_card'] . '<br/> Expiry : ' . $cardInformation['expiry_month'] . '-' . $cardInformation['expiry_year']; ?></span>
                                            </div>
                                            <div class="col-sm-2">
                                                <input name="ccvv" required="required" disabled="disabled" type="text" maxlength="3" class="form-control number-only ccvv ccvv-<?= $j ?>" placeholder="CVV" id="cnum<?php echo $j; ?>" autocomplete="off">
                                            </div>
                                        </div>
                                        <?php
                                        $j++;
                                    }
                                }
                            }
                            ?>  
                        </div>

                        <div class="form-group col-sm-12 aligen-center">
                            <input type="hidden" class="form-control"  id="cards_no" value="<?php echo $j; ?>">
                            <?= $this->Form->submit('PAY NOW', ['type' => 'submit', 'class' => 'btn btn-lg btn-primary']) ?>
                        </div>

                        <?php echo $this->Form->end(); ?>

                    <?php } else { ?>
                        <div class="card-number" style="margin-bottom: 20px; text-align: center; color: #FF0000; font-size: 14px;">
                            No Card Present. Add New Card to Recharge.
                        </div>
                    <?php } ?>
                </div>   
            </div>

            <!--Make Payment End-->

            <!-- Transaction  --->
            <div id="transactions" class="tab-pane fade">
                <div class="ra">
                    <div class="container"> 
                        <div class="table-responsive" style="min-height: 350px;">
                            <div class="col-sm-12" style="margin: 5px 0 15px;">                                
                                <div class="col-sm-3">
                                    <label>Keyword</label> 
                                    <input type="text" class="form-control" id="keyword" name="keyword" placeholder="Search by Txn Id">
                                </div>															
                                <div class="col-sm-3">
                                    <label>From Date</label>
                                    <div class='input-group date' id='fromDate'>
                                        <input type="text" class="form-control" id="from_date" name="from_date" placeholder="From Date" />
                                        <span class="input-group-addon">
                                            <span class="glyphicon glyphicon-calendar"></span>
                                        </span>
                                    </div>                                    
                                </div>															
                                <div class="col-sm-3">
                                    <label>To Date</label>
                                    <div class='input-group date' id='toDate'>
                                        <input type="text" class="form-control" id="to_date" name="to_date" placeholder="To Date" >
                                        <span class="input-group-addon">
                                            <span class="glyphicon glyphicon-calendar"></span>
                                        </span>
                                    </div>                                      
                                </div>															
                                <div class="col-sm-3">                                     
                                    <button class="btn btn-success" style="margin-top: 25px;" onclick="getTransactions();">Search</button>
                                    <button class="btn btn-primary" style="margin-top: 25px;" onclick="$('#keyword , #from_date, #to_date').val(''), getTransactions();">Reset</button>                                   
                                </div>															
                            </div>

                            <table class="table table-striped table-hover">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th style="text-align: center;">Date</th>
                                        <th>Txn ID</th>
                                        <th style="text-align: right;">Amount</th>
                                        <th>Card No</th>
                                        <th style="text-align: center;">PayU Status</th>
                                        <!--<th style="text-align: center;">Txn Status</th>-->
                                        <th style="text-align: center;">IndiGo Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <!-- Ajax Transaction Content-->
                                    <tr><td colspan='8' class='nodata aligen-center'>No transaction found.</td></tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="row" id='pagination'>
                            <div class="col-xs-3">
                                <div class="paging-counter" style="margin: 20px 0;" ><!-- Ajax Pagination Counter Content--></div>                                        
                            </div>
                            <div class="col-xs-9">                                                                           
                                <ul class="pagination" style="float: right;"> 
                                    <!-- Ajax Pagination Link Content-->
                                </ul>                                     
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Transaction  --->
        </div>
    </div>
</div>




<div class="modal fadeXX"  role="dialog" style="background: rgba(241, 241, 241, 0.8); display: <?php echo (empty($agentData['firstname']) || empty($agentData['email']) || empty($agentData['mobile'])) ? 'block' : 'none'; ?>;" id="updateProfile" >
    <div class="modal-dialog">    
        <!-- Modal content-->
        <div class="modal-content" style="margin-top: 20%;">
            <form action="users/update-agent-info" method="post" enctype="multipart/form-data">                
                <div class="modal-header">
                    <!--<button type="button" class="close" data-dismiss="modal" onclick="$(this).parents('.modal').hide();">&times;</button>-->
                    <h4 class="modal-title">Update Profile</h4>
                </div>
                <div class="modal-body">
                    <div class="row">  
                        <table align='center' style="width: 100%;">
                            <tr>
                                <td style="padding: 10px 40px; width: 30%;"><label> First Name </label>:</td>
                                <td style=""><div class="col-xs-8"><input type="text" class="form-control firstname" value="<?= $agentData['firstname'] ?>"  name="firstname" required="" placeholder="First Name" /></div></td>
                            </tr>
                            <tr>
                                <td style="padding: 10px 40px;"><label> Last Name </label>:</td>
                                <td style=""><div class="col-xs-8"><input type="text" class="form-control lastname" value="<?= $agentData['lastname'] ?>"  name="lastname"  placeholder="Last Name" /></div></td>
                            </tr>
                            <tr>
                                <td style="padding: 10px 40px;"><label> Email</label>:</td>
                                <td style=""><div class="col-xs-8"><input type="email" class="form-control email" value="<?= $agentData['email'] ?>" name="email" required="" placeholder="Email" /></div></td>
                            </tr>                            
                            <tr>
                                <td style="padding: 10px 40px;"><label> Mobile </label>:</td>
                                <td style=""><div class="col-xs-8"><input type="number" class="form-control mobile number-only" value="<?= $agentData['mobile'] ?>" name="mobile" required="" placeholder="Mobile" /></div></td>
                            </tr>                            
                        </table>
                    </div>   
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-info update-prof-btn"><i class="ace-icon fa fa-check bigger-110"></i> Update </button>                    
                    <!--<button type="button" class="btn" onclick="$(this).parents('.modal').hide();"> <i class="ace-icon fa fa-undo bigger-110"></i> Cancel </button>-->
                </div>
            </form>
        </div>
    </div>
</div>



<link href="//cdn.rawgit.com/Eonasdan/bootstrap-datetimepicker/e8bddc60e73c1ec2475f827be36e1957af72e2ea/build/css/bootstrap-datetimepicker.css" rel="stylesheet">
<script src="//cdnjs.cloudflare.com/ajax/libs/moment.js/2.9.0/moment-with-locales.js"></script>
<script src="//cdn.rawgit.com/Eonasdan/bootstrap-datetimepicker/e8bddc60e73c1ec2475f827be36e1957af72e2ea/src/js/bootstrap-datetimepicker.js"></script>
<style>
    .dropdown-menu {
        z-index: 999999999999;
    }
</style>

<script type="text/javascript">

                                        $(document).ready(function () {
                                            var type = window.location.hash.substr(1);
                                            if (type === 'trans') {
                                                $('#nav-tabs li').removeClass('active');
                                                $('#nav-tabs li#' + type).addClass('active');
                                            }
                                            getTransactions();

                                            //Linked Date Pickers//
                                            $('#fromDate').datetimepicker({
                                                format: 'YYYY-MM-DD'
                                            });
                                            $('#toDate').datetimepicker({
                                                format: 'YYYY-MM-DD',
                                                useCurrent: false //Important! See issue #1075
                                            });
                                            $("#fromDate").on("dp.change", function (e) {
                                                $('#toDate').data("DateTimePicker").minDate(e.date);
                                            });
                                            $("#toDate").on("dp.change", function (e) {
                                                $('#fromDate').data("DateTimePicker").maxDate(e.date);
                                            });
                                            //Linked Pickers End//

                                            $("a[data-toggle='tab']").on('click', function (e) {
                                                var hash = $(this).attr('href');
                                                window.location.hash = hash;
                                            });
                                            if (window.location.hash) {
                                                var hash = window.location.hash.substring(1); //Puts hash in variable, and removes the # character
                                                $("a[href='#" + hash + "']").click();
                                            }
                                        });

                                        $(function () {
                                            //Allow only 2 point after Decimal
                                            $('.decimal').keypress(function (event) {
                                                var $this = $(this);
                                                if ((event.which != 46 || $this.val().indexOf('.') != -1) &&
                                                        ((event.which < 48 || event.which > 57) &&
                                                                (event.which != 0 && event.which != 8))) {
                                                    event.preventDefault();
                                                }

                                                var text = $(this).val();
                                                if ((event.which == 46) && (text.indexOf('.') == -1)) {
                                                    setTimeout(function () {
                                                        if ($this.val().substring($this.val().indexOf('.')).length > 3) {
                                                            $this.val($this.val().substring(0, $this.val().indexOf('.') + 3));
                                                        }
                                                    }, 1);
                                                }

                                                if ((text.indexOf('.') != -1) &&
                                                        (text.substring(text.indexOf('.')).length > 2) &&
                                                        (event.which != 0 && event.which != 8) &&
                                                        ($(this)[0].selectionStart >= text.length - 2)) {
                                                    event.preventDefault();
                                                }
                                            });


                                            $(document).on('keydown', '.decimalXX', function (e) {
                                                // Allow: backspace, delete, tab, escape, enter and .
                                                // Allow: Ctrl+A, Command+A
                                                // Allow: home, end, left, right, down, up
                                                // let it happen, don't do anything
                                                if ($.inArray(e.keyCode, [46, 8, 9, 27, 13, 110, 190]) !== -1 || (e.keyCode === 65 && (e.ctrlKey === true || e.metaKey === true)) || (e.keyCode >= 35 && e.keyCode <= 40)) {
                                                    return;
                                                }
                                                // Ensure that it is a number and stop the keypress
                                                if ((e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) && (e.keyCode < 96 || e.keyCode > 105)) {
                                                    e.preventDefault();
                                                }
                                            });

                                            $(document).on('keydown', '.numeric', function (e) {
                                                if ($.inArray(e.keyCode, [46, 8, 9, 27, 13, 110]) !== -1 || (e.keyCode === 65 && (e.ctrlKey === true || e.metaKey === true)) || (e.keyCode >= 35 && e.keyCode <= 40)) {
                                                    return;
                                                }
                                                if ((e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) && (e.keyCode < 96 || e.keyCode > 105)) {
                                                    e.preventDefault();
                                                }
                                            });

                                            $(document).on('keydown', '.phone', function (e) {
                                                if ($.inArray(e.keyCode, [46, 8, 9, 27, 13, 110, 45]) !== -1 || (e.keyCode === 65 && (e.ctrlKey === true || e.metaKey === true)) || (e.keyCode >= 35 && e.keyCode <= 40)) {
                                                    return;
                                                }
                                                if ((e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) && (e.keyCode < 96 || e.keyCode > 105)) {
                                                    e.preventDefault();
                                                }
                                            });
                                        });
                                        function checkCard(_this) {
                                            console.log($(_this).val());
                                            var cardNo = $(_this).val();
                                            if (cardNo) {
                                                $.post('users/ajaxValidateCard', {'cardNo': cardNo}, function (response) {
                                                    if (response.is_valid == 1) {
                                                        $('#cardNoMsg').text('Valid Card Number.').css({'color': 'green'});
                                                    } else {
                                                        $('#cardNoMsg').text('Invalid Card Number.').css({'color': 'red'});
                                                    }
                                                }, 'json');
                                            }
                                        }


</script>