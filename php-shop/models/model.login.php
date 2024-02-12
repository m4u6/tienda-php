<?php
# print_r(hash_pbkdf2("sha256", "password", PASSWORD_SALT, 8000));

function login_as($email, $conn) {
    $query = "SELECT user_id, u_name, u_surname, u_email FROM users WHERE u_email='" . $email . "';";
    $results = mysqli_query($conn, $query);
    if ($results) {
        $row = mysqli_fetch_assoc($results);
        if ($row) {
            return $row;
        } else {
            return False;
        }
    }
}


function password_check($email, $password, $conn) {
    $query = "SELECT u_password FROM users WHERE u_email='" . $email . "';";
    $results = mysqli_query($conn, $query);
    if ($results) {
        $row = mysqli_fetch_assoc($results);
        if ($row) {
            $hashed_password = hash_pbkdf2("sha256", $password, PASSWORD_SALT, 8000);
            if ($row["u_password"] == $hashed_password) {
                return True;
            } else {
                return False;
            }
        } else {
            return False;
        }
    }
}