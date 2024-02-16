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
    <section class="py-5">
            <div class="container px-4 px-lg-5 mt-5">
                <div class="row gx-4 gx-lg-5 row-cols-2 row-cols-md-3 row-cols-xl-4 justify-content-center">
                    <div class="col mb-5">
                    
     
    <?php product_card($conn, 1) ?>

    </div>
                    </div>
                </div>
        </section>
    
</div>

