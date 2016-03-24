<div class="col-sm-8 blog-main">
    <?php foreach ($bills as $bill) { ?>
    <a href="/bill_type/<?php echo $bill->id; ?>"><?php echo $bill->type; ?></a>: <strong><?php echo isset($bill->sum) ?
                $bill->sum : 0 ?></strong>
    <?php $walkOnBills($bill); } ?>
    <div>
        <a href="/bill_type/add/0"><button>Добавить вид расхода</button></a>
    </div>
</div>
