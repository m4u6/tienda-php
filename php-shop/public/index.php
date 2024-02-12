<?php
require_once 'config/config.php';
require_once 'config/db.php';
define('PAGE_TITLE', 'Index');
require_once 'includes/header.inc.php';



$query = "SELECT * FROM users;";
$results = mysqli_query($conn, $query);


require_once 'includes/footer.inc.php';
?>
