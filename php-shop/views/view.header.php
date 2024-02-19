<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title><?php print_r(PAGE_TITLE) ?></title>
        <!-- Favicon-->
        <link rel="icon" type="image/x-icon" href="/assets/favicon.ico" />
        <!-- Bootstrap icons-->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css" rel="stylesheet" />
        <!-- Core theme CSS (includes Bootstrap)-->
        <link href="/css/styles.css" rel="stylesheet" />
        <link href="/css/main.css" rel="stylesheet" />
        <link href="/css/sortable-table.css" rel="stylesheet" />
    </head>
    <body>
        <!-- Navigation-->
        <nav class="navbar navbar-expand-lg navbar-light bg-light">
            <div class="container px-4 px-lg-5">
                <a class="navbar-brand" href="/index.php">Tienda PHP</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation"><span class="navbar-toggler-icon"></span></button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav me-auto mb-2 mb-lg-0 ms-lg-4">
                        <li class="nav-item"><a class="nav-link active" aria-current="page" href="#!">Home</a></li>
                        <li class="nav-item"><a class="nav-link" href="https://github.com/m4u6/tienda-php">About</a></li>
                        <!--<li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" id="navbarDropdown" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">Shop</a>
                            <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                                <li><a class="dropdown-item" href="#!">All Products</a></li>
                                <li><hr class="dropdown-divider" /></li>
                                <li><a class="dropdown-item" href="#!">Popular Items</a></li>
                                <li><a class="dropdown-item" href="#!">New Arrivals</a></li>
                            </ul>
                        </li>-->
                        <?php echo is_logged($conn) ? "" : "<li class=\"nav-item\"><a class=\"nav-link\" href=\"/login.php\">Login</a></li>" ?>
                        <?php echo is_logged($conn) ? "" : "<li class=\"nav-item\"><a class=\"nav-link\" href=\"/signup.php\">Registrarse</a></li>" ?>
                        <?php echo admin_check($conn) ? "<li class=\"nav-item\"><a class=\"nav-link\" href=\"/dashboard/\">Dashboard</a></li>" : "" ?>
                        <?php echo is_logged($conn) ? "<li class=\"nav-item\"><a class=\"nav-link\" href=\"/logout.php\">Cerrar sesión</a></li>" : "" ?>
                    </ul>
                    
                    <form method="get" action="/index.php" class="d-flex form-inline my-2 my-lg-0 mx-2">
                        <input class="form-control mr-sm-2" name="search" type="search" placeholder="Buscar" aria-label="Buscar">
                        <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Buscar</button>
                    </form>
                        <a href="/cart.php" class="d-flex btn btn-outline-dark" type="submit">
                            <i class="bi-cart-fill me-1"></i>
                            Cart
                            <span class="badge bg-dark text-white ms-1 rounded-pill"><?=items_carrito() ?></span>
                        </a>
                </div>
            </div>
        </nav>