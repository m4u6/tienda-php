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

