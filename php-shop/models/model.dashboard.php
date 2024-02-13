<?php

# Should this model be included in any page, it must check whether the user is admin, so the function is executed right after defining it.

function admin_check($user_id, $conn) {
    $query = "SELECT is_admin FROM users WHERE user_id=" . $user_id . ";";
    $results = mysqli_query($conn, $query);
    if ($results) {
        $row = mysqli_fetch_assoc($results);
        if ($row["is_admin"] == 1) {
            return True;
        } else {
            return False;
        }
    }
}

if (!admin_check($_SESSION["logged_as"]["user_id"], $conn)) {
    # User is not admin
    header("Location: /");
}
