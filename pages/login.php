<!-- Include header -->
<?php
  $page_title = 'Login';
  include '../includes/header.php';

  $error_msg = "";
  $self_url = strtok($_SERVER['REQUEST_URI'], '?');

  if (isset($_POST['email'], $_POST['password'])) {
    $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
    $password = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_STRING);

    if (login_customer($email, $password)) {
      header("Location: /");
      exit();
    }
    else {
      $error_msg .= '<p class="text-danger">Invalid email or password</p>';
    }
  }
?>

<div class='form-signin w-100 m-auto'>
    <!-- Display error message if there is one -->
  <?php if ($error_msg) {
    echo '<div class="alert alert-danger">'.$error_msg.'</div>';
  } ?>
    <form action="<?= $self_url; ?>" method="post">
        <h1 class='h3 mb-3 fw-normal'>Please sign in</h1>

        <div class='form-floating'>
            <input type='email' name='email' class='form-control' id='floatingInput' placeholder='name@example.com'>
            <label for='floatingInput'>Email address</label>
        </div>
        <div class='form-floating'>
            <input type='password' name='password' class='form-control' id='floatingPassword' placeholder='Password'>
            <label for='floatingPassword'>Password</label>
        </div>

        <button class='w-100 btn btn-lg btn-primary' type='submit'>Sign in</button>
        <p class='text-center mt-5 text-muted'>Don't have an account? <a href="../pages/register">Register</a></p>
    </form>
</div>

<!-- Include footer -->
<?php include '../includes/footer.php'; ?>