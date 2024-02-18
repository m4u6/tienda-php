<?php

function search_product($conn, $search_term, $order_by="p_name", $asc_desc="DESC", $show_out_stock=TRUE, $limit=32) {
    # Si, es vulnerable a sql injections :1

    $product_ids = array();

    $query = "SELECT product_id FROM products WHERE ";
    # Incluimos tambien 
    $query .= "(p_name LIKE '%$search_term%' OR p_description LIKE '%$search_term%')";

    # Mostrar o no productos sin stock
    if ($show_out_stock == false) {
        $query .= " AND stock > 0";
    }

    # Order by
    $query .= " ORDER BY $order_by $asc_desc";

    # Limit
    $query .= " LIMIT $limit";

    $result = mysqli_query($conn, $query);

    if ($result) {
        while ($row = mysqli_fetch_assoc($result)) {
            $product_ids[] = $row['product_id'];
        }
        mysqli_free_result($result);
    } else {
        # Si falla devolvemos un array vacio
        return $product_ids;
    }

    return $product_ids;
}