<?php
require_once '../../config/config.php';
require_once '../../config/db.php';
session_start();
define('PAGE_TITLE', 'Gestión de usuarios');
require_once '../../models/model.dashboard.php';
require_once '../../models/model.user_management.php';


redirect_non_admin($conn);




require_once '../../views/dashboard/view.head.dashboard.php';
require_once '../../views/dashboard/view.sidebar.dashboard.php';
require_once '../../views/dashboard/view.top_navbar.dashboard.php';
# Actual content of the page
require_once '../../views/dashboard/view.users.dashboard.php';




require_once '../../views/dashboard/view.tail.dashboard.php';






?>





