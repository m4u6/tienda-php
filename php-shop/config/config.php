<?php
# DB
define('DB_HOST', 'db');
define('DB_PORT', 3306);
define('DB_NAME', 'tienda_db');
define('DB_USER', 'root');
define('DB_PASSWORD', 'secret-pass');


define('PASSWORD_SALT', '72b302bf297a228a75730123efef7c41');


function add_log_entry($log_file, $log_msg, $error=0) {
    # $log_file sera el nombre del fichero log que esta dentro de la carpeta logs
    $entry = date(DATE_RFC850);
    if ($error != 0 ) {
        $entry .= " ERROR " . $error . ": " . $log_msg;
    } else {
        $entry .= " : " . $log_msg;
    }
    $file = "/var/www/php-shop/logs/" . $log_file;
    file_put_contents($file, $entry . PHP_EOL, FILE_APPEND);
}



?>