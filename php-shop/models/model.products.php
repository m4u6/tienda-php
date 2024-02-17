<?php

$query_productos = array(
    # columna => as alias 
    "product_id" => "ID",
    "p_name" => "Nombre",
    "price" => "Precio",
    "stock" => "Stock",
    "seo_name" => "URL Amigable"
  );

function query_products($conn, $columns=NULL) {
    # columns shoudl be an array of the columns that should be queried. If left blank it will query all columns.
    if ($columns === NULL) {
        $cols="*";
    } else {
        $cols="";
        foreach ($columns as $col => $alias) {
            $cols.="$col AS '$alias', ";
        }
        $cols = rtrim($cols, ", ");
    }
    $query = "SELECT $cols FROM products;";
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

function add_edit_product_to_table($data) {
    for ($i = 1; $i <= count($data); $i++) {
        #$edit_array = array("Edit" => "<a href=\"productos.php?edit=$data[$i][\"ID\"]\">Editar producto</a>");
        $product_id=$data[$i]["ID"];
        $data[$i]["Edit"] = "<a href=\"productos.php?edit=$product_id\">Editar producto</a>";
        
    }
    return $data;
}

function add_view_product_to_table($data) {
    for ($i = 1; $i <= count($data); $i++) {
        #$edit_array = array("Edit" => "<a href=\"productos.php?edit=$data[$i][\"ID\"]\">Editar producto</a>");
        $seo_name=$data[$i]["URL Amigable"];
        $data[$i]["Ver en tienda"] = "<a href=\"/producto/$seo_name\">Ver página</a>";
        
    }
    return $data;
}



function get_product_data_imgs($conn, $product_id) {
    $query = "SELECT * FROM products WHERE product_id=" . $product_id . ";";
    $results = mysqli_query($conn, $query);
    if ($results) {
        $producto = mysqli_fetch_assoc($results);
        if ($producto) {
            mysqli_free_result($results);
            $query = "SELECT img_location FROM images WHERE product_id=" . $product_id . ";";
            $results = mysqli_query($conn, $query);
            $image_locations = array();
            while ($row = mysqli_fetch_assoc($results)) {
                $image_locations[] = $row['img_location'];
            }
            $producto["imgs"]=$image_locations;
            return $producto;
        } else {
            return False;
        }
    }
}



function seo_name_to_id($conn, $seo_name) {
    $sql = "SELECT product_id FROM products WHERE seo_name = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $seo_name);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        return $row['product_id'];
    } else {
        # Si el producto no existe lanzamos una excepcion
        throw new Exception("Ese producto no existe");
    }
}
