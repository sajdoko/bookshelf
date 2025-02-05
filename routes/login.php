<?php
require_once dirname(__DIR__) . '/autoload.php';
require_once dirname(__DIR__) . '/controllers/AuthController.php';

$controller = new AuthController();
$controller->login();
?>