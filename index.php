<?php
require_once __DIR__ . '/autoload.php';
require_once __DIR__ . '/controllers/HomeController.php';

$controller = new HomeController();
$controller->index();
?>