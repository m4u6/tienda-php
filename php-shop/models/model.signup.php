<?php


function is_email_taken($email, $conn) {
    $query = "SELECT * FROM users WHERE u_email='" . $email . "';";
    $results = mysqli_query($conn, $query);
    if ($results) {
        $row = mysqli_fetch_assoc($results);
        if ($row) {
            return True;
        } else {
            return False;
        }
    }
}


function new_user($email, $name, $surname, $password, $conn) {
    $sql = "INSERT INTO users (u_name, u_surname, u_email, u_password) VALUES (?, ?, ?, ?)";
    $stmt = mysqli_prepare($conn, $sql);
    $hashed_password = hash_pbkdf2("sha256", $password, PASSWORD_SALT, 8000);
    mysqli_stmt_bind_param($stmt, "ssss", $name, $surname, $email, $hashed_password);
    mysqli_stmt_execute($stmt);

    if (mysqli_stmt_error($stmt) === "") {
        # No hay errores
        add_log_entry("signup.log", "Usuario $email creado con exito");
        return True;
    } else {
        # Hay errores
        $error = mysqli_stmt_error($stmt);
        add_log_entry("signup.log", "Error al crear usuario $error", 1);
        return False;
    }
    mysqli_stmt_close($stmt);
} 
