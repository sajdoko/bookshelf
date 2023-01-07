<?php

include_once 'includes/db_conn.php';
include_once 'includes/functions.php';

sec_session_start();

if (login_check() == true) {
    header("Location: index.php");
    exit();
}

$error_msg = "";

if (isset($_POST['email'], $_POST['password'])) {
    $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
    $password = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_STRING);

    if (login($email, $password) == true) {
        header("Location: index.php");
        exit();
    } else {
        $error_msg .= '<p class="error">Invalid email or password</p>';
    }
}
?>
<!DOCTYPE html>
<html>
  <head>
    <title>The Bookshelf - Login</title>
    <!-- Include Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">
    <!-- Include custom CSS -->
    <link rel="stylesheet" href="assets/css/style.css">
  </head>
  <body>
    <!-- Include header -->
    <?php include 'includes/header.php'; ?>
    <main>
      <div class="container mt-5">
        <h2 class="text-center mb-5">Log In</h2>
        <div class="row">
          <div class="col-md-6 offset-md-3">
            <!-- Display error message if there is one -->
            <?php if (isset($error)) {
              echo '<div class="alert alert-danger">' . $error . '</div>';
            } ?>
            <form action="login.php" method="post">
              <div class="form-group">
                <label for="email">Email</label>
                <input type="email" name="email" class="form-control" required>
              </div>
              <div class="form-group">
                <label for="password">Password</label>
                <input type="password" name="password" class="form-control" required>
              </div>
              <input type="submit" name="submit" value="Log In" class="btn btn-primary btn-block">
            </form>
            <p class="text-center mt-5">Don't have an account? <a href="register.php">Sign up</a></p>
          </div>
        </div>
      </div>
    </main>
    <!-- Include footer -->
    <?php include 'includes/footer.php'; ?>
  </body>
</html>