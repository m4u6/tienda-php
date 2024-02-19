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
<div class="row">
    <div class="col-10"><h3 class="mt-4">Eliminar productos</h3></div>
</div>
<form action="/dashboard/productos.php" method="post" >
    <div class="mb-3 col-2">
            <label for="delete_product" name="delete_product" class="form-label">ID Producto:</label>
            <input type="number" step="1" min="0" name="delete_product" class="form-control" id="delete_product" required>
        </div>
    <button type="submit" class="btn btn-danger">Eliminar</button>
</form>
</div>

