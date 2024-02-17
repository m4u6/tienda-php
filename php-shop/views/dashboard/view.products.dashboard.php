<!-- Page content-->
<div class="container-fluid">
    <div class="row">
        <div class="col-10"><h1 class="mt-4">Productos</h1></div>
        <div class="col-2 pt-3"><a href="?edit=new" class="btn btn-primary">Nuevo producto</a></div>
    </div>
    <?php 
    # Preparando los datos para mostrar en la tabla
    $data = query_products($conn, $query_productos);
    $data = add_view_product_to_table($data);
    $data = add_edit_product_to_table($data);
    

    # Tabla
    sortable_table($data, $no_sort_array);
    
?>
    
</div>

