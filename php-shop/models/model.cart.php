<?php

# Los productos que contiene el carrito se guardaran en un array $_SESSION["cart_array"] donde cada item sera otro array ["product_id" => $id, "units" => units]

function add_to_cart($product_id, $units, &$errors) {
    if (isset($_SESSION["cart_array"]) === False) {
        # Si no esta creado el carrito lo creamos como un array vacio
        $_SESSION["cart_array"] = [];
    } 
    
    
    # Comprobamos si esta en el carrito ya y actualizamos $total_units
    if (isset($_SESSION["cart_array"][$product_id])) {
        # Esta en el carrito
        $total_units = $_SESSION["cart_array"][$product_id]+$units;
    } else {
        $total_units = $units;
    }

    # Comprobamos si hay stock suficiente para $total_units
    $stock = load_product_data($product_id, $conn)["stock"];
    if ($stock == 0) {
        # No hay stock no se puede añadir al carrito
        $errors["no_stock"] = "No tenemos stock de este producto";
        throw new Exception("No tenemos stock de este producto");
    } elseif ($stock < $total_units) {
        # Se han pedido mas unidades de las disponibles
        $errors["stock_enough"] = "No tenemos tantas unidades en stock, hemos actualizado tu carrito";
        $total_units = $stock;
    }

    # Llegados aqui no añadimos el producto al carrito
    $_SESSION["cart_array"][$product_id] = $total_units;
    return True;

}


