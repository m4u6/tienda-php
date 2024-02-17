<?php
require_once '../config/config.php';
require_once '../config/db.php';
session_start();

require_once '../models/model.dashboard.php';
require_once '../models/model.login.php';
require_once '../models/model.products.php';
define('PAGE_TITLE', 'Index');
require_once '../views/view.f.product_presentation.php';

require_once '../views/view.header.php';


#echo $_SESSION["logged_as"]["u_name"];
#var_dump($_SESSION["logged_as"]);

$product_id_array = array(1, 2, 3, 4, 5);
render_product_listings($conn, $product_id_array);

require_once '../views/view.footer.php';
?>





