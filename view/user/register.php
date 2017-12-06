<!--Registration form-->
<section clas="main-container">
    <div class="container">
        <div class="row">
            <div class="col-md-7 col-md-offset-2">
                <div class="form-block">
                    <h3>Register</h3>
                    <div class="form">
                        <form action="#" method="POST">
                            <span class="error"><?= (array_key_exists('empty_fields', $errors) ? $errors['empty_fields'] : ''); ?></span>
                            <div class="form-group has-success">
                                <input type="text" class="form-control" placeholder="First Name" name="fname" autofocus value="<?= $fname;?>">
                            </div>
                            <div class="form-group has-success">
                                <input type="text" class="form-control" placeholder="Last Name" name="lname" autofocus value="<?= $lname;?>">
                            </div>
                            <div class="form-group has-success">
                                <input type="email" class="form-control" placeholder="Email" name="email" value="<?= $email;?>">
                                <span class="error"><?= (array_key_exists('email_used', $errors) ? $errors['email_used'] : ''); ?></span>
                            </div>
                            <div class="form-group has-success">
                                <input type="password" class="form-control" placeholder="Password" name="password" value="<?= $password;?>">
                                <span class="error"><?= (array_key_exists('pass_str', $errors) ? $errors['pass_str'] : ''); ?></span>
                            </div>
                            <div class="form-group has-success">
                                <input type="password" class="form-control" placeholder="Confirm Password" name="password_confirm" value="<?= $pwdconfirm;?>">
                                <span class="error"><?= (array_key_exists('pass_conf', $errors) ? $errors['pass_conf'] : ''); ?></span>
                            </div>
                            <div class="form-group has-success">
                                <label class="radio-inline">
                                        <input type="radio" name="select"  value="1"> Low
                                    </label>
                                <label class="radio-inline">
                                        <input type="radio" name="select"  value="2">  Middle
                                    </label>
                                <label class="radio-inline">
                                        <input type="radio" name="select"  value="3"> Privileged
                                    </label>
                            </div>
                            <button type="submit" class="btn btn-success custom-btn" name="register">Register</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>







<!--REGISTRATION FORM-->


<!--<form id="myForm" class="form-horizontal" action="#" method="POST">
    <span class="error"style="margin-left: 42%;"><?= (array_key_exists('empty_fields', $errors) ? $errors['empty_fields'] : ''); ?></span> 
    <br><br>



    <div id="fname" class="form-group required">
        <label for="fname" class="control-label col-md-4  requiredField"> First  Name<span class="asteriskField" style="color:red;">*</span> </label>
        <div class="controls col-md-4 ">

            <input class="input-md  textinput textInput form-control" id="form1" maxlength="30" name="fname" placeholder="First Name" style="margin-bottom: 10px" type="text" value="<?= $fname ?>" autofocus/>
            <span id="erro1"></span> </div>
    </div>

</div>

<div id="lname" class="form-group required">
    <label for="lname" class="control-label col-md-4  requiredField"> Last  Name<span class="asteriskField" style="color:red;">*</span> </label>
    <div class="controls col-md-4 ">

        <input class="input-md  textinput textInput form-control" id="form2" maxlength="30" name="lname" placeholder="Last Name" style="margin-bottom: 10px" type="text" value="<?= $lname ?>"/>
        <span id="err2"></span> </div>

</div>




<div id="email" class="form-group required">
    <label for="email" class="control-label col-md-4  requiredField"> E-mail<span class="asteriskField" style="color:red;">*</span> </label>
    <div class="controls col-md-4 ">
        <input class="input-md emailinput form-control" id="form3" name="email" placeholder="Enter your E-mail" style="margin-bottom: 10px" type="email" value="<?= $email ?>"/>
        <span id="err3"></span>       

    </div>

    <span class="error"style="margin-left: 42%;"><?= (array_key_exists('email_used', $errors) ? $errors['email_used'] : ''); ?></span>
    
</div>


<div id="password1" class="form-group required">
    <label for="password1" class="control-label col-md-4  requiredField">Password<span class="asteriskField" style="color:red;">*</span> </label>
    <div class="controls col-md-4 ">
        <input class="input-md textinput textInput form-control" id="form4" name="password1" placeholder="Create a password" style="margin-bottom: 10px" type="password" value="<?= $password ?>"/>
        <span id="err4"></span>
    </div>

    <span class="error"style="margin-left: 42%;"><?= (array_key_exists('pass_str', $errors) ? $errors['pass_str'] : ''); ?></span> 

</div>
<div id="password2" class="form-group required">
    <label for="password2" class="control-label col-md-4  requiredField"> Re:password<span class="asteriskField" style="color:red;">*</span> </label>
    <div class="controls col-md-4 ">
        <input class="input-md textinput textInput form-control" id="form5" name="password2" placeholder="Confirm your password" style="margin-bottom: 10px" type="password" value="<?= $pwdconfirm?>" />
        <span id="err5"></span>
    </div>

    <span class="error"style="margin-left: 42%;"><?= (array_key_exists('pass_conf', $errors) ? $errors['pass_conf'] : ''); ?></span> 

</div>



<div id="select" class="form-group required">
    <label for="select" class="control-label col-md-4  requiredField">Access<span class="asteriskField" style="color:red;">*</span> </label>
    <div id="form6" class="controls col-md-4 " style="margin-bottom: 10px">

        <label class="radio-inline"> <input type="radio" name="select" id="select_1" value="1"  style="margin-bottom: 10px">Low access </label>
        <label class="radio-inline"> <input type="radio" name="select" id="select_2" value="2"  style="margin-bottom: 10px">Middle access </label>
        <label class="radio-inline"> <input type="radio" name="select" id="select_3" value="3"  style="margin-bottom: 10px">Privileged access </label><span id="err6"></span>
    </div>

</div>

<div class="form-group">
    <div class="col-md-4 "></div>
    <div class="controls col-md-4 ">

        <input type="submit" name="register" value="Register" class="btn btn btn-info" id="register" />

    </div>
</div>


</form>-->
