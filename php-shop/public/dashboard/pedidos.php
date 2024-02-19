<?php
require_once '../../config/config.php';
require_once '../../config/db.php';
session_start();
define('PAGE_TITLE', 'Productos');
require_once '../../models/model.dashboard.php';
require_once '../../models/model.orders.php';
require_once '../../models/model.products.php';
redirect_non_admin($conn);
require_once '../../views/view.f.sortable_table.php';   # importamos aqui este archivo view por que contiene funciones



# Aqui controlamos que es lo que se va a mostrar en la pagina.

if (isset($_GET["view"])) {
    
    require_once '../../views/dashboard/view.head.dashboard.php';
    require_once '../../views/dashboard/view.sidebar.dashboard.php';
    require_once '../../views/dashboard/view.top_navbar.dashboard.php';
    # Actual content of the page
    $where_clause="WHERE order_id=" . $_GET["view"];
    require_once '../../views/dashboard/view.order_details.dashboard.php';
} else {
    require_once '../../views/dashboard/view.head.dashboard.php';
    require_once '../../views/dashboard/view.sidebar.dashboard.php';
    require_once '../../views/dashboard/view.top_navbar.dashboard.php';
    require_once '../../views/dashboard/view.orders.dashboard.php';
}











require_once '../../views/dashboard/view.tail.dashboard.php';
unset($_SESSION["product_data"]);





?>