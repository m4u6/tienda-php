<?php
function product_card($conn, $product_id) {
    $data = get_product_data_imgs($conn, $product_id);
    if ($data == false) {
        return false;
    }
    ?>
    <div class="col mb-5">
    <div class="card h-100">
        <img class="card-img-top" src="<?=$data["imgs"][0]?>" alt="Product Image" style="object-fit: cover; height: 200px;">
        <div class="card-body p-4">
            <div class="text-center">
                <h5 class="fw-bolder"><?=$data["p_name"]?></h5>
                <?=$data["price"]?> <?=CURRENCY_SYMBOL?>
            </div>
        </div>
        <div class="card-footer p-4 pt-0 border-top-0 bg-transparent">
            <div class="text-center">
                <a class="btn btn-outline-dark mt-auto" href="/producto/<?=$data["seo_name"]?>">Ver más</a>
            </div>
        </div>
    </div>
    </div>
    <?php
}


function render_product_listings($conn, $product_id_array) {
    # Esta funcion espera un array de product_id. Usara la fuincion product_card() para crear cada una de las tarjetas
    echo "<section class=\"py-5\">\n";
    echo "<div class=\"container px-4 px-lg-5 my-5\">\n";
    echo "<div class=\"row gx-4 gx-lg-5 row-cols-2 row-cols-md-3 row-cols-xl-4 justify-content-center\">\n";
    foreach ($product_id_array as $product_id) {
        product_card($conn, $product_id);
    }
    echo "</div>\n";
    echo "</div>\n";
    echo "</section>\n";
}

