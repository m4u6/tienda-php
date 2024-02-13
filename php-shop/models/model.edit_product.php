<?php

function new_or_edit_product($get_edit, $conn) {
    if ($get_edit == "new") {
        return False;
    } else {
        return True;
    }
}

function load_product_data($product_id, $conn) {
    $query = "SELECT * FROM products WHERE product_id=" . $product_id . ";";
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

function add_new_product($p_name, $p_description, $seo_name, $stock, $conn) {
    $sql = "INSERT INTO products (p_name, p_description, seo_name, stock) VALUES (?, ?, ?, ?);";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "sssi", $p_name, $p_description, $seo_name, $stock);
    mysqli_stmt_execute($stmt);

    if (mysqli_stmt_error($stmt) === "") {
        # No hay errores
        add_log_entry("products.log", "El producto $p_name se ha creado con exito");
        return True;
    } else {
        # Hay errores
        $error = mysqli_stmt_error($stmt);
        add_log_entry("products.log", "Error al crear producto $p_name", 1);
        return False;
    }
    mysqli_stmt_close($stmt);
}


function is_valid_product_id($product_id, $conn) {
    # Comprueba si existe ese product_id dentro de la base de datos
}

function is_valid_seo_name($seo_name, $conn) {
    # Primero comprbar si no tiene espacios u otros caracteres prohibidos
    # Luego comprobar que no exista otro seo_name igual en la db
}


function update_product($product_id, $p_name, $p_description, $seo_name, $stock, $conn) {
    # Si is_valid_product_id() == False entonces no hacemos nada y damos error
}


