<?php

$no_sort_array = [];
function sortable_table($data, $no_sort_array) {
    # $data should be a multidimiensional array containing all rows ($data[$row_number][$column_name])
    # $no_sort_array is an array containing the column_names that shouldn't be sorted
    # https://www.w3.org/WAI/ARIA/apg/patterns/table/examples/sortable-table/
    ?>
    <div class="table-wrap">
        <table class="sortable">
            <thead>
                <tr>
    <?php
    foreach ($data[1] as $col_name => $value) {
        ?>
        <th <?php
            $classes = "";
            if (in_array($col_name, $no_sort_array)) {
                $classes .= "no-sort ";
            }
            if (preg_match('/^[\d]+[.]?[\d]*$/', $value) === 1) { # si es un numero añadimos la clase num
                $classes .= "num ";
            }
            if ($classes != "") {
                echo "class=\"$classes\">";
            }?>
          <button>
            <?php echo $col_name ?>
            <span aria-hidden="true"></span>
          </button>
        </th>
        <?php
    }


    ?>
                </tr>
            </thead>
            <tbody>
    <?php
    foreach ($data as $row) {
        echo "<tr>";
        foreach ($row as $col_name => $value) {
            echo (preg_match('/^[\d]+[.]?[\d]*$/', $value) === 1) ? "<td class=\"num\">" : "<td>";
            echo "$value</td>";
        }
        echo "<tr>";
    }
    ?>
            </tbody>
        </table>
    </div>
    <?php

}
?>
