<?php
require_once '../config/config.php';
require_once '../config/db.php';

require_once '../models/model.login.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $errors = [];
    if (!isset($_POST["email"]) || !isset($_POST["password"])) {
        $errors["empty_input"] = "Por favor rellene todos los campos.";
    }
    if (password_check($_POST["email"], $_POST["password"], $conn)) {
        echo "lol";
    }

    
    
    if ($errors) {
        # Hay errores y se los tenemos que enseñar al usuario
        $_SESSION["signup_errors"] = $errors;
    } else {
        # No hay errores. Debemos crear el usuario, loggearlo y redirigirlo
        if (new_user($_POST["email"], $_POST["name"], $_POST["surname"], $_POST["password"], $conn)) {
            $_SESSION["logged_as"] = login_as($_POST["email"], $conn);
            header("Location: /index.php");
        } else {
            $errors["error_adding_user"] = "Error al crear el usuario";
            $_SESSION["signup_errors"] = $errors;
        }
    }
}



# Views
define('PAGE_TITLE', 'Login');
require_once '../views/view.header.php';
require_once '../views/view.login.php';
require_once '../views/view.footer.php';
?>
