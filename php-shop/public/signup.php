<?php
session_start();
require_once '../config/config.php';
require_once '../config/db.php';
require_once '../models/model.signup.php';
require_once '../models/model.login.php';
require_once '../models/model.dashboard.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    # Para el registro esperamos email, name, surname, password y password-check
    $errors = [];
    if (!isset($_POST["email"]) || !isset($_POST["name"]) || !isset($_POST["password"]) || !isset($_POST["password-check"]) || !isset($_POST["surname"])) {
        $errors["empty_input"] = "Por favor rellene todos los campos.";
    }
    if (!filter_var($_POST["email"], FILTER_VALIDATE_EMAIL, FILTER_FLAG_EMAIL_UNICODE)) {
        $errors["valid_email"] = "Correo electrónico invalido.";
    }
    if ($_POST["password"] != $_POST["password"]) {
        $errors["password-match"] = "La contraseña no coincide.";
    }
    if (is_email_taken($_POST["email"], $conn)) {
        $errors["taken-email"] = "Error. Correo electronico no disponible.";
    }
    if (strlen($_POST["password"]) < 8 or strlen($_POST["password"]) > 32) {
        $errors["invalid-pw-lenght"] = "La contraseña debe tener entre 8 y 32 caracteres.";
    }
    
    if ($errors) {
        # Hay errores y se los tenemos que enseñar al usuario
        $_SESSION["errors"] = $errors;
    } else {
        # No hay errores. Debemos crear el usuario, loggearlo y redirigirlo
        if (new_user($_POST["email"], $_POST["name"], $_POST["surname"], $_POST["password"], $conn)) {
            $_SESSION["logged_as"] = login_as($_POST["email"], $conn);
            header("Location: /index.php");
        } else {
            $errors["errors"] = "Error al crear el usuario";
            $_SESSION["signup_errors"] = $errors;
        }
    }


}



# Views
define('PAGE_TITLE', 'Registro');
require_once '../views/view.header.php';
require_once '../views/view.signup.php';
require_once '../views/view.footer.php';
?>
