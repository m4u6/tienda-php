<?php
# print_r(hash_pbkdf2("sha256", "password", PASSWORD_SALT, 8000));

function login_as($email, $conn) {
    $query = "SELECT user_id, u_name, u_surname, u_email FROM users WHERE u_email='" . $email . "';";
    $results = mysqli_query($conn, $query);
    if ($results) {
        $row = mysqli_fetch_assoc($results);
        $logged_as = [];
        if ($row) {
            return $row;
        } else {
            return False;
        }
    }
}


function password_check($email, $password, $conn) {
    return True;
}