<div class="col-sm-8 blog-main">
    <?php foreach ($bills as $bill) { ?>
    <a href="/bill_type/<?php echo $bill->id; ?>"><?php echo $bill->type; ?></a>
    <?php $walkOnBills($bill); } ?>
    <div>
    </div>
</div>
