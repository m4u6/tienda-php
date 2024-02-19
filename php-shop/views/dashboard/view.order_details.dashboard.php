<!-- Page content-->
<div class="container-fluid">
    <div class="row">
        <div class="col-10"><h1 class="mt-4">Informacion pedido ID <?=$_GET["view"]?></h1></div>
    </div>
    <?php 
    # Preparando los datos para mostrar en la tabla
    $data = query_table($conn, "orders_products", $query_order_details, $where_clause);
    #$data = add_view_order_to_table($data);
    #$data = add_edit_product_to_table($data);
    $data = add_p_name_to_table($data, $conn);
    

    # Tabla
    sortable_table($data, $no_sort_array);
    
?>
    
</div>

