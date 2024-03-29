<?php

$query_orders = array(
    # columna => as alias 
    "order_id" => "ID Pedido",
    "user_id" => "ID Usuario",
    "checkout_price" => "Precio total",
    "order_address" => "Direccion",
    "order_date" => "Fecha"
);

$query_order_details = array(
    # columna => as alias 
    "order_product_id" => "ID",
    "order_id" => "ID Pedido",
    "product_id" => "ID Producto",
    "price_per_unit" => "Precio/unidad",
    "quantity" => "Unidades"
);





function add_view_order_to_table($data) {
    for ($i = 1; $i <= count($data); $i++) {
        #$edit_array = array("Edit" => "<a href=\"productos.php?edit=$data[$i][\"ID\"]\">Editar producto</a>");
        $order_id=$data[$i]["ID Pedido"];
        $data[$i]["Info"] = "<a href=\"pedidos.php?view=$order_id\">Ver pedido</a>";
        
    }
    return $data;
}


# for order details
function add_p_name_to_table($data, $conn) {
    for ($i = 1; $i <= count($data); $i++) {
        #$edit_array = array("Edit" => "<a href=\"productos.php?edit=$data[$i][\"ID\"]\">Editar producto</a>");
        $product_id=$data[$i]["ID Producto"];
        $p_name=product_id_to_name($conn, $product_id);
        $seo_name=product_id_to_seo_name($conn, $product_id);
        $data[$i]["Pagina prod"] = "<a href=\"/producto/$seo_name\">$p_name</a>";
        
    }
    return $data;
}