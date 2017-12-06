<?php
    include '../core/init.php';

$req = array_key_exists('r', $_GET) ? $_GET['r'] : 'site/index';

\core\Router::proccess($req);
