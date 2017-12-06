<!--Login form-->
<section clas="main-container">
    <div class="container">
        <div class="row">
            <div class="col-md-7 col-md-offset-2">
                <div class="form-block">
                    <h3>Login</h3>
                    <div class="form">
                        <form action="#" method="POST">
                            <span class="error"><?= (array_key_exists('empty_fields', $errors) ? $errors['empty_fields'] : ''); ?></span>
                            <div class="form-group has-success">
                                <span class="mssg"><?=$mssg?></span>
                                <input type="email" class="form-control" placeholder="Enter email" name="email" value="<?= $email;?>">
                                <span class="error"><?= (array_key_exists('email_confirm', $errors) ? $errors['email_confirm'] : ''); ?></span>
                            </div>
                            <div class="form-group has-success">
                                <input type="password" class="form-control" placeholder="Enter Password" name="password" value="<?= $password;?>">
                                <span class="error"><?= (array_key_exists('wrong_pass', $errors) ? $errors['wrong_pass'] : ''); ?></span>
                            </div>
                            <div class="form-group">
                                <button type="submit" class="btn btn-success custom-btn" name="login">Login</button>
                            </div>
                            <div class="form-group">
                                <center><a class="link" href="index.php?r=user/register">Create an account</a></center>
                            </div>
                        </form>
                    </div>
                    <a class="link" href="index.php?r=user/forgot">Forgot password?</a>
                </div>
            </div>
        </div>
    </div>
</section>
