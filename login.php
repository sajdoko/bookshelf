<!-- Include header -->
<?php include 'includes/header.php'; ?>
<?php
  $error_msg = "";

  if (isset($_POST['email'], $_POST['password'])) {
    $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
    $password = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_STRING);

    if (login($email, $password)) {
      header("Location: /");
      exit();
    } else {
      $error_msg .= '<p class="text-danger">Invalid email or password</p>';
    }
  }
?>
<main>
  <div class="container mt-5">
    <h2 class="text-center mb-5">Log In</h2>
    <div class="row">
      <div class="col-md-6 offset-md-3">
        <!-- Display error message if there is one -->
        <?php if (isset($error)) {
          echo '<div class="alert alert-danger">' . $error . '</div>';
        } ?>
        <form action="login" method="post">
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
        <p class="text-center mt-5">Don't have an account? <a href="register">Sign up</a></p>
      </div>
    </div>
  </div>
</main>
<!-- Include footer -->
<?php include 'includes/footer.php'; ?>