<?php
function product_card($conn, $product_id) {
    $data = get_product_data_imgs($conn, $product_id);
    if ($data == false) {
        return false;
    }
    ?>
    <div class="card h-100">
        <img class="card-img-top" src="<?=$data["imgs"][0]?>" alt="Product Image" style="object-fit: cover; height: 200px;">
        <div class="card-body p-4">
            <div class="text-center">
                <h5 class="fw-bolder"><?=$data["p_name"]?></h5>
                <?=$data["price"][0]?><?=CURRENCY_SYMBOL?>
            </div>
        </div>
        <div class="card-footer p-4 pt-0 border-top-0 bg-transparent">
            <div class="text-center">
                <a class="btn btn-outline-dark mt-auto" href="/productos/<?=$data["seo_name"]?>">Ver más</a>
            </div>
        </div>
    </div>
    <?php
}
?>

