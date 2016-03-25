<div class="row">
    <a href="/bill_type/<?php echo $bill->id; ?>"><?php echo $bill->type; ?></a>: <strong><?php echo isset($bill->sum) ?
            $bill->sum : 0 ?></strong>
    <?php $walkOnBills($bill); ?>
</div>
<div>
<?php
if(!empty($bill->comment)) {
    echo $bill->comment;
}
?>
</div>
<br>
<div>
    <a href="/bill_type/add/<?php echo $bill->id; ?>"><button>Добавить вид расхода</button></a>
</div>
<br>
<div>
    <a href="#"><button>Добавить чек</button></a>
</div>