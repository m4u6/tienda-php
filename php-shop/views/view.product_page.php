<!-- Product section-->
<section class="py-5">
            <div class="container px-4 px-lg-5 my-5">
                <div class="row gx-4 gx-lg-5 align-items-center">
                    <div class="col-md-6"><img class="card-img-top mb-5 mb-md-0" src="<?=$product_data["imgs"][0]?>" alt="..." /></div>
                    <div class="col-md-6">
                        <div class="small mb-1"><?=stock_message($product_data["stock"])?></div>
                        <h1 class="display-5 fw-bolder"><?=$product_data["p_name"]?></h1>
                        <div class="fs-5 mb-5">
                            <!-- <span class="text-decoration-line-through"><?=$product_data["price"]?></span> -->
                            <span><?=$product_data["price"]?> <?=CURRENCY_SYMBOL?></span>
                        </div>
                        <p class="lead"><?=$product_data["p_description"]?></p>
                        <form method="post" action="/cart.php">
                            <div class="d-flex">
                                <input type="hidden" name="seo_name_carrito" value="<?=$product_data["seo_name"]?>">
                                <input class="form-control text-center me-3" name="cantidad_unidades" id="cantidad_unidades" type="num" value="1" style="max-width: 3rem" />
                                <button class="btn btn-outline-dark flex-shrink-0" type="submit">
                                    <i class="bi-cart-fill me-1"></i>
                                    Añadir al carrito
                                </button>
                            </div>
                        <form>
                    </div>
                </div>
            </div>
        </section>