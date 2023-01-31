<?php
  // Include database connection
  require_once dirname(__FILE__, 3).'/includes/db_conn.php';
  require_once dirname(__FILE__, 3).'/includes/functions.php';
  require_once dirname(__FILE__, 1).'/admin_functions.php';
  sec_session_start();
  $logged_in_employee = login_check_employee();

  if (!$logged_in_employee) {
    header('Location: /admin/login');
    exit;
  }
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
    <link href='/assets/css/dashboard.css' rel='stylesheet'>
</head>

<body>


<main class='d-flex flex-nowrap'>
    <h1 class='visually-hidden'>The Bookshelf</h1>

    <div class='d-flex flex-column flex-shrink-0 p-3 bg-light' style='width: 280px;'>
        <a href='/admin/dashboard' class='d-flex align-items-center mb-3 mb-md-0 me-md-auto text-dark text-decoration-none'>
            <img src='/assets/images/logo.png' width='200' alt='The Bookshelf'>
        </a>
        <hr>
        <ul class='nav nav-pills flex-column mb-auto'>
            <li>
                <a href='/admin/dashboard' class='nav-link text-dark'>
                    <i class='bi bi-speedometer2'></i>
                    Dashboard
                </a>
            </li>
            <li>
                <a href='/admin/orders' class='nav-link text-dark'>
                    <i class='bi bi-table'></i>
                    Orders
                </a>
            </li>
            <li>
                <a href='/admin/books' class='nav-link text-dark'>
                    <i class='bi bi-book'></i>
                    Books
                </a>
            </li>
            <li>
                <a href='/admin/customers' class='nav-link text-dark'>
                    <i class='bi bi-people'></i>
                    Customers
                </a>
            </li>
            <li>
                <a href='/admin/reports' class='nav-link text-dark'>
                    <i class='bi bi-graph-up'></i>
                    Reports
                </a>
            </li>
        </ul>
        <hr>
        <div class='dropdown'>
            <a href='#' class='d-flex align-items-center text-dark text-decoration-none dropdown-toggle' data-bs-toggle='dropdown'
               aria-expanded='false'>
              <?= get_gravatar($logged_in_employee['Emp_Email'], 32, 'mp', 'g', true, ['class' => 'rounded-circle me-2']); ?>
                <span>Hi <?= $logged_in_employee['Emp_FirstName']; ?></span>
            </a>
            <ul class='dropdown-menu dropdown-menu text-small shadow'>
                <li><a class='dropdown-item' href='#'>Profile</a></li>
                <li>
                    <hr class='dropdown-divider'>
                </li>
                <li><a class='dropdown-item' href='../../logout.php'>Sign out</a></li>
            </ul>
        </div>
    </div>

    <div class="container-fluid">