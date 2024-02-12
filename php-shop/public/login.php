<?php
session_start();
require_once '../config/config.php';
require_once '../config/db.php';

require_once '../models/model.login.php';
require_once '../models/model.signup.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $errors = [];
    if (!isset($_POST["email"]) || !isset($_POST["password"])) {
        $errors["empty_input"] = "Por favor rellene todos los campos.";
    }
    if (!password_check($_POST["email"], $_POST["password"], $conn)) {
        $errors["credential_error"] = "Usuario o contraseña incorrectos.";
    }

    
    
    if ($errors) {
        # Hay errores y se los tenemos que enseñar al usuario
        $_SESSION["login_errors"] = $errors;
        if (is_email_taken($_POST["email"], $conn)) {
            add_log_entry("login.log", "Intento fallido de inicio de sesion en el usuario $email", 1);
        } else {
            add_log_entry("login.log", "Se ha intentado iniciar sesion con un correo que no esta registrado ($email)", 1);
        }
    } else {
        # No hay errores. Debemos crear el usuario, loggearlo y redirigirlo
        $_SESSION["logged_as"] = login_as($_POST["email"], $conn);
        add_log_entry("login.log", "El usuario $email ha iniciado sesión");
        header("Location: /index.php");
    }
}



# Views
define('PAGE_TITLE', 'Login');
require_once '../views/view.header.php';
require_once '../views/view.login.php';
require_once '../views/view.footer.php';
?>
