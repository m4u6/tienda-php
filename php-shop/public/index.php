<?php
require_once '../config/config.php';
require_once '../config/db.php';
session_start();

require_once '../models/model.dashboard.php';
define('PAGE_TITLE', 'Index');
require_once '../views/view.header.php';


echo $_SESSION["logged_as"]["u_name"];
var_dump($_SESSION["logged_as"]);

require_once '../views/view.footer.php';
?>





