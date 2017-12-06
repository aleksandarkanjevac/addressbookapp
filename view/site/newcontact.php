<div class="container">
    <div class="row">
        <div class="col-md-7 col-md-offset-2">
            <div class="form">

                <!--FORM-->
                <form class="form-horizontal" action="#" method="POST" enctype="multipart/form-data">
                    <span class="error"><?= (array_key_exists('empty', $errors) ? $errors['empty'] : ''); ?></span>
                    <span class="error"><?= (array_key_exists('empty_f', $errors) ? $errors['empty_f'] : ''); ?></span>
                    <!--First Name-->
                    <div class="form-group">
                        <input type="text" class="form-control" id="addname" name="addName" placeholder="First Name" value="<?= $fname ?>" autofocus><span id="adderr1"></span>
                    </div>
                    <!--Last Name-->
                    <div class="form-group">
                        <input type="text" class="form-control" id="addlname" name="addLastName" placeholder="Last Name" value="<?= $lname ?>"><span id="adderr2"></span>
                    </div>
                    <!--Email-->
                    <div class="form-group">
                        <input type="email" class="form-control" id="Email" name="addEmail" placeholder="Email" value="<?= $email ?>"><span id="adderr3"></span>
                    </div>
                    <!--Phone-->
                    <div class="form-group">
                        <input type="text" class="form-control" id="phone" name="addPhone" placeholder="Phone" value="<?= $phone ?>"><span id="adderr4"></span>
                    </div>
                    <!--Address-->
                    <div class="form-group">
                        <input type="text" class="form-control" id="address" name="addAddress" placeholder="Address" value="<?= $address ?>"><span id="adderr5"></span>
                    </div>
                    <!--Acess-->
                    <span class="error"><?= (array_key_exists('access', $errors) ? $errors['access'] : ''); ?></span>
                    <div id="select" class="form-group">
                        <label class="radio-inline"> <input type="radio" name="selectadd" id="select1" value="1"  style="margin-bottom: 10px">Lowest access </label>
                        <label class="radio-inline"> <input type="radio" name="selectadd" id="select2" value="2"  style="margin-bottom: 10px">Middle access </label>
                        <label class="radio-inline"> <input type="radio" name="selectadd" id="select3" value="3"  style="margin-bottom: 10px">Privileged access </label><span id="access"></span>
                    </div>
                    <!--End access-->
                    <!-- Upload img & Submit-->
                    <span class="error"><?= (array_key_exists('img_size', $errors) ? $errors['img_size'] : ''); ?></span>
                    <span class="error"><?= (array_key_exists('img_type', $errors) ? $errors['img_type'] : ''); ?></span>
                    <div class="form-group">
                        <input type="file" name="image" id="fileToUpload">
                        <button style="float: right;" type="submit" id="add_contact" name="addcontact" class="btn btn-info">Add contact</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
