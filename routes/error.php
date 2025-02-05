<?php

$page_title = "Error";
require_once dirname(__DIR__) . '/views/header.php';

$error_msg = "";

if (isset($_GET['err'])) {
  $error_msg .= '<p class="text-danger">'.filter_input(INPUT_GET, 'err', FILTER_SANITIZE_FULL_SPECIAL_CHARS).'</p>';
}

if (!login_check_customer()) {
  $error_msg .= '<p class="text-danger">You are not authorized to access this page.</p>';
}

if ($error_msg != "") {
  echo $error_msg;
}

require_once dirname(__DIR__) . '/views/footer.php';
