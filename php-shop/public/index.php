<?php
require_once '../config/config.php';
require_once '../config/db.php';
session_start();
define('PAGE_TITLE', 'Index');
require_once '../views/view.header.php';

echo $_SESSION["logged_as"]["u_name"];

require_once '../views/view.footer.php';
?>




