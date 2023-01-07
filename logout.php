<?php
include_once 'includes/db_conn.php';
include_once 'includes/functions.php';

sec_session_start();

if (login_check($mysqli) == true) {
    $user_id = $_SESSION['user_id'];

    session_unset();
    session_destroy();
}

header('Location: index.php');
exit();