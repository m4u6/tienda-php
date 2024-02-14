<!-- Page content-->
<div class="container-fluid">
    <h1 class="mt-4">Productos</h1>
    <a href="?edit=new">Nuevo producto</a>
    <?php 
    var_dump(query_products($conn, $query1)); 
    var_dump($query_produtos);
    $data = add_edit_product_to_table(query_products($conn, $query_productos));



    sortable_table($data, $no_sort_array);
    
    ?>
</div>

