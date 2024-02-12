<?php
require_once '../config/config.php';
require_once '../config/db.php';

define('PAGE_TITLE', 'Index');
require_once '../views/view.header.php';

echo date(DATE_RFC850);

require_once '../views/view.footer.php';
?>





