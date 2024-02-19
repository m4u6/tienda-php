<?php

# Los productos que contiene el carrito se guardaran en un array $_SESSION["cart_array"] donde cada item sera otro array ["product_id" => $id, "units" => units]

function add_to_cart($product_id, $units) {
    if (isset($_SESSION["cart_array"]) === False) {
        # Si no esta creado el carrito lo creamos como un array vacio
        $_SESSION["cart_array"] = [];
    } 

    
}