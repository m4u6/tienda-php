<?php
require_once 'includes/config.php';
require_once 'includes/db.php';
define('PAGE_TITLE', 'Index');
include 'includes/header.inc.php';



$query = "SELECT * FROM users;";
$results = mysqli_query($conn, $query);


include 'includes/footer.inc.php';
?>
