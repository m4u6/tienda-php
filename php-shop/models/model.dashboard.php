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


$query_usuarios = array(
    "user_id" => "ID Usuario",
    "u_name" => "Nombre",
    "u_surname" => "Apellidos",
    #"u_phone" => "Telefono",
    "u_email" => "e-mail",
    "is_admin" => "Admin"
);


function query_table($conn, $table ,$columns=NULL, $where=NULL) {
    # $columns se refiere a las columnas que pedir en el query. Mirar el array $query_productos como referencia.
    # Esta funcion esta pensada para la tabla de productos del dashboard
    if ($columns === NULL) {
        $cols="*";
    } else {
        $cols="";
        foreach ($columns as $col => $alias) {
            $cols.="$col AS '$alias', ";
        }
        $cols = rtrim($cols, ", ");
    }
    $query = "SELECT $cols FROM $table $where;";
    $result = mysqli_query($conn, $query);
    if ($result) {
        $i=1;
        $data=array();
        while ($row = mysqli_fetch_assoc($result)) {
            $data[$i] = $row;
            $i++;
        };
        mysqli_free_result($result);
        return $data;
    } else {
        # Error
        echo "Error: " . mysqli_error($conn);
    }
}
