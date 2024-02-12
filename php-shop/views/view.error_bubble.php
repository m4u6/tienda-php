<?php
    if (isset($_SESSION["errors"])) {
        ?>
        <div class="row justify-content-center">
            <div class="col-lg-4 my-4 pt-3 pb-2 bg-danger text-light rounded ">
                <ul>
                    <?php
                        foreach ($_SESSION["errors"] as $error) {
                            echo "<li>" . $error . "</li>";
                        }
                    ?>
                </ul>
            </div>
        </div>
        <?php
        unset($_SESSION["errors"]);
    }
    ?>