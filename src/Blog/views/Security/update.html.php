<div class="container">

    <?php if (!isset($errors)) {
        $errors = array();
    } ?>

    <form class="form-signin" role="form" method="post" action="<?php echo $action ?>">
        <h2 class="form-signin-heading">Prifile info</h2>
        <?php foreach ($errors as $error) { ?>
            <div class="alert alert-danger alert-dismissible" role="alert">
                <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span
                        class="sr-only">Close</span></button>
                <strong>Error!</strong> <?php echo $error ?>
            </div>
        <?php } ?>
        <input type="email" class="form-control" value="<?php echo @$user->email ?>" placeholder="<?php echo @$user->email ?>" required autofocus name="newEmail">
        <input type="password" class="form-control" placeholder="New password" name="newPassword">
        <button class="btn btn-lg btn-primary btn-block" type="submit">Edit Profile</button>
        <a href="/" class="btn btn-lg btn-danger  btn-block">Cancel</a>
        <?php $generateToken()?>
    </form>

</div>