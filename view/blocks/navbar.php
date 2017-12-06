<?php
include "../core/autoload.php";
?>
    <nav class="navbar navbar-inverse">
        <div class="container-fluid">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header">
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
                  <span class="sr-only">Toggle navigation</span>
                  <span class="icon-bar"></span>
                  <span class="icon-bar"></span>
                  <span class="icon-bar"></span>
                </button>
            </div>

            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                <ul class="nav navbar-nav">
                    <?php
            if (!core\App::is_guest()) {
                echo "<li><a id='addrssbtn' name='addresses' href= 'index.php?r=site/addressbook'>ADDRESSBOOK</a></li>
                <li><a id='addnewbtn' name='addnewcontact' href= 'index.php?r=site/newcontact'>ADD NEW CONTACT</a></li>
                <li><a href='index.php?r=user/logout'>Logout</a></li>";

            }else {
                echo "<li><a id='loginbtn' name='login' href= 'index.php?r=user/login'>LOGIN</a></li>";
                
            }
    ?>
                </ul>
                <ul class="nav navbar-nav navbar-right">
                    <?php
        if (!core\App::is_guest() && isset($_SESSION["email"])) {

                    echo "<li style='color:white; top:9px;'>Active user: " . $_SESSION["email"] . "</li>";
                } else {

                    echo "";
                }
    ?>
                </ul>
            </div>
            <!-- /.navbar-collapse -->
        </div>
        <!-- /.container-fluid -->
    </nav>
