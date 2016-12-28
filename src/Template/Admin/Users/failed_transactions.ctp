<div class="clear"></div>
<div class="ad">
    <div class="container"   style="display:block;">

        <ul class="nav nav-tabs">
            <li  id="all-cards"><a  href="<?= HTTP_ROOT . 'admin'; ?>">All Cards</a></li>
            <li  id="all-transactions"><a href="<?= HTTP_ROOT . 'admin/users/transactions'; ?>">All Transactions</a></li>
            <!--<li  id="failed-transactions" class="active"><a href="javascript:;">Failed Transactions</a></li>-->
        </ul>

        <div class="tab-content">
            <!-- Transaction  --->
            <div id="rnc" class="tab-pane fade in active">
                <div class="nc">
                    <div class="register-card-data">
                        <h2>Failed Transactions</h2>
                    </div>
                    <div class="clear"></div>
                    <div class="container">
                        <!-- -->
                        <div class="filter_content" style="width: 850px;">
                            <form method="get">
                                <table>
                                    <tr>
                                        <td style="position: relative; padding: 10px;">
                                            <input type="text" value="<?= isset($_GET['transaction_id']) ? $_GET['transaction_id'] : '' ?>" name="transaction_id" placeholder="Enter Transaction ID" id="searchbox-input" class="form-control" autocomplete="off"/>
                                            <div id="search-suggestion-box"></div>
                                        </td>
                                        <td style="position: relative; padding: 10px;">
                                            <select name="payment_status" class="form-control">
                                                <option value="">Txn Status</option>                                                
                                                <option <?php if (isset($_GET['payment_status']) && $_GET['payment_status'] == 1) { ?> selected <?php } ?> value="1">Success</option>
                                                <option <?php if (isset($_GET['payment_status']) && $_GET['payment_status'] == 2) { ?> selected <?php } ?> value="2">Failed</option>
                                                <option <?php if (isset($_GET['payment_status']) && $_GET['payment_status'] == 3) { ?> selected <?php } ?> value="3">Canceled</option>
                                            </select>
                                        </td>
                                        <td style="position: relative; padding: 10px;">
                                            <select name="navitor_status" class="form-control">
                                                <option value="">Navitor Status </option>
                                                <option <?php if (isset($_GET['navitor_status']) && $_GET['navitor_status'] == '0') { ?> selected <?php } ?> value="0">Pending</option>
                                                <option <?php if (isset($_GET['navitor_status']) && $_GET['navitor_status'] == '1') { ?> selected <?php } ?> value="1">Success</option>
                                                <option <?php if (isset($_GET['navitor_status']) && $_GET['navitor_status'] == '2') { ?> selected <?php } ?> value="2">Failed</option>
                                            </select>
                                        </td>
                                        <td style="position: relative; padding: 10px; width: 340px;">
                                            <input type="submit" value="Search" class="btn btn-primary bmargin" style="float: left; display: inline-block; margin: 0 5px;" />                                            
                                            <a href="<?= HTTP_ROOT . "admin/users/failed-transactions"; ?>" class="btn btn-info" style="float: left; display: inline-block; margin: 0 5px;">Clear</a>                                             
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
                                        <th>Amount</th>
                                        <th>Card No</th>
                                        <th style="text-align: center;">Txn Status</th>
                                        <th style="text-align: center;">IndiGo Navitor Status</th>                                        
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    if ($failedTransactions->count() > 0) {
                                        $i = 1;
                                        foreach ($failedTransactions as $failedTransaction) {
                                            ?>
                                            <tr>
                                                <td><?php echo date("M d, Y", strtotime($failedTransaction->transaction->created)); ?></td>
                                                <td><?php echo $failedTransaction->transaction->user->firstname . " " . $failedTransaction->transaction->user->lastname; ?></td>
                                                <td><?php echo $failedTransaction->transaction->transaction_id; ?></td>
                                                <td><?php echo $failedTransaction->transaction->amount; ?></td>
                                                <td><?php echo $failedTransaction->transaction->card_number; ?></td>
                                                <td style="text-align: center;"><?= $this->Custom->paymentStatus($failedTransaction->transaction->payment_status); ?></td>
                                                <td style="text-align: center;"><?= $this->Custom->navitorStatus($failedTransaction->transaction->navitor_status); ?></td>
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
                            <div style="float: right;">
                                <?php if ($this->Paginator->numbers()): ?>
                                    <ul class="pagination">                      
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
            <!-- Transaction  --->
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
</script>