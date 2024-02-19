<div class="container-fluid">
    <div class="row">

    </div>
    <div class="row justify-content-center">
    <div class="col-10"><h1 class="mt-4">Carrito</h1></div>
        <div class="table-wrap col-10 ">
            <?php cart_table($conn) ?>
        </div>
        <div class="col-10"><h1 class="mt-4">Comprar</h1></div>
        <?php
        if (!items_carrito() == 0) {
            if (isset($_SESSION["logged_as"])) {
                # Tiene sesion iniciada y puede comprar
                ?>
                <div class="col-lg-4 my-4 ">
                <form action="/cart.php" method="post" >
                    <div class="mb-3">
                        <label for="address" name="address" class="form-label">Dirección:</label>
                        <input type="text" name="address" class="form-control" id="address" required>
                    </div>
                    <button type="submit" class="btn btn-success">Comprar</button>
                </form>
                </div>
                <?php
            } else {
                # Debe iniciar sesion para comprar
                $_SESSION["errors"]["login_cart"] = "Para poder comprar debe iniciar sesión.";
                require '../views/view.error_bubble.php';
                ?>
                <?php
            }
        }
        ?>


    </div>

</div>



