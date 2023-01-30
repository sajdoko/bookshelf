<?php
  // Include database connection
  require_once dirname(__FILE__, 3).'/includes/db_conn.php';
  require_once dirname(__FILE__, 3).'/includes/functions.php';
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
    <link href='/assets/css/dashboard.css' rel='stylesheet'>
</head>

<body>


<header class='navbar navbar-dark sticky-top bg-dark flex-md-nowrap p-0 shadow'>
    <a class='navbar-brand col-md-2 col-lg-1 me-0 px-3 fs-6' href='/admin/dashboard'>The Bookshelf</a>
    <button class='navbar-toggler position-absolute d-md-none collapsed' type='button' data-bs-toggle='collapse' data-bs-target='#sidebarMenu'
            aria-controls='sidebarMenu' aria-expanded='false' aria-label='Toggle navigation'>
        <span class='navbar-toggler-icon'></span>
    </button>
    <div class='navbar-nav'>
        <div class='nav-item text-nowrap'>
            <span class='nav-link px-3'>Hi <?= $logged_in_employee['Emp_FirstName']; ?> <i class='bi bi-emoji-smile'></i></span>
        </div>
    </div>
    <div class='navbar-nav'>
        <div class='nav-item text-nowrap'>
            <a class='nav-link px-3' href='../../logout.php'>Sign out</a>
        </div>
    </div>
</header>

<div class='container-fluid mt-3'>
    <div class='row'>
        <nav id='sidebarMenu' class='col-md-2 col-lg-1 d-md-block bg-light sidebar collapse'>
            <div class='position-sticky pt-3 sidebar-sticky'>
                <ul class='nav flex-column'>
                    <li class='nav-item'>
                        <a class='nav-link active' aria-current='page' href='/admin/dashboard'>
                            <span data-feather='home' class='align-text-bottom'></span>
                            Dashboard
                        </a>
                    </li>
                    <li class='nav-item'>
                        <a class='nav-link' href='/admin/orders'>
                            <span data-feather='file' class='align-text-bottom'></span>
                            Orders
                        </a>
                    </li>
                    <li class='nav-item'>
                        <a class='nav-link' href='/admin/books'>
                            <span data-feather='shopping-cart' class='align-text-bottom'></span>
                            Books
                        </a>
                    </li>
                    <li class='nav-item'>
                        <a class='nav-link' href='/admin/customers'>
                            <span data-feather='users' class='align-text-bottom'></span>
                            Customers
                        </a>
                    </li>
                    <li class='nav-item'>
                        <a class='nav-link' href='/admin/reports'>
                            <span data-feather='bar-chart-2' class='align-text-bottom'></span>
                            Reports
                        </a>
                    </li>
                </ul>
            </div>
        </nav>

        <main class='col-md-10 ms-sm-auto col-lg-11 px-md-4'>

            <div class='container-fluid'>
