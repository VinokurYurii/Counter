<?php if (!isset($errors)) {
    $errors = array();
}

$getValidationClass = function ($field) use ($errors) {
    return isset($errors[$field])?'has-error has-feedback':'';
};

$getErrorBody = function ($field) use ($errors){
    if (isset($errors[$field])){
        return '<span class="glyphicon glyphicon-remove form-control-feedback"></span><span class="pull-right small form-error">'.$errors[$field].'</span>';
    }
    return '';
}

?>

<div class="panel panel-default">
    <div class="panel-heading">
        <h3 class="panel-title"><?php if (isset($post->id)) {
                echo 'Править чек';
            } else {
                echo 'Добавить новый чек';
            } ?></h3>
    </div>
    <div class="panel-body">

        <?php if (isset($error) && !is_array($error)) { ?>
            <div class="alert alert-danger alert-dismissible" role="alert">
                <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span
                        class="sr-only">Close</span></button>
                <strong>Error!</strong> <?php echo $error ?>
            </div>
        <?php } ?>

        <form role="form" method="post" id="post-form" action="<?php echo $action ?>">
            <div class="form-group <?php echo $getValidationClass('species') ?>">
                <label class="col-sm-1 control-label">Чек</label>

                <div class="col-sm-2">
                    <input type="text" class="form-control" name="species" placeholder="Наименование чека" value="<?php echo @$post->species ?>">
                    <?php echo $getErrorBody('species')?>
                </div>
            </div>
            <div class="form-group <?php echo $getValidationClass('amount') ?>">
                <label class="col-sm-1 control-label">Сумма</label>

                <div class="col-sm-2">
                    <input type="text" class="form-control" name="amount" value="<?php echo @$post->amount ?>">
                    <?php echo $getErrorBody('amount')?>
                </div>
            </div>
                <label class="col-sm-1 control-label">Комментарий</label>

                <div class="col-sm-3">
                    <input type="text" class="form-control" name="comment" value="<?php echo @$post->comment ?>">
                </div>
                <input type="hidden" name="type_id" value="<?php echo $parentBillTypeId ?>"/>
            <?php $generateToken() ?>

            <div class="btn-group pull-right">
                <button type="submit" class="btn btn-success mr-5">Save</button>
                <a href="/bills" class="btn btn-danger">Cancel</a>
            </div>
        </form>
    </div>
</div>
