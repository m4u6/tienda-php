<?php
require_once '../config/config.php';
require_once '../config/db.php';
session_start();

require_once '../models/model.dashboard.php';
require_once '../models/model.login.php';
require_once '../models/model.products.php';

define('PAGE_TITLE', 'Index');
require_once '../views/view.f.product_presentation.php';
#require_once '../views/view.header.php';



if (isset($_GET["seo_name"])) { # Ver pagina de producto
    try {
        $product_id = seo_name_to_id($conn, $_GET["seo_name"]);
    } catch (Exception $e) {
        # Si la funcion levanta una excepcion significa que el producto no existe, asi que redireccionamos a la pagina principal
        header("Location: /");
        die();
    }
    # Si llegamos aqui es que el seo_name tiene un producto relacionado, cargamos la vista de la pagina de producto
    require_once '../views/view.header.php';
    require_once '../views/view.product_page.php';
} elseif (isset($_GET["search"])) { # Busquedas / otros ordenes para los productos
    require_once '../views/view.header.php';
    echo "busca";
} else { # Si se entra a la pagina normal
    require_once '../views/view.header.php';
    $product_id_array = array(1, 2, 3, 4, 5, 6, 7, 8);
    render_product_listings($conn, $product_id_array);
}
    


# Si se entra a la pagina normal




# Busquedas / otros ordenes para los productos








#echo $_SESSION["logged_as"]["u_name"];
#var_dump($_SESSION["logged_as"]);






require_once '../views/view.footer.php';
?>





