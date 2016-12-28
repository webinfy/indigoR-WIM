<script>
    ////Home Page Product Search Start////
    $(function () {
        var siteUrl = $('#siteUrl').val();
        
        var keywordObj = $('#searchbox-input');
        $(document).on('keyup', '#searchbox-input', function () {
            var keyword = keywordObj.val().trim();
            if (keyword.length > 0) {
                $.get(siteUrl + "users/ajaxSearchSuggestions", {'keyword': keyword}, function (data) {
                    if (data) {
                        $('#search-suggestion-box').html(data);
                        $('#search-suggestion-box').show();
                    } else {
                        $('#search-suggestion-box').hide();
                    }
                });
            } else {
                $('#search-suggestion-box').hide();
            }
        });
        
        $('#allchk, .chk_card').click(function(){
            if($('.chk_card:checked').length > 0){ 
                 $('.btn-approve').prop("disabled", false);
            }else{
                 $('.btn-approve').prop("disabled", true);
            }
        });
        
    });
    $(window).click(function () {
        if ($('#search-suggestion-box').length > 0) {
            $('#search-suggestion-box').hide();
        }
    });
    $('#search-suggestion-box').click(function (event) {
        event.stopPropagation();
    });
    
    
    function submitForm(action){
        $('#chk_btn').val(action);
        $('#form_id').submit();
    }
    
</script>
<?php
//pj($chkApprove); exit;

//$objtoArray = $chkApprove[0]->toArray();

//pj($objtoArray); exit;
/*foreach($cardDetails as $cards){
    
    $datas = json_decode($cards, true);
            $dataV = json_decode(json_encode($datas), true);
    print_r($dataV); exit;
    //
   
    foreach($dataV['user_cards'] as $d){
        print_r($d); exit;
    print_r($d['name_on_card']);
    }
}*/
?>
<div class="clear"></div>

<div class="ad">
    <div class="container"  style="display:block;">
<?php echo $this->Flash->render(); ?>
        <ul class="nav nav-tabs">
            <li class="active" id="ranc"><a data-toggle="tab" href="<?php echo HTTP_ROOT.'users/dashboard' ?>">All Cards</a></li>
            <li id="recards"><a href="<?php echo HTTP_ROOT.'users/transaction' ?>">All Transactions</a></li>

        </ul>

        <div class="tab-content">
            <div id="rnc" class="tab-pane fade in active">
                <div class="nc">
                    <div class="register-card-data">
                        <h2>All Registered Cards</h2>
                    </div>
                    <div class="clear"></div>

                    <div class="container">
                        <div class="filter_content approve-all">
                            <div class="div-right">
                                <form method="get">
                                    <table>
                                        <tr>
                                            <td>
                                                <select name="status" class="form-control spacing-right" style="display: none;">
                                                    <option value="2">All</option>
                                                    <option value="1">Approved</option>
                                                    <option value="0">Declined</option>
                                                </select>
                                            </td>
                                            <td style="position: relative;">
                                                <input type="text" name="agent" placeholder="Enter agent name" id="searchbox-input" class="form-control" autocomplete="off"/>

                                                <div id="search-suggestion-box"></div>
                                            </td>
                                            <td>
                                                <input type="submit" value="Search" class="btn btn-primary bmargin">
                                            </td>
                                        </tr>
                                    </table>
                                </form>
                            </div>
                            <form method="post" id="form_id">
                            <div class="div-left">
                                <button class="btn btn-sm btn-primary btn-approve" name="approved" value="Approve" id="btn-approve" disabled="disabled" type="button" onclick="submitForm('approve')" />
                                    Approve
                                </button>
                                <button class="btn btn-sm btn-primary btn-color btn-approve" name="declined" type="button" onclick="submitForm('decline')" disabled="disabled">
                                    Disapprove
                                </button> 
                            </div>
                        </div>
                        <div class="clear"></div>
                        <div class="table-responsive">
                            <input type="hidden" name="chk_btn"  value="approve" id="chk_btn">
                            <table class="table table-striped table-hover">
                                <thead>
                                    <tr>

                                        <th><input type="checkbox" id="allchk" onclick="$('.chk_card').prop('checked', $(this).is(':checked'))" ></th>
                                        <th>Card Type</th>
                                        <th>Card No</th>
                                        <th>Name On Card</th>
                                        <th>Card Expiry DT</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                <?php
                                $k=0;
                                $i = 1; 
                                foreach($cardDetails as $cards){ 
                                    $datas = json_decode($cards, true);
                                    $dataV = json_decode(json_encode($datas), true);
                                    foreach($dataV['user_cards'] as $getCards){
                                    $objtoArray = $chkApprove[$k]->toArray();
                                ?>
                                    <tr>
                                        <td><input type="checkbox" name="chk[]" class="chk_card" value="<?php echo $getCards['card_token']; ?>"></td>
                                        <td><?php echo $getCards['card_brand']; ?></td>
                                        <td><?php echo $getCards['card_no']; ?></td>
                                        <td><?php echo $getCards['name_on_card']; ?></td>
                                        <td><?php echo $getCards['expiry_month'].'-'.$getCards['expiry_year']; ?></td>
                                        <td>
                                            <?php
                                            if($objtoArray[0]->is_approve == '0'){ ?>
                                            <a href="<?php echo HTTP_ROOT.'users/cardapprove/'.$getCards['card_token']; ?>">
                                                <button class="btn btn-sm btn-primary" type="button">
                                                    Click to approve
                                                </button>
                                            </a>

                                            <?php } else{ ?>
                                            <a href="<?php echo HTTP_ROOT.'users/carddisapprove/'.$getCards['card_token']; ?>"><button class="btn btn-sm btn-primary btn-color" type="button">
                                                    Click to decline
                                                </button>
                                            </a>
                                            <?php } ?>


                                        </td>

                                    </tr>
                                <?php  $i++; $k++; } 
                                
                                    }
                                
                            ?>



                                </tbody>
                            </table>
                            <?php /* if ($this->Paginator->numbers()): ?>
                            <ul class="pagination">                      
                            <?= $this->Paginator->prev('< ' . __('previous')) ?>
                            <?= $this->Paginator->numbers() ?>
                            <?= $this->Paginator->next(__('next') . ' >') ?>
                            </ul> 
                    <?php endif; */ ?>
                        </div>
                        </form>
                    </div>
                </div>
            </div> 
        </div>
    </div>
</div>