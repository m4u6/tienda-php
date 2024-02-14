<!-- Page content-->
<div class="container-fluid">
    <div class="row">
        <div class="col-10"><h1 class="mt-4">Productos</h1></div>
        <div class="col-2 pt-3"><a href="?edit=new" class="btn btn-primary">Nuevo producto</a></div>
    </div>
    <?php 
    $data = add_edit_product_to_table(query_products($conn, $query_productos));



    sortable_table($data, $no_sort_array);
    
    ?>
    
</div>

