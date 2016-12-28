<div class="clear"></div>
<div class="ad">
    <div class="container"  style="display:block;">

        <?php echo $this->Flash->render(); ?>

        <ul class="nav nav-tabs">
            <li  id="all-cards" class="active"><a  href="javascript:;">All Cards</a></li>
            <li  id="all-transactions"><a href="<?= HTTP_ROOT . 'admin/users/transactions'; ?>">All Transactions</a></li>
            <!--<li  id="failed-transactions"><a href="<?= HTTP_ROOT . 'admin/users/failed-transactions'; ?>">Failed Transactions</a></li>-->
        </ul>

        <div class="tab-content">
            <div id="rnc" class="tab-pane fade in active">
                <div class="nc">
                    <div class="register-card-data">
                        <h2>All Registered Cards</h2>
                    </div>
                    <div class="clear"></div>
                    <div class="container">
                        <!--
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
                        </div>
                        -->
                        <form method="post" id="form_id">

                            <?php if ($this->request->session()->read('Auth.User.type') == 1) { ?>
                                <div class="div-right">
                                    <button class="btn btn-sm btn-success" name="approved" value="Approve" id="btn-select" type="button" onclick="$('#allchk').click(), $('#allchk').is(':checked') ? $(this).text('Select None') : $(this).text('Select All');" />
                                    Select All
                                    </button>
                                    <button class="btn btn-sm btn-primary btn-approve" name="approved" value="Approve" id="btn-approve" disabled="disabled" type="button" onclick="submitForm('approve')" />
                                    Activate
                                    </button>
                                    <button class="btn btn-sm btn-primary btn-color btn-approve" name="declined" type="button" onclick="submitForm('decline')" disabled="disabled">
                                        De-Activate
                                    </button> 
                                </div>
                            <?php } ?>

                            <div class="clear"></div>
                            <div class="table-responsive">
                                <input type="hidden" name="chk_btn"  value="approve" id="chk_btn">
                                <table class="table table-striped table-hover">
                                    <thead>
                                        <tr>
                                            <?php if ($this->request->session()->read('Auth.User.type') == 1) { ?>
                                                <th><input type="checkbox" id="allchk" onclick="$('.chk_card').prop('checked', $(this).is(':checked'))" ></th>
                                            <?php } ?>
                                            <th>Card Type</th>
                                            <th>Card No</th>
                                            <th>Name On Card</th>
                                            <th style="text-align: center;">Expiry Date</th>
                                            <th style="text-align: center;">Status</th>
                                            <?php if ($this->request->session()->read('Auth.User.type') == 1) { ?>
                                                <th style="text-align: center;">Action</th>
                                            <?php } ?>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        if ($cards->count() > 0) {
                                            foreach ($cards as $card) {
                                                if ($card->card_detail) {
                                                    ?>
                                                    <tr>
                                                        <?php if ($this->request->session()->read('Auth.User.type') == 1) { ?>
                                                            <td><input type="checkbox" name="chk[]" class="chk_card" value="<?php echo $card['card_detail']['card_token']; ?>"></td>
                                                        <?php } ?>
                                                        <td><?php echo $card['card_detail']['card_brand']; ?></td>
                                                        <td><?php echo $card['card_detail']['card_no']; ?></td>
                                                        <td><?php echo $card['card_detail']['name_on_card']; ?></td>
                                                        <td style="text-align: center;"><?= $card['card_detail']['expiry_month'] . '-' . $card['card_detail']['expiry_year']; ?></td>
                                                        <td style="text-align: center;"><?= $this->Custom->cardStatus($card['is_approve']); ?></td>
                                                        <?php if ($this->request->session()->read('Auth.User.type') == 1) { ?>
                                                            <td style="text-align: center;">
                                                                <?php if ($card['is_approve'] == 0 || $card['is_approve'] == 2) { ?>
                                                                    <a href="<?php echo HTTP_ROOT . 'admin/users/cardapprove/' . $card['card_detail']['card_token']; ?>">
                                                                        <button class="btn btn-sm btn-primary" type="button">
                                                                            Click to Activate
                                                                        </button>
                                                                    </a>
                                                                <?php } else { ?>
                                                                    <a href="<?php echo HTTP_ROOT . 'admin/users/carddisapprove/' . $card['card_detail']['card_token']; ?>"><button class="btn btn-sm btn-primary btn-color" type="button">
                                                                            Click to De-Activate
                                                                        </button>
                                                                    </a>
                                                                <?php } ?>
                                                                <a href="javascript:;">
                                                                    <button type="button" class="btn btn-sm btn-success" data-toggle="modal" data-target="#myModal-<?= $card['card_detail']['card_token'] ?>">
                                                                        View
                                                                    </button>
                                                                </a>

                                                                <!--Popup Code-->
                                                                <!-- Modal -->
                                                                <div id="myModal-<?= $card['card_detail']['card_token'] ?>" class="modal fade" role="dialog">
                                                                    <div class="modal-dialog">
                                                                        <!-- Modal content-->
                                                                        <div class="modal-content">
                                                                            <div class="modal-header">
                                                                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                                                <h4 class="modal-title">Card Details</h4>
                                                                            </div>
                                                                            <div class="modal-body">
                                                                                <div class="row" style=""> 
                                                                                    <table align='center'>

                                                                                        <tr>
                                                                                            <td style="padding: 10px; text-align: left;"> Name on Card </td>
                                                                                            <td style="padding: 10px; text-align: left;"> : <?= $card['card_detail']['name_on_card'] ?></td>
                                                                                        </tr>
                                                                                        <!--
                                                                                        <tr>
                                                                                            <td  style="padding: 10px; text-align: left;">Login Id </td>
                                                                                            <td style="padding: 10px; text-align: left;"> : <?= $card['login_id'] ?></td>
                                                                                        </tr>
                                                                                        <tr>
                                                                                            <td  style="padding: 10px; text-align: left;"> Agency Id</td>
                                                                                            <td style="padding: 10px; text-align: left;" > :<?= $card['agency_id'] ?></td>
                                                                                        </tr>
                                                                                        <tr>
                                                                                            <td style="padding: 10px; text-align: left;">  Email </td>
                                                                                            <td style="padding: 10px; text-align: left;" > : <?= $card['email'] ?></td>
                                                                                        </tr>
                                                                                        <tr>
                                                                                            <td  style="padding: 10px; text-align: left;"> Scanned Credit Card </td>
                                                                                            <td style="padding: 10px; text-align: left;"> :  <?php if ($card['scanned_credit_card']) { ?> <a target="_blank" href="<?= HTTP_ROOT . SCANNED_CREDIT_CARD . $card['scanned_credit_card']; ?>">Download</a> <?php } else { ?> Not Available <?php } ?> </td>
                                                                                        </tr>
                                                                                        <tr>
                                                                                            <td  style="padding: 10px; text-align: left;">Document3 </td>
                                                                                            <td style="padding: 10px; text-align: left;" > : <?php if ($card['document3']) { ?> <a target="_blank" href="<?= HTTP_ROOT . DOCUMENT3 . $card['document3']; ?>">Download</a> <?php } else { ?> Not Available <?php } ?> </td>
                                                                                        </tr>
                                                                                        -->
                                                                                        <tr>
                                                                                            <td style="padding: 10px; text-align: left;"> Mandate Form </td>
                                                                                            <td style="padding: 10px; text-align: left;" > : <?php if ($card['mandate_form']) { ?> <a target="_blank" href="<?= HTTP_ROOT . MANDATE_FORM . $card['mandate_form']; ?>">Download</a> <?php } else { ?> Not Available <?php } ?> </td>
                                                                                        </tr>                                                                                        
                                                                                        <tr>
                                                                                            <td  style="padding: 10px; text-align: left;"> Bank name </td>
                                                                                            <td style="padding: 10px; text-align: left;" > :<?= $card['bank_name'] ?></td>
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
                                                            <?php
                                                        }
                                                    }
                                                    ?>
                                                </tr>
                                                <?php
                                            }
                                        } else {
                                            ?>
                                            <tr><td colspan="10" style="text-align: center; color: red;">No Card Found</td></tr>
                                            <?php
                                        }
                                        ?>
                                    </tbody>
                                </table>
                                <div class="col-sm-12">
                                    <div class="col-sm-4" style="float: left; padding-left: 0; margin: 20px 0;">
                                        <?php echo $this->Paginator->counter('Showing {{start}} to  {{end}} of records out of {{count}} entries'); ?>
                                    </div>
                                    <div class="col-sm-8" style="float: right;">
                                        <?php if ($this->Paginator->numbers()): ?>
                                            <ul class="pagination" style="float: right; padding-right: 0;">                      
                                                <?= $this->Paginator->prev('< ' . __('previous')) ?>
                                                <?= $this->Paginator->numbers() ?>
                                                <?= $this->Paginator->next(__('next') . ' >') ?>
                                            </ul> 
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div> 
        </div>
    </div>
</div>







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

        $('#allchk, .chk_card').click(function () {
            if ($('.chk_card:checked').length > 0) {
                $('.btn-approve').prop("disabled", false);
            } else {
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


    function submitForm(action) {
        $('#chk_btn').val(action);
        $('#form_id').submit();
    }

</script>