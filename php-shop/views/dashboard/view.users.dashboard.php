<!-- Page content-->
<div class="container-fluid">
    <div class="row">
        <div class="col-10"><h1 class="mt-4">Usuarios</h1></div>
    </div>
    <?php 
    # Preparando los datos para mostrar en la tabla
    $data = query_table($conn, "users", $query_usuarios);
    #$data = add_view_order_to_table($data);
    #$data = add_edit_product_to_table($data);
    #$data = add_p_name_to_table($data, $conn);
    

    # Tabla
    sortable_table($data, $no_sort_array);
    
?>
    
</div>
