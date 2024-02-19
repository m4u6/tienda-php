<?php
require_once '../config/config.php';
require_once '../config/db.php';
session_start();

require_once '../models/model.dashboard.php';
require_once '../models/model.login.php';
require_once '../models/model.products.php';
require_once '../models/model.search.php';

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
    $product_data = get_product_data_imgs($conn, $product_id);
    

    define('PAGE_TITLE', $product_data["p_name"]);
    require_once '../views/view.header.php';
    require_once '../views/view.error_bubble.php';
    require_once '../views/view.product_page.php';
    
    # Productos relacionados
    # Hacemos una busqueda de todos los productos, barajamos el array y nos quedamos con los n primeros items del array.
    $related_products_id=search_product($conn, $_GET["search"], "p_name", "DESC", TRUE, 1000);
    shuffle($related_products_id);
    $related_products_id=array_slice($related_products_id, 0, NUMBER_RECOMMENDED_ITEMS);

    render_product_listings($conn, $related_products_id, "Productos relacionados");
} elseif (isset($_GET["search"])) { # Busquedas / otros ordenes para los productos
    require_once '../views/view.header.php';
    $product_id_array = search_product($conn, $_GET["search"], "p_name", "DESC", TRUE, 32);
    render_product_listings($conn, $product_id_array);
} else { # Si se entra a la pagina normal
    define('PAGE_TITLE', 'Index');
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





