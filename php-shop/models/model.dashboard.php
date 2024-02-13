<?php

# Should this model be included in any page, it must check whether the user is admin, so the function is executed right after defining it.

function admin_check($conn, $user_id=null) {
    if ($user_id === null) {
        $user_id = $_SESSION["logged_as"]["user_id"];
    }
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

function redirect_non_admin($conn) {
    if (!admin_check($conn, $_SESSION["logged_as"]["user_id"])) {
        # User is not admin
        header("Location: /");
    }
};