<!-- Page content-->
<div class="container-fluid">
    <h1 class="mt-4">Productos</h1>
    <a href="?edit=new">Nuevo producto</a>
    <?php var_dump(query_products($conn, $query1)); 
    
    sortable_table(query_products($conn, $query1), $no_sort_array);
    
    ?>


