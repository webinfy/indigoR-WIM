<?php
$data = json_decode($getCard);
$cardData = json_decode(json_encode($data), true);

$cardEditData = $cardData['user_cards'][$cardToken];
//pr($cardEditData);
//exit;
?>
<style type="text/css">
    td{padding: 0%;}
    .btn {
        font-weight: 700;
        height: 40px;

        background-color: white;
        color:#28369C;
    }
    .btn:hover{
        font-weight: 700;
        height: 40px;
        box-shadow: 10px 10px 5px #888888;
        background-color: white;
        color:#28369C;
    }
    hr{

        height: 12px;
        border: 0px none;
        box-shadow: 0px 12px 12px -12px #28369C inset;
    }
</style>

<div class="clear"></div>

<div class="ad">
    <div class="container" id="tab" style="display:block;">

        <ul class="nav nav-tabs">
            <li class="active"><a href="javascript:;">Edit Card</a></li>
            <li><a href="<?= HTTP_ROOT . 'recharge' ?>">Recharge</a></li>
        </ul>

        <div class="tab-content">
            <div id="rnc" class="tab-pane fade in active">
                <div class="nc">

                    <div class="register-card-data">
                        <h2>Card Registeration<span style="float: right;"><a href="<?php echo HTTP_ROOT; ?>users/get-card-details">All register cards</a></span></h2>
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

                    <div class="table-responsive col-xs-5 credit-card-details">                        
                        <table class="table table-borderless" cellspacing="0" cellpadding="0">
                            <thead><h3 class="header2">Edit Card Details</h3></thead>                       
                            <tbody>
                                <?php echo $this->Form->create('User', array('method' => 'post')); ?>

                                <tr>
                                    <td class="col-md-1">Login ID</td>
                                    <td class="col-md-1">                            
                                        <?= $this->Form->input('login_id', ['type' => 'text', 'id' => 'login_id', 'label' => false, 'placeholder' => 'Login Id.', 'class' => 'form-control', 'required' => true]) ?>                                            
                                    </td>
                                </tr>
                                <tr>
                                    <td class="col-md-1">IndiGo Agency Id</td>
                                    <td class="col-md-1">                            
                                        <?= $this->Form->input('agency_id', ['type' => 'text', 'id' => 'agency_id', 'label' => false, 'placeholder' => 'IndiGo Agency Id', 'class' => 'form-control', 'required' => true]) ?>                                            
                                    </td>
                                </tr>
                                <tr>
                                    <td class="col-md-1">Mail ID</td>
                                    <td class="col-md-1">                            
                                        <?= $this->Form->input('email', ['type' => 'email', 'id' => 'email', 'label' => false, 'placeholder' => 'Email.', 'class' => 'form-control']) ?>                                            
                                    </td>
                                </tr>                               
                                <tr>
                                    <td class="col-md-1">Mandate Form</td>
                                    <td class="col-md-1">                                       
                                        <?= $this->Form->input('mandate_form_file', ['type' => 'file', 'id' => 'mandate_form', 'label' => false, 'class' => 'form-control', 'required' => TRUE]) ?>
                                        <a href="<?= HTTP_ROOT . "users/download-mandate-form" ?>">Download Form</a>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="col-md-1">Scan copy of credit card</td>
                                    <td class="col-md-1">                                       
                                        <?= $this->Form->input('scanned_credit_card_file', ['type' => 'file', 'id' => 'scanned_credit_card', 'label' => false, 'class' => 'form-control', 'required' => TRUE]) ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="col-md-1">Document 3 : </td>
                                    <td class="col-md-1">                                       
                                        <?= $this->Form->input('document3_file', ['type' => 'file', 'id' => 'document3', 'label' => false, 'class' => 'form-control', 'required' => TRUE]) ?>
                                    </td>
                                </tr>

                                <tr>
                                    <td class="col-md-1">Credit Card Number</td>
                                    <td class="col-md-1">
                                        <div class="form-group has-feedback">
                                            <?= $this->Form->input('cardNo', ['type' => 'text', 'id' => 'sel1', 'label' => false, 'placeholder' => 'Enter Card Name', 'id' => 'cnum', 'class' => 'form-control', 'required' => 'required', 'value' => $cardEditData['card_no']]) ?>
                                            <div class="help-block with-errors"></div>
                                        </div>                                        
                                    </td>
                                </tr>

                                <tr>
                                    <td class="col-md-1">Issued Bank Name</td>
                                    <td class="col-md-1">                            
                                        <?= $this->Form->input('bank_name', ['type' => 'text', 'id' => 'bank_name', 'label' => false, 'placeholder' => 'Issued Bank Name', 'class' => 'form-control', 'required' => true]) ?>                                            
                                    </td>
                                </tr>
                                <tr>
                                    <td class="col-md-1">Card Type</td>
                                    <td class="col-md-1">                                       
                                        <?= $this->Form->input('card_type', ['type' => 'select', 'id' => 'card_type', 'label' => false, 'escape' => false, 'options' => ['VISA' => 'Visa', 'MASTER CARD' => 'Master Card', 'MAESTRO CARD' => 'Maestro Card', 'RUPAY CARD' => 'Rupay Card'], 'class' => 'form-control', 'required' => 'required']) ?>
                                        <?php //echo $this->Form->input('cardMode', ['type' => 'hidden', 'id' => 'cardmode', 'value' => 'CC']) ?>
                                        <?= $this->Form->input('cardName', ['type' => 'hidden', 'id' => 'cardName', 'value' => "My_card"]) ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="col-md-1">Name on Card</td>
                                    <td class="col-md-1">
                                        <?= $this->Form->input('nameOnCard', ['type' => 'text', 'label' => false, 'placeholder' => "Enter Card Holder's Name", 'id' => 'cname', 'class' => 'form-control', 'required' => 'required', 'value' => $cardEditData['name_on_card']]) ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="col-md-1">Expiry Date</td>
                                    <td class="col-md-1">
                                        <div>	
                                            <div class="fieldBlock" style="width:50%; float:left;">
                                                <?= $this->Form->input('cardExpMon', ['type' => 'text', 'label' => false, 'placeholder' => "month", 'size' => '25', 'id' => 'month', 'class' => 'form-control', 'required' => 'required', 'value' => $cardEditData['expiry_month']]) ?>
                                                <!--<input type="text" class="form-control" id="month" value="" placeholder="month" size="25"/>-->
                                            </div>

                                            <div class="fieldBlock" style="width:50%; float:right;">
                                                <?= $this->Form->input('cardExpYr', ['type' => 'text', 'label' => false, 'placeholder' => "year", 'size' => '25', 'id' => 'year', 'class' => 'form-control', 'required' => 'required', 'value' => $cardEditData['expiry_year']]) ?>
                                                <!--<input type="text" class="form-control" id="year" value="" placeholder="year" size="25"/>-->
                                            </div>
                                        </div>
                                    </td>
                                </tr>   
                                <tr>

                                    <td align="center" colspan="2">
                                        <?= $this->Form->submit('Update', ['type' => 'submit', 'class' => 'btn btn-primary']) ?>
                                    </td>
                                </tr>
                                <?php echo $this->Form->end(); ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>            
        </div>
    </div>
</div>