<?php
require_once 'config/config.php';
require_once 'config/db.php';
define('PAGE_TITLE', 'Index');
include 'includes/header.inc.php';



$query = "SELECT * FROM users;";
$results = mysqli_query($conn, $query);


include 'includes/footer.inc.php';
?>
