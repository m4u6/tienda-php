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
    # La tabla tendra las columnas: nombre producto - precio por unidad - unidades - precio total, y la 
    echo "<table class=\"table\">\n";
    # Table head ?>
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
    foreach ($_SESSION["cart_array"] as $product_id => $units) {
        $datos_producto = get_product_data_imgs($conn, $product_id);
        echo "<tr>\n";
            echo "<td><a href=\"/producto/" . $datos_producto["seo_name"] . "\">" . $datos_producto["p_name"] . "</a></td>";
            echo "<td>" . $datos_producto["price"] . " " . CURRENCY_SYMBOL . "</td>";
            echo "<td>$units</td>";
            $total = floatval($datos_producto["price"]) * intval($units);
            echo "<td>$total " . CURRENCY_SYMBOL . "</td>";
        echo "</tr>\n";
    }
    echo "</tbody>\n";
    echo "</table>\n";
}