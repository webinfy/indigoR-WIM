<div class="clear"></div>
<div class="ad">
    <div class="container"   style="display:block;">

        <ul class="nav nav-tabs">
            <li  id="all-cards"><a  href="<?= HTTP_ROOT . 'admin'; ?>">All Cards</a></li>
            <li  id="all-transactions" class="active"><a href="javascript:;">All Transactions</a></li>
            <!--<li  id="failed-transactions"><a href="<?= HTTP_ROOT . 'admin/users/failed-transactions'; ?>">Failed Transactions</a></li>-->
        </ul>

        <div class="tab-content">
            <!-- Transaction  --->
            <div id="rnc" class="tab-pane fade in active">
                <div class="nc">
                    <div class="register-card-data">
                        <h2>All Transactions</h2>
                    </div>
                    <div class="clear"></div>
                    <div class="container">
                        <!-- -->
                        <div class="filter_content" style="width: 100%;">
                            <form method="post">
                                <table>
                                    <tr>
                                        <td style="position: relative; padding-right: 5px; width: 14%;">
                                            <input type="text" value="<?= isset($_GET['transaction_id']) ? $_GET['transaction_id'] : '' ?>" name="transaction_id" placeholder="Enter Txn ID" id="searchbox-input" class="form-control" autocomplete="off"/>
                                            <div id="search-suggestion-box"></div>
                                        </td>
                                        <td style="position: relative; padding-right: 5px;">
                                            <select name="payu_status" class="form-control">
                                                <option value="">PayU Status</option>                                         
                                                <option <?php if (isset($_GET['payu_status']) && $_GET['payu_status'] == 'captured') { ?> selected <?php } ?> value="captured">Captured</option>
                                                <option <?php if (isset($_GET['payu_status']) && $_GET['payu_status'] == 'dropped') { ?> selected <?php } ?> value="dropped">Dropped</option>
                                                <option <?php if (isset($_GET['payu_status']) && $_GET['payu_status'] == 'bounced') { ?> selected <?php } ?> value="bounced">Bounced</option>
                                                <option <?php if (isset($_GET['payu_status']) && $_GET['payu_status'] == 'auth') { ?> selected <?php } ?> value="auth">Auth</option>
                                                <option <?php if (isset($_GET['payu_status']) && $_GET['payu_status'] == 'failed') { ?> selected <?php } ?> value="failed">Failed</option>
                                                <option <?php if (isset($_GET['payu_status']) && $_GET['payu_status'] == 'usercancelled') { ?> selected <?php } ?> value="usercancelled">User Cancelled</option>
                                                <option <?php if (isset($_GET['payu_status']) && $_GET['payu_status'] == 'pending') { ?> selected <?php } ?> value="pending">Pending</option>
                                            </select>
                                        </td>
                                        <td style="position: relative; padding-right: 5px;">
                                            <select name="navitor_status" class="form-control">
                                                <option value="">IndiGo Status </option>
                                                <option <?php if (isset($_GET['navitor_status']) && $_GET['navitor_status'] == '1') { ?> selected <?php } ?> value="1">Success</option>
                                                <option <?php if (isset($_GET['navitor_status']) && $_GET['navitor_status'] == '2') { ?> selected <?php } ?> value="2">Pending</option>
                                                <!--<option <?php if (isset($_GET['navitor_status']) && $_GET['navitor_status'] == '2') { ?> selected <?php } ?> value="2">Failed</option>-->
                                            </select>
                                        </td>
                                        <td style="position: relative; padding-right: 5px; width: 15%;">                                     
                                            <div class='input-group date' id='fromDate'>
                                                <input type="text" class="form-control" value="<?= (isset($_GET['from_date'])) ? urldecode($_GET['from_date']) : '' ?>" id="from_date" name="from_date" placeholder="From Date" />
                                                <span class="input-group-addon">
                                                    <span class="glyphicon glyphicon-calendar"></span>
                                                </span>
                                            </div> 
                                        </td>
                                        <td style="position: relative; padding-right: 5px;  width: 15%;">
                                            <div class='input-group date' id='toDate'>
                                                <input type="text" class="form-control" value="<?= (isset($_GET['to_date'])) ? urldecode($_GET['to_date']) : '' ?>" id="to_date" name="to_date" placeholder="To Date" >
                                                <span class="input-group-addon">
                                                    <span class="glyphicon glyphicon-calendar"></span>
                                                </span>
                                            </div>  
                                        </td>
                                        <!--
                                         <td style="position: relative; padding: 10px;">
                                            <select name="payment_status" class="form-control">
                                                <option value="">Txn Status</option>                                                
                                                <option <?php if (!isset($_GET['payment_status']) || (isset($_GET['payment_status']) && $_GET['payment_status'] == 1)) { ?> selected <?php } ?> value="1">Success</option>
                                                <option <?php if (isset($_GET['payment_status']) && $_GET['payment_status'] == 2) { ?> selected <?php } ?> value="2">Pending</option>
                                                <option <?php if (isset($_GET['payment_status']) && $_GET['payment_status'] == 3) { ?> selected <?php } ?> value="3">Failed</option>
                                                <option <?php if (isset($_GET['payment_status']) && $_GET['payment_status'] == 4) { ?> selected <?php } ?> value="4">Canceled</option>
                                            </select>
                                        </td>
                                        -->                                        
                                        <td style="position: relative; padding: 10px; width: 340px;">
                                            <input type="submit" value="Search" class="btn btn-primary bmargin" style="float: left; display: inline-block; margin: 0 5px;" />                                            
                                            <a href="<?= HTTP_ROOT . "admin/users/transactions"; ?>" class="btn btn-info" style="float: left; display: inline-block; margin: 0 5px;">Clear</a>                                             
                                            <input name="download_report" type="submit" value="Download Report" class="btn btn-success bmargin" style="float: left; display: inline-block; margin: 0 5px;" />
                                        </td>
                                    </tr>
                                </table>
                            </form>
                        </div>
                        <!---->
                        <div class="table-responsive">
                            <table class="table table-striped table-hover">
                                <thead>
                                    <tr>
                                        <th>Date</th>
                                        <th>Agent Name</th>
                                        <th>Txn ID</th>
                                        <th style="text-align: right;">Amount</th>
                                        <th>Card No</th>
                                        <th style="text-align: center;">PayU Status</th>
                                        <!--<th style="text-align: center;">Txn Status</th>-->
                                        <th style="text-align: center;">IndiGo Status</th>                                        
                                        <th style="text-align: center;">Action</th>                                        
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    if ($transactions->count() > 0) {
                                        $i = 1;
                                        foreach ($transactions as $transaction) {
                                            ?>
                                            <tr>
                                                <td><?php echo date("M d, Y", strtotime($transaction->created)); ?></td>
                                                <td><?php echo $transaction->user->firstname . " " . $transaction->user->lastname; ?></td>
                                                <td><?php echo $transaction->transaction_id; ?></td>
                                                <td style="width: 150px; text-align: right;"><?php echo "Rs." . $this->Custom->formatMoney($transaction->amount); ?></td>
                                                <td><?php echo $transaction->card_number; ?></td>
                                                <td style="text-align: center; text-transform: capitalize;"><?= $transaction->unmappedstatus; ?></td>
                                                <!--<td style="text-align: center;"><?= $this->Custom->paymentStatus($transaction); ?></td>-->
                                                <td style="text-align: center;"><?= $this->Custom->navitorStatus($transaction); ?></td>
                                                <td style="text-align: center;">
                                                    <?php if ($transaction->unmappedstatus == 'captured' && $transaction->pending_url_hit != 1) { ?>
                                                        <span class="remove_card" style="margin: 0 5px;">
                                                            <a href="<?= HTTP_ROOT . 'admin/users/retry/' . $transaction->transaction_id ?>">
                                                                Retry
                                                            </a>                                             
                                                        </span>
                                                    <?php } else { ?>
                                                        <span>--</span> 
                                                    <?php } ?>
                                                </td>
                                            </tr>
                                            <?php
                                            $i++;
                                        }
                                    } else {
                                        ?>
                                        <tr><td colspan="10" class="nodata aligen-center">No transaction found.</td></tr>
                                        <?php
                                    }
                                    ?>
                                </tbody>
                            </table>
                            <div class="col-sm-12">
                                <div class="col-sm-4" style="float: left; padding-left: 0; margin-top: 20px;">
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
                    </div>
                </div>
            </div>
            <!-- Transaction  --->
        </div>
    </div>
</div>

<link href="//cdn.rawgit.com/Eonasdan/bootstrap-datetimepicker/e8bddc60e73c1ec2475f827be36e1957af72e2ea/build/css/bootstrap-datetimepicker.css" rel="stylesheet">
<script src="//cdnjs.cloudflare.com/ajax/libs/moment.js/2.9.0/moment-with-locales.js"></script>
<script src="//cdn.rawgit.com/Eonasdan/bootstrap-datetimepicker/e8bddc60e73c1ec2475f827be36e1957af72e2ea/src/js/bootstrap-datetimepicker.js"></script>

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
    });
    $(window).click(function () {
        if ($('#search-suggestion-box').length > 0) {
            $('#search-suggestion-box').hide();
        }
    });
    $('#search-suggestion-box').click(function (event) {
        event.stopPropagation();
    });
    ////Home Page Product Search End+++////
    $(document).ready(function () {
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
    });
</script>