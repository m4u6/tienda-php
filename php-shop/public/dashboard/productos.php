<?php
require_once '../../config/config.php';
require_once '../../config/db.php';
session_start();
define('PAGE_TITLE', 'Productos');
require_once '../../models/model.dashboard.php';
require_once '../../models/model.edit_product.php';
redirect_non_admin($conn);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if ($_POST["edit"] == "new") {
        add_new_product($_POST["p_name"], $_POST["p_description"], $_POST["seo_name"], $_POST["stock"], $conn);
    } else {
        update_product($_POST["edit"], $_POST["p_name"], $_POST["p_description"], $_POST["seo_name"], $_POST["stock"], $conn);
    }

}




require_once '../../views/dashboard/view.head.dashboard.php';
require_once '../../views/dashboard/view.sidebar.dashboard.php';
require_once '../../views/dashboard/view.top_navbar.dashboard.php';
# Actual content of the page
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    if (isset($_GET["edit"])) {
        if ($_GET["edit"] != "new") {
            $_SESSION["product_data"] = load_product_data($product_id, $conn);
        };
        require_once '../../views/dashboard/view.edit_product.dashboard.php';
    } elseif (isset($_GET["view"])) {
        echo "s";
    }
}










require_once '../../views/dashboard/view.tail.dashboard.php';






?>