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

function is_valid_seo_name($seo_name, $conn, $product_id=0) {
    # Primero comprbar si no tiene espacios u otros caracteres prohibidos
    # Luego comprobar que no exista otro seo_name igual en la db
    # Solo se permiten numeros y letras ([\w]) y guiones sueltos pero no al principio ni al final
    if (preg_match('/^([\w]+-?[\w]+)*$/', $seo_name) === 1) {
        $query = "SELECT product_id FROM products WHERE seo_name = ? AND product_id != ?";
        $stmt = mysqli_prepare($conn, $query);
        mysqli_stmt_bind_param($stmt, "si", $seo_name, $product_id);
        mysqli_stmt_execute($stmt);
        $results = mysqli_stmt_get_result($stmt);

        if ($results && mysqli_num_rows($results) > 0) {
            return False; // SEO name already exists
        } else {
            return True; // SEO name is valid and unique
        }
    } else {
        return False;
    }
}

function add_new_product($p_name, $p_description, $seo_name, $stock, $price, $conn) {
    if (is_valid_seo_name($seo_name, $conn) == False) {
        throw new Exception("seo-name invalido");
    }
    $sql = "INSERT INTO products (p_name, p_description, seo_name, stock, price) VALUES (?, ?, ?, ?, ?);";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "sssid", $p_name, $p_description, $seo_name, $stock, $price);
    mysqli_stmt_execute($stmt);

    if (mysqli_stmt_error($stmt) === "") {
        # No hay errores
        add_log_entry("products.log", "El producto $p_name se ha creado con exito");
        return True;
    } else {
        # Hay errores
        $error = mysqli_stmt_error($stmt);
        add_log_entry("products.log", "Error al crear producto $p_name = $error", 1);
        throw new Exception("Hubo un error creando el producto");
    }
    mysqli_stmt_close($stmt);
}


function is_valid_product_id($product_id, $conn) {
    # Debera devolver true si es un product_id que existe y false si no.
    # Comprueba que el id solo contiene numeros
    if (!(preg_match('/^[\d]+$/', $product_id) === 1)) {
        return False;
    }
    # Comprobamos si este product_id existe en la base de datos
    $query = "SELECT product_id FROM products WHERE product_id=?";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "i", $product_id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    
    # Si hay mas de 0 lineas entonces existe
    if ($result && mysqli_num_rows($result) > 0) {
        # Existe
        return True;
    } else {
        # No existe
        return False;
    }
}




# Si is_valid_product_id() == False entonces no hacemos nada y damos error
#function update_product($product_id, $p_name, $p_description, $seo_name, $stock, $conn) {}

function update_product($product_id, $p_name, $p_description, $seo_name, $stock, $price, $conn) {
    // Validate SEO name
    
    if (is_valid_seo_name($seo_name, $conn, $product_id) === False) {
        throw new Exception("seo-name invalido");
    }
    $sql = "UPDATE products SET p_name=?, p_description=?, seo_name=?, stock=?, price=? WHERE product_id=?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "sssidi", $p_name, $p_description, $seo_name, $stock, $price, $product_id);
    mysqli_stmt_execute($stmt);

    if (mysqli_stmt_error($stmt) === "") {
        # No hay errores
        add_log_entry("products.log", "El producto $p_name se ha actualizado con éxito");
        mysqli_stmt_close($stmt);
        return true;
    } else {
        # Hay errores
        $error = mysqli_stmt_error($stmt);
        add_log_entry("products.log", "Error al actualizar el producto $p_name = $error", 1);
        mysqli_stmt_close($stmt);
        throw new Exception("Hubo un error actualizando el producto");
    }
}

# Creo que no se usa al final
function reArrayFiles(&$file_post) {
    # Esta funcion reorganiza la variable $_FILES para que tenga una estructura mas intuitiva. 
    # Sacada de php.net por phpuser at gmail dot com    src: https://www.php.net/manual/en/features.file-upload.multiple.php
    $file_ary = array();
    $file_count = count($file_post['name']);    # line 127
    $file_keys = array_keys($file_post);

    for ($i=0; $i<$file_count; $i++) {
        foreach ($file_keys as $key) {
            $file_ary[$i][$key] = $file_post[$key][$i];
        }
    }

    return $file_ary;
}



function handle_upload($files, &$errors, $product_id, $conn) {
    for ($i=0;$i<count($files["name"]);$i++) {
        $name=$files["name"][$i];
        $type=$files["type"][$i];
        $tmp_name=$files["tmp_name"][$i];
        $img_error=$files["error"][$i];
        $size=$files["size"][$i];
        $extension=strtolower(end(explode('.',$name)));
        
        # Error handling
        $error_count=count($errors);
        if ($size > MAX_IMG_SIZE) {
            $errors["too_large_img".$i]="Error, la imagen $name es muy grande.";
        }
        if ($img_error === 1) {
            $errors["unknown_error_img".$i]="Error subiendo la imagen $i";
        } 
        if (in_array($extension, ALLOWED_IMG_EXTENSIONS) == false) {
            $errors["ext_not_allowed".$i]="No se permite este tipo de ficheros $name";
        }
        if ($error_count != count($errors)) {
            continue;
        }

        # A partir de aqui las imagenes que lleguen seran validas
        $file_save_name=uniqid('', true) . "-" . $product_id . "." . $extension;
        $file_destination="../assets/img/" . $file_save_name;
        move_uploaded_file($tmp_name, $file_destination);

        # Añadimos la imagen en la base de datos
        $absolute_img_path=substr($file_destination, 2);
        $sql = "INSERT INTO images (product_id, img_location) VALUES (?, ?);";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "is", $product_id, $absolute_img_path);
        mysqli_stmt_execute($stmt);
    
        if (mysqli_stmt_error($stmt) === "") {
            # No hay errores
            add_log_entry("products.log", "Imagen $name subida al producto id:$product_id");
            return True;
        } else {
            # Hay errores
            $error = mysqli_stmt_error($stmt);
            add_log_entry("products.log", "Error al añadir imagen al producto", 1);
        }
        mysqli_stmt_close($stmt);
    }
} 



