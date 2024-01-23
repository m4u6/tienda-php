<?php
require 'config/config.php';
require 'config/db.php';
define('PAGE_TITLE', 'Login');


include 'includes/header.php';

print_r(hash_pbkdf2("sha256", "password", PASSWORD_SALT, 8000));


include 'includes/footer.php';
?>
