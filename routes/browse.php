<?php
require_once dirname(__DIR__) . '/autoload.php';
require_once dirname(__DIR__) . '/controllers/BrowseController.php';

$controller = new BrowseController();
$controller->index();
?>