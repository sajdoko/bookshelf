<?php
include_once 'includes/db_conn.php';
include_once 'includes/functions.php';
?>
<!DOCTYPE html>
<html>

<head>
  <title><?php echo $page_title??''; ?> - The Bookshelf</title>
  <!-- Include Bootstrap CSS -->
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">
</head>

<body>
  <header>
    <!-- Use Bootstrap navbar component -->
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
      <a class="navbar-brand" href="#">The Bookshelf</a>
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav">
          <li class="nav-item active">
            <a class="nav-link" href="#">Browse Books</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#">My Account</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#">Cart</a>
          </li>
            <?php
            if (login_check() == true) {
              echo "<li><a href='my_orders'>My orders</a></li>";
              echo "<li><a href='logout'>Sign out</a></li>";
            } else {
              echo "<li><a href='login'>Sign in</a></li>";
              echo "<li><a href='register'>Register</a></li>";
            }
            ?>
        </ul>
      </div>
    </nav>

  </header>