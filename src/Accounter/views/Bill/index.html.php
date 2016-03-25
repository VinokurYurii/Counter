<div class="col-sm-8 blog-main">
    <?php
    $mainSum = 0;
    foreach ($bills as $bill) { ?>
    <a href="/bill_type/<?php echo $bill->id; ?>" style="color: red">
        <?php echo $bill->type; ?></a>: <strong><?php echo isset($bill->sum) ? $bill->sum : 0; ?></strong>
        <?php if(isset($bill->sum)) { $mainSum += $bill->sum; } ?>
    <?php $walkOnBills($bill); } ?>
    <div>
        <strong>Баланс: <?php echo $mainSum; ?></strong>
    </div>
    <div>
        <a href="/bill_type/add/0"><button>Добавить вид расхода</button></a>
    </div>
</div>
