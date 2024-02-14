<?php

$query1 = array(
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