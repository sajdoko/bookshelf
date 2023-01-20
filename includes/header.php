<?php
    // Include database connection
  require_once 'db_conn.php';
  require_once 'functions.php';
  sec_session_start();
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


<header>
  <div class="d-flex flex-column flex-md-row align-items-center p-x3 px-md-4 bg-white border-bottom box-shadow">
    <a class="mr-md-auto navbar-brand" href="/"><img src="/assets/img/logo.png" width="300" alt="The Bookshelf"></a>
    <!-- Use Bootstrap navbar component -->
    <nav class="navbar navbar-expand-lg navbar-light">
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav">
          <li class="nav-item">
            <a class="nav-link" href="/pages/browse">Browse Books</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="/pages/account">My Account</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="/pages/cart">Cart</a>
          </li>
          <?php if (login_check()) : ?>
            <li class="nav-item">
              <a class="nav-link btn btn-sm btn-outline-warning" href="/logout">Sign out</a>
            </li>
          <?php else : ?>
            <li class="nav-item">
              <a class="nav-link" href="/login">Sign in</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="/register">Register</a>
            </li>
          <?php endif; ?>
        </ul>
      </div>
    </nav>
  </div>
</header>

<main>