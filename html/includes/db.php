<?php
# Acceder a la consola sql a traves de docker: sudo docker exec -it tienda-php-db-1 bash -c 'mariadb -uroot -psecret-pass'

$conn = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME, DB_PORT);
if ($conn->connect_error) {
    die("Error conexion DB " . $conn->connect_error);
};
?>