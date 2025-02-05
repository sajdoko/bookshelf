<?php
  // Include database connection
  require_once dirname(__DIR__) . '/includes/db_conn.php';
  require_once dirname(__DIR__) . '/includes/functions.php';
//   sec_session_start();
  $logged_in_customer = login_check_customer();
// var_dump($_SESSION??'{}');

  $num_items_in_cart = isset($_SESSION['cart']) ? count($_SESSION['cart']) : 0;
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title><?= $page_title ?? ''; ?> - The Bookshelf</title>
    <meta name="description" content="Find your next favorite read with The Bookshelf.">
    <!-- Include Bootstrap CSS -->
    <link rel="stylesheet" href="/assets/bootstrap/css/bootstrap.min.css">
    <link rel='stylesheet' href='https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.3/font/bootstrap-icons.css'>
    <link rel="stylesheet" href="/assets/css/style.css">
    <link rel='apple-touch-icon' sizes='180x180' href='/assets/images/apple-touch-icon.png'>
    <link rel='icon' type='image/png' sizes='32x32' href='/assets/images/favicon-32x32.png'>
    <link rel='icon' type='image/png' sizes='16x16' href='/assets/images/favicon-16x16.png'>
    <link rel='manifest' href='/site.webmanifest'>
</head>

<body>

<div class='container'>
    <header class='d-flex flex-wrap align-items-center justify-content-center justify-content-md-between py-3 mb-4 border-bottom'>
        <a href='/' class='d-flex align-items-center col-md-3 mb-2 mb-md-0 text-dark text-decoration-none'>
            <img src='/assets/images/logo.png' width='300' alt='The Bookshelf'>
        </a>

        <ul class='nav col-12 col-md-auto mb-2 justify-content-center mb-md-0'>
            <li><a href='/' class='nav-link px-2 link-dark'>Home</a></li>
            <li><a href='/browse' class='nav-link px-2 link-dark'>Browse Books</a></li>
            <li><a href='/cart' title='go to cart' class='nav-link px-2 link-dark position-relative'>
                    <i class='bi bi-cart3'></i><span
                            class='position-absolute top-0 start-100 translate-middle badge rounded-pill bg-success'><span
                                id="cartItems"><?= $num_items_in_cart; ?></span></span>
                </a></li>
        </ul>

        <div class='col-md-auto text-end'>
          <?php if ($logged_in_customer) : ?>
              <ul class='nav col-12 col-md-auto mb-2 justify-content-end mb-md-0'>
                  <li><span class="nav-link">Hi <?= $logged_in_customer['Cus_FirstName']; ?> <i class='bi bi-emoji-smile'></i></span></li>
                  <li><a href='/account' class='nav-link px-2 link-dark'>Your Account</a></li>
                  <li><a href='/my-orders' class='nav-link px-2 link-dark'>Your Orders</a></li>
                  <li><a href='/logout' class="nav-link px-2 link-dark">Sign out?</a></li>
              </ul>
          <?php else : ?>
              <a href='/login' class='btn btn-outline-primary me-2'>Sign in</a>
              <a href='/register' class='btn btn-primary'>Register</a>
          <?php endif; ?>
        </div>
    </header>
</div>

<main>