<?php
$create_date = new \DateTime();
$update_date = new \DateTime();
$create_date->setTimestamp(strtotime($species->create_date));
$update_date->setTimestamp(strtotime($species->update_date));
?>

<div class="row">
    <?php echo $species->species; ?>: <strong><?php echo $species->amount ?></strong>
</div>
<div>
    <?php
    echo 'Дата создания: ' . $create_date->format('F j, Y H:i:s');
    if ($create_date != $update_date) {
        echo '<br>Дата изменения: ' . $update_date->format('F j, Y H:i:s');
    }
    ?>
</div>
<div>
    <?php
    if(!empty($species->comment)) {
        echo $species->comment;
    }
    ?>
</div>
<br>
<div>
    <a href="/bill_type/<?php echo $species->type_id; ?>"><button>Вернуться к виду платежей</button></a>
</div>
