<?php
# Este fichero contendra las funciones necesarias para gestionar la sesion de los usuarios




function show_login($action="") {
    if (true) {
        ?>
            <form method="post" action="<?php print_r($action) ?>">
                <label for="username">Usuario:</label><br>
                <input type="email" id="username" name="username" placeholder="Correo electronico" required><br>
                <label for="password">Contraseña:</label><br>
                <input type="password" id="password" name="password" placeholder="Contraseña" required><br>
                <input type="submit" value="Iniciar Sesión" class="btn btn-primary">
            </form>
        <?php
    };
}







# print_r(hash_pbkdf2("sha256", "password", PASSWORD_SALT, 8000));


?>