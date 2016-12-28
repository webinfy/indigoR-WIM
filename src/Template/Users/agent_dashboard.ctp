<div class="clear"></div>
<center><h2 style="position: relative;top: -107px;">Agent Dashboard</h2></center>
<div class="container" style=margin-top:-60px;>
    <button type="button" class="btn btn-primary" style="float:right;margin-top: -1%; margin-right: 1%;">
        <span class="glyphicon glyphicon-save-file"></span>
        Export to Excel
    </button>
</div>
<div class="container">  
    <div class="table-responsive">
        <table class="table table-striped table-hover">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Txn ID</th>
                    <th>Amount</th>
                    <th>Card No</th>
                    <th>Txn Status</th>
                    <th>IndiGo Navitor Status</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($transactions as $transaction) { ?>
                    <tr>
                        <td>1</td>
                        <td><?php echo $transaction->transaction_id; ?></td>
                        <td><?php echo $transaction->amount; ?></td>
                        <td><?php echo $transaction->card_number; ?></td>
                        <td>
                            <?php
                            if ($transaction->payment_status == 0) {
                                echo "pending";
                                ?>

                                <?php
                            } else if ($transaction->payment_status == 1) {
                                echo "Success";
                                ?>

                                <?php
                            } else if ($transaction->payment_status == 2) {
                                echo 'failure';
                                ?>

                            <?php } ?>
                        </td>
                        <td>Success</td>
                    </tr>
                <?php } ?>



            </tbody>
        </table>
    </div>
</div>

<div class="container" style="text-align: center;">
    <ul class="pagination">
        <li class="active"><a href="#">1</a></li>
        <li><a href="#">2</a></li>
        <li><a href="#">3</a></li>
        <li><a href="#">4</a></li>
        <li><a href="#">5</a></li>
    </ul>
</div>