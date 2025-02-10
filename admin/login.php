<?php
    require_once dirname(__FILE__, 2) . '/autoload.php';
  sec_session_start();
  $logged_in_employee = login_check_employee();

  if ($logged_in_employee) {
    header('Location: /admin/dashboard');
    exit;
  }
  $self_url = strtok($_SERVER['REQUEST_URI'], '?');

  $error_msg = '';

  if (isset($_POST['email'], $_POST['password'])) {
    $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
    $password = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_FULL_SPECIAL_CHARS);

    if (login_employee($email, $password)) {
      header('Location: /admin/dashboard');
      exit();
    }
    else {
      $error_msg .= '<p class="text-danger">Invalid email or password</p>';
    }
  }
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Log In - The Bookshelf</title>
    <meta name="description" content="Find your next favorite read with The Bookshelf.">
    <!-- Include Bootstrap CSS -->
    <link rel="stylesheet" href="/assets/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="/assets/css/style.css">
</head>

<body>

<main>
    <div class='form-signin w-100 mx-auto pt-5 mt-5'>
        <!-- Display error message if there is one -->
      <?php if ($error_msg) {
        echo '<div class="alert alert-danger">'.$error_msg.'</div>';
      } ?>
        <img class='mb-4' src='/assets/images/logo.png' alt='Bookshelf Logo' width='300'>
        <form action="<?= $self_url; ?>" method="post">
            <h1 class='h3 mb-3 fw-normal'>Sign in to Admin area</h1>

            <div class='form-floating'>
                <input type='email' name='email' class='form-control' id='floatingInput' placeholder='name@example.com' required>
                <label for='floatingInput'>Email address</label>
            </div>
            <div class='form-floating'>
                <input type='password' name='password' class='form-control' id='floatingPassword' placeholder='Password' required>
                <label for='floatingPassword'>Password</label>
            </div>

            <button class='w-100 btn btn-lg btn-primary' type='submit'>Sign in</button>
            <p class='text-center mt-5 text-muted'>Back to the <a href="/">Bookshelf</a></p>
        </form>
    </div>
</main>

<!-- Toast container -->
<div class='toast-container position-fixed top-0 end-0 p-3'>
    <div id='liveToast' class='toast' role='alert' aria-live='assertive' aria-atomic='true' data-bs-autohide='true'>
        <div class='toast-header'>
            <strong class='me-auto' data-toast-title></strong>
            <button type='button' class='btn-close' data-bs-dismiss='toast' aria-label='Close'></button>
        </div>
        <div class='toast-body' data-toast-body></div>
    </div>
</div>

<script src='/assets/bootstrap/js/bootstrap.min.js'></script>
<script src='/assets/js/script.js'></script>
<link rel='stylesheet' href='https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.3/font/bootstrap-icons.css'>
</body>
</html>