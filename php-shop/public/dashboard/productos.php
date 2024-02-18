<?php
require_once '../../config/config.php';
require_once '../../config/db.php';
session_start();
define('PAGE_TITLE', 'Productos');
require_once '../../models/model.dashboard.php';
require_once '../../models/model.edit_product.php';
require_once '../../models/model.products.php';
redirect_non_admin($conn);
require_once '../../views/view.f.sortable_table.php';   # importamos aqui este archivo view por que contiene funciones
require_once '../../views/view.f.product_presentation.php';


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $errors = [];
    # Hay que implementar control de errores (ej is_valid_seo_name()), mirar que no todos los campos esten vacios, ademas del control de las imagenes
    if ($_POST["edit"] == "new" && ! $errors) {
        try {
            add_new_product($_POST["p_name"], $_POST["p_description"], $_POST["seo_name"], $_POST["stock"], $_POST["price"], $conn);
        } catch (Exception $e) {
            $errors["error_new_product"] = $e->getMessage();
        }
    } else {
        if (!$errors) {
            try {
                update_product($_POST["edit"], $_POST["p_name"], $_POST["p_description"], $_POST["seo_name"], $_POST["stock"], $_POST["price"], $conn);
            } catch (Exception $e) {
                $errors["error_update_product"] = $e->getMessage();
            }
        }
    }
    if (isset($_FILES["img"])) {
        #var_dump($_FILES["img"]);
        # Hay problemas cuando se añaden imagenes a un producto que es nuevo.
        # Podemos mover este codigo para que se ejecute despues del bloque que añade el producto. Entonces si $_POST["edit"] == "new"
        # hacemos un query para comprobar cual fue el ultimo producto que se añadio y cogemos su product id.
        if ($_POST["edit"] === "new" ) {
            $product_id = get_last_product_id($conn);
        } else {
            $product_id = $_POST["edit"];
        }
        handle_upload($_FILES["img"], $errors, $product_id, $conn); # Importante la carpeta ../assets/img debe tener permisos apropiados!!
    }
    if ($errors) {
        # cargamos los datos de producto manualmente en la sesion y los volvemos a mandar al editor de producto
        $_SESSION["product_data"] = array(
            "product_id" => $_POST["edit"],
            "p_name" => $_POST["p_name"],
            "p_description" => $_POST["p_description"],
            "seo_name" => $_POST["seo_name"],
            "stock" => $_POST["stock"],
            "price" => $_POST["price"]
        );
        $_SESSION["errors"] = $errors;
        header("Location: productos.php?edit=" . $_POST["edit"]);
        die();

    }
    # Deberia redirigirme otra vez a esta misma pagina despues de ejecutar este bloque de codigo? Asi el navegador no pondra pegas
    # "Firefox must send information that will repeat any action" enviando asi varios post.

}





# Aqui controlamos que es lo que se va a mostrar en la pagina.

if (isset($_GET["edit"])) {
    if ($_GET["edit"] != "new" ) {  
        if (is_valid_product_id($_GET["edit"], $conn) === False) {
            # No es un producto nuevo y se esta intentando editar un producto que no existe
            header("Location: productos.php?edit=new");
            die();
        }
        if (!isset($_SESSION["product_data"])) {
            $_SESSION["product_data"] = load_product_data($_GET["edit"], $conn);    # En algun momento hay que unsetear esto
        }
    };
    require_once '../../views/dashboard/view.head.dashboard.php';
    require_once '../../views/dashboard/view.sidebar.dashboard.php';
    require_once '../../views/dashboard/view.top_navbar.dashboard.php';
    # Actual content of the page
    require_once '../../views/dashboard/view.edit_product.dashboard.php';
} elseif (isset($_GET["view"])) {
    echo "s";
} else {
    require_once '../../views/dashboard/view.head.dashboard.php';
    require_once '../../views/dashboard/view.sidebar.dashboard.php';
    require_once '../../views/dashboard/view.top_navbar.dashboard.php';
    require_once '../../views/dashboard/view.products.dashboard.php';
}











require_once '../../views/dashboard/view.tail.dashboard.php';
unset($_SESSION["product_data"]);





?>