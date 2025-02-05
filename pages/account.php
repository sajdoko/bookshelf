<?php
require_once dirname(__DIR__) . '/controllers/AccountController.php';

$controller = new AccountController();
$controller->index();
?>