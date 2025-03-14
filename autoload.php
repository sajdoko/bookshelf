<?php

require_once __DIR__ . '/includes/db_conn.php';
require_once __DIR__ . '/admin/includes/admin_functions.php';
require_once __DIR__ . '/includes/functions.php';

spl_autoload_register(function ($class_name) {
    $file = __DIR__ . '/models/' . $class_name . '.php';
    if (file_exists($file)) {
        require_once $file;
    }
});
