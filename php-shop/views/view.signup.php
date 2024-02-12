<div class="container">
    <?php
    if (isset($_SESSION["signup_errors"])) {
        ?>
        <div class="row justify-content-center">
            <div class="col-lg-4 my-4 pt-3 pb-2 bg-danger text-light rounded ">
                <ul>
                    <?php
                        foreach ($_SESSION["signup_errors"] as $error) {
                            echo "<li>" . $error . "</li>";
                        }
                    ?>
                </ul>
            </div>
        </div>
        <?php
        unset($_SESSION["signup_errors"]);
    }
    ?>
    <div class="row justify-content-center">
        <div class="col-lg-4 my-4 ">
            <form action="signup.php" method="post" >
            <div class="mb-3">
                <label for="email" name="email" class="form-label">Correo electrónico</label>
                <input type="email" name="email" class="form-control" id="email" required>
            </div>
            <div class="mb-3">
                <label for="name" class="form-label">Nombre:</label>
                <input type="text" name="name" class="form-control" id="name" required>
            </div>
            <div class="mb-3">
                <label for="surname" class="form-label">Apellidos:</label>
                <input type="text" name="surname" class="form-control" id="surname" required>
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Contraseña:</label>
                <input type="password" name="password" class="form-control" id="password" required>
            </div>
            <div class="mb-3">
                <label for="password-check" class="form-label">Confirme contraseña:</label>
                <input type="password" name="password-check" class="form-control" id="password-check" required>
            </div>
            <button type="submit" class="btn btn-primary">Registrarse</button>
            </form>
        </div>
    </div>
</div>