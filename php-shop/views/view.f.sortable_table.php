<?php

$no_sort_array = [];
function sortable_table($data, $no_sort_array) {
    # $data should be a multidimiensional array containing all rows ($data[$row_number][$column_name])
    # $no_sort_array is an array containing the column_names that shouldn't be sorted
    # https://www.w3.org/WAI/ARIA/apg/patterns/table/examples/sortable-table/

    echo "<div class=\"table-wrap\">";
    echo "<table class=\"sortable\">";
    echo "<thead>";
    echo "<tr>";
    foreach ($data[1] as $col_name => $value) {
            $classes = "";
            if (in_array($col_name, $no_sort_array)) {  # Si el nombre del th esta en el array $no_sort_array añadiremos la clase no-sort
                $classes .= "no-sort ";
            }
            if (preg_match('/^[\d]+[.]?[\d]*$/', $value) === 1) { # si es un numero añadimos la clase num
                $classes .= "num ";
            }
            if ($classes != "") {
                echo "<th class=\"$classes\" style=\"height:30px\">";   # Un apaño lo de style pero bueno
            } else {
                echo "<th>";
            }
            echo "<button>$col_name";
            echo "<span aria-hidden=\"true\"></span>";
            echo "</button>";
            echo "</th>";
        }
    echo "</tr>";
    echo "</thead>";
    echo "<tbody>";
    foreach ($data as $row) {
        echo "<tr>";
        foreach ($row as $col_name => $value) {
            echo (preg_match('/^[\d]+[.]?[\d]*$/', $value) === 1) ? "<td class=\"num\">" : "<td>";
            echo "$value</td>";
        }
        echo "</tr>";
    }
    echo "</tbody>";
    echo "</table>";  
    echo "</div>";
}
?>
