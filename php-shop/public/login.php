<?php
require_once '../config/config.php';
require_once '../config/db.php';

require_once '../models/model.login.php';





# Views
define('PAGE_TITLE', 'Login');
require_once '../views/view.header.php';
require_once '../views/view.login.php';
require_once '../views/view.footer.php';
?>
