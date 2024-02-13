<?php
require_once '../../config/config.php';
require_once '../../config/db.php';
session_start();
define('PAGE_TITLE', 'Index');
require_once '../../models/model.dashboard.php';


require_once '../../views/dashboard/view.head.dashboard.php';
require_once '../../views/dashboard/view.sidebar.dashboard.php';
require_once '../../views/dashboard/view.top_navbar.dashboard.php';
# Actual content of the page
require_once '../../views/dashboard/template.view.content.dashboard.php';

require_once '../../views/dashboard/view.tail.dashboard.php';






?>





