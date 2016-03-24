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
        <h3 class="panel-title"><?php if (isset($billType->id)) {
                echo 'Edit Bill Type';
            } else {
                echo 'Add New Bill Type';
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

        <form class="form-horizontal" role="form" method="post" id="billType-form" action="<?php echo $action ?>">
            <div class="form-group <?php echo $getValidationClass('type') ?>">
                <label class="col-sm-2 control-label">Type</label>

                <div class="col-sm-10">
                    <input type="text" class="form-control" name="type" placeholder="Вид расхода" value="<?php echo @$billType->type ?>">
                    <?php echo $getErrorBody('type')?>
                </div>
            </div>
            <div class="form-group <?php echo $getValidationClass('comment') ?>">
                <label class="col-sm-2 control-label">Content</label>

                <div class="col-sm-10">

                    <div id="editor">
                        <?php echo htmlspecialchars_decode(@$billType->comment) ?>
                    </div>

                    <input type="hidden" name="comment" id="billType-comment" value="">
                    <?php echo $getErrorBody('comment')?>
                </div>
            </div>
            <?php $generateToken() ?>
            <?php
            echo '<input type="hidden" name="parent_id" id="parent_id" value="' . $parentBillTypeId . '">';
            echo $action;
            ?>

            <div class="btn-group pull-right">
                <button type="submit" class="btn btn-success mr-5">Save</button>
                <a href="/" class="btn btn-danger">Cancel</a>
            </div>
        </form>
    </div>
</div>