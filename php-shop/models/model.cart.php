<?php

# Los productos que contiene el carrito se guardaran en un array $_SESSION["cart_array"] donde cada el key sera el product_id y el value sera el numero de items

function add_to_cart($product_id, $units, &$errors, $conn) {
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
    $stock = intval(load_product_data($product_id, $conn)["stock"]);
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

# Esta funcion es mitad view, pero bueno...
function cart_table($conn) {
    # La tabla tendra las columnas: nombre producto - precio por unidad - unidades - precio total
    # No hacer la tabla si no hay productos en el carrito !!
    # Añadir


    if (@count($_SESSION["cart_array"]) == 0) {
        echo "No hay productos en el carrito";
        return False;
    }


    # Table head 
    ?>
    <table class="table mx-2">
    <thead class="thead-dark">
    <tr>
      <th scope="col">Producto</th>
      <th scope="col">Precio por unidad</th>
      <th scope="col">Unidades</th>
      <th scope="col">Total</th>
    </tr>
    </thead>
    <tbody>
    <?php
    $running_total=0;
    foreach ($_SESSION["cart_array"] as $product_id => $units) {
        $datos_producto = get_product_data_imgs($conn, $product_id);
        echo "<tr>\n";
            echo "<td><a href=\"/producto/" . $datos_producto["seo_name"] . "\">" . $datos_producto["p_name"] . "</a></td>";
            echo "<td>" . $datos_producto["price"] . " " . CURRENCY_SYMBOL . "</td>";
            echo "<td>$units</td>";
            $total = floatval($datos_producto["price"]) * intval($units);
            echo "<td>$total " . CURRENCY_SYMBOL . "</td>";
        echo "</tr>\n";
        $running_total+=$total;
    }
    echo "<tr><td><b>Total:</b></td><td>$running_total " . CURRENCY_SYMBOL . "</td></tr>";
    echo "</tbody>\n";
    echo "</table>\n";
}

function items_carrito() {
    if (@count($_SESSION["cart_array"]) == 0) {
        return 0;
    } else {
        return @count($_SESSION["cart_array"]);
    }
}

function total_price_cart($conn) {
    $running_total=0;
    foreach ($_SESSION["cart_array"] as $product_id => $units) {
        $datos_producto = get_product_data_imgs($conn, $product_id);
        $total_item = floatval($datos_producto["price"]) * intval($units);
        $running_total+=$total_item;
    }
    return $running_total;
}



function buy_cart($conn, $order_address,$user_id=NULL) {
    if ($user_id === NULL) {
        $user_id = $_SESSION["logged_as"]["user_id"];
    }

    $insert_query = "INSERT INTO orders (user_id, checkout_price, order_address) VALUES ($user_id, " . total_price_cart($conn) . ")";
    
    if ($mysqli->query($insert_query) === true) {
        # No ha habido errores, nos guardamos el order_id
        $order_id = $mysqli->insert_id;
        echo "Order placed successfully. Order ID: $order_id";
    } else {
        throw new Exception($mysqli->error);
    }

    # Ya hemos creado el pedido ahora tenemos que añadir los productos al pedido (tabla orders-products)
    foreach ($_SESSION["cart_array"] as $product_id => $units) {
        $datos_producto = get_product_data_imgs($conn, $product_id);
        $insert_query = "INSERT INTO orders-products (order_id, product_id, price_per_unit, quantity) VALUES ($order_id, $product_id," . floatval($datos_producto["price"]) .", $units)";          
        $mysqli->query($insert_query);
    }
}

?>
