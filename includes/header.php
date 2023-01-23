<?php
    // Include database connection
  require_once 'db_conn.php';
  require_once 'functions.php';
  sec_session_start();
  $logged_in_customer = login_check_customer();
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title><?php echo $page_title??''; ?> - The Bookshelf</title>
  <meta name="description" content="Find your next favorite read with The Bookshelf.">
  <!-- Include Bootstrap CSS -->
  <link rel="stylesheet" href="/assets/bootstrap/css/bootstrap.min.css">
  <link rel="stylesheet" href="/assets/css/style.css">
</head>

<body>

<div class='container'>
    <header class='d-flex flex-wrap align-items-center justify-content-center justify-content-md-between py-3 mb-4 border-bottom'>
        <a href='/' class='d-flex align-items-center col-md-3 mb-2 mb-md-0 text-dark text-decoration-none'>
            <img src='/assets/images/logo.png' width='300' alt='The Bookshelf'>
        </a>

        <ul class='nav col-12 col-md-auto mb-2 justify-content-center mb-md-0'>
            <li><a href='/' class='nav-link px-2 link-secondary'>Home</a></li>
            <li><a href='/pages/browse' class='nav-link px-2 link-dark'>Browse Books</a></li>
            <li><a href='/pages/account' class='nav-link px-2 link-dark'>My Account</a></li>
            <li><a href='/pages/cart' class='nav-link px-2 link-dark'>Cart</a></li>
        </ul>

        <div class='col-md-3 text-end'>
          <?php if ($logged_in_customer) : ?>
            Hi <?php echo $logged_in_customer['Cus_FirstName']; ?><a href='/logout' class='btn btn-link me-2'>Sign out</a>
          <?php else : ?>
            <a href='../pages/login' class='btn btn-outline-primary me-2'>Sign in</a>
            <a href='../pages/register' class='btn btn-primary'>Register</a>
          <?php endif; ?>
        </div>
    </header>
</div>

<main>