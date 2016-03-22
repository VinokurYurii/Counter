<?php
/*$date = new \DateTime();
$date->setTimestamp(strtotime($post->date));*/
?>

<div class="row">
    <a href="/bill_type/<?php echo $bill->id; ?>"><?php echo $bill->type; ?></a>
    <?php $walkOnBills($bill); ?>
</div>