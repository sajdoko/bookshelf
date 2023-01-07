<?php
  // Start session
  session_start();

  // Check if user is already logged in
  if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] == true) {
    // Redirect to homepage
    header('Location: index');
    exit;
  }

  // Check if form has been submitted
  if (isset($_POST['submit'])) {
    // Include database connection and functions
    require_once 'includes/db_conn.php';
    require_once 'includes/functions.php';

    // Get form data
    //Escapes special characters in a string for use in an SQL statement, taking into account the current charset of the connection
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);

    // Check if email and password are empty
    if (empty($email) || empty($password)) {
      $error = 'All fields are required';
    } else {
      // Check if email is valid
      if (filter_var($email, FILTER_VALIDATE_EMAIL) === false) {
        $error = 'Invalid email';
      } else {
        // Check if email and password match a user in the database
        $query = "SELECT * FROM users WHERE email = '$email' AND password = '$password'";
        $result = mysqli_query($conn, $query);
        if (mysqli_num_rows($result) == 1) {
          // User found, log in user
          $_SESSION['logged_in'] = true;
          // Redirect to homepage
          header('Location: index');
          exit;
        } else {
          // Email and password do not match
          $error = 'Incorrect email or password';
        }
      }
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