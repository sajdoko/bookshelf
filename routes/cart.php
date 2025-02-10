<?php
require_once dirname(__DIR__) . '/autoload.php';
require_once dirname(__DIR__) . '/controllers/CartController.php';

$controller = new CartController();
$controller->cart();

?>