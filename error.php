<?php

$page_title = "Register";
require_once 'includes/header.php';

sec_session_start();

$error_msg = "";

if (isset($_GET['err'])) {
  $error_msg .= '<p class="text-danger">' . filter_input(INPUT_GET, 'err', FILTER_SANITIZE_STRING) . '</p>';
}

if (login_check() == false) {
  $error_msg .= '<p class="text-danger">You are not authorized to access this page.</p>';
}

if ($error_msg != "") {
  echo $error_msg;
}

require_once 'includes/footer.php';
