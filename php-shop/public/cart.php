<?php
require_once '../config/config.php';
require_once '../config/db.php';
session_start();

require_once '../models/model.dashboard.php';
require_once '../models/model.login.php';
require_once '../models/model.products.php';
require_once '../models/model.search.php';
require_once '../models/model.cart.php';


require_once '../views/view.f.product_presentation.php';



if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST["address"])) {
        buy_cart($conn, $_POST["address"]);
    }
    $errors = [];
    
    # Este codigo se mueve a la funcion que añade productos al carrito
    #if (isset($_SESSION["cart_array"]) === False) {
    #    # Si no esta creado el carrito lo creamos como un array vacio
    #    $_SESSION["cart_array"] = [];
    #} 

    if (isset($_POST["seo_name_carrito"])) {
        try {
            $product_id = seo_name_to_id($conn, $_POST["seo_name_carrito"]);
        } catch (Exception $e) {
            # Este bloque de codigo se ejecuta cuando no podemos obtener el product_id del producto
            $errors["unable_get_product_id"] = "Hubo un error añadiendo el producto al carrito. Intentelo mas tarde o contacte con soporte.";
            $_SESSION["errors"] = $errors;
            header("Location: ". $_SERVER["HTTP_REFERER"]);
            die();
        }
    }
    # Hay que comprobar si el producto ya esta en el carrito -> Se hace en la funcion

    if (isset($_POST["cantidad_unidades"])) {
        try {
            add_to_cart($product_id, intval($_POST["cantidad_unidades"]), $errors, $conn);
        } catch (Exception $e) {
            $errors["bad_cart"] = "El producto no se pudo añadir al carrito";
        }
    }

    if ($errors) { 
        $_SESSION["errors"] = $errors;
        header("Location: ". $_SERVER["HTTP_REFERER"]);
        die();
    }

    # Si llegamos aqui es que no hay errores y el podemos añadir al carrito.
    #$_SESSION["cart_array"][] = ["product_id" => $product_id, "units" => $_POST["cantidad_unidades"]];
    #$_SESSION["cart_array"]["product_id"] = $_POST["cantidad_unidades"];


    # Una vez añadido el item al carrito, volvemos a donde estaba el usuario
    header("Location: ". $_SERVER["HTTP_REFERER"]);
    die();
}

require_once '../views/view.header.php';

cart_table($conn);
?>


<form method="post" action="/cart.php">
    <input type="text" name="address">
    <input type="submit">
</form>


<?php



require_once '../views/view.footer.php';
?>





