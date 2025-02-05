<?php
require_once dirname(__DIR__) . '/controllers/AuthController.php';

if (login_check_customer()) {
  header("Location: /pages/account");
  exit;
}

$controller = new AuthController();
$controller->register();
?>
