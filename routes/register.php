<?php
require_once dirname(__DIR__) . '/autoload.php';
require_once dirname(__DIR__) . '/controllers/AuthController.php';

if (login_check_customer()) {
  header("Location: /account");
  exit;
}

$controller = new AuthController();
$controller->register();
?>
