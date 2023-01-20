<?php
include_once 'includes/functions.php';

sec_session_start();

if (login_check()) {
  session_unset();
  session_destroy();
}

header('Location: /');
exit();
