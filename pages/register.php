<?php

  $page_title = "Register";
  require_once '../includes/header.php';

  if (login_check_customer()) {
    header("Location: /");
    exit;
  }

  $error_msg = "";

  if (isset($_POST['email'], $_POST['password'], $_POST['first_name'], $_POST['last_name'], $_POST['phone'])) {
    // Sanitize and validate the data passed in
    $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
    $email = filter_var($email, FILTER_VALIDATE_EMAIL);
    if (!$email) {
      // Not a valid email
      $error_msg .= '<p class="text-danger">The email address you entered is not valid</p>';
    }
    else {
      $password_str = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_STRING);
      $password = password_hash($password_str, PASSWORD_DEFAULT);

      if (strlen($password) != 60) {
        // The hashed pwd should be 128 characters long.
        // If it's not, something really odd has happened
        $error_msg .= '<p class="text-danger">Invalid password configuration.</p>';
      }
      else {

        $first_name = filter_input(INPUT_POST, 'first_name', FILTER_SANITIZE_STRING);
        $last_name = filter_input(INPUT_POST, 'last_name', FILTER_SANITIZE_STRING);
        $phone = filter_input(INPUT_POST, 'phone', FILTER_SANITIZE_STRING);

        $user = retrieveOneRow('SELECT TOP 1 * FROM CUSTOMER WHERE Cus_Email = ?', [$email]);
        // Check if email already exists
        if (!$user) {

          $query = 'INSERT INTO CUSTOMER VALUES (?, ?, ?, ?, ?, ?)';

          if (!insertOrUpdateRows($query, [$first_name, $last_name, $email, $phone, 3, $password])) {
            $error_msg .= '<p class="text-danger">Registration failure: INSERT</p>';
          } else {
              if (login_customer($email, $password_str)) {
                  header('Location: /');
              } else {
                  header('Location: /pages/login');
              }
              exit();
          }

        }
        else {
          $error_msg .= '<p class="text-danger">There is a registered user with this email: '.$email.'</p>';
        }
      }
    }
  }
?>

<div class='form-signin w-100 m-auto'>
    <!-- Display error message if there is one -->
    <?php
      if ($error_msg) {
      echo '<div class="alert alert-danger">' . $error_msg . '</div>';
    }
      ?>
    <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post">
        <h1 class='h3 mb-3 fw-normal'>Register</h1>

        <div class='form-floating'>
            <input type='email' name='email' class='form-control' id='email' placeholder='name@example.com' required>
            <label for='email'>Email address</label>
        </div>
        <div class='form-floating'>
            <input type='password' name='password' class='form-control' id='password' placeholder='Password' required>
            <label for='password'>Password</label>
        </div>

        <div class='form-floating'>
            <input type='text' name='first_name' class='form-control' id='first_name' placeholder='First Name' required>
            <label for='first_name'>First Name</label>
        </div>
        <div class='form-floating'>
            <input type='text' name='last_name' class='form-control' id='last_name' placeholder='Last Name' required>
            <label for='last_name'>Last Name</label>
        </div>

        <div class='form-floating'>
            <input type='text' name='phone' class='form-control' id='phone' placeholder='Phone' required>
            <label for='phone'>Phone</label>
        </div>

        <button class='w-100 btn btn-lg btn-primary' type='submit'>Register</button>
        <p class='text-center mt-5 text-muted'>Do you have an account? <a href="../pages/login">Log In</a></p>
    </form>
</div>

<?php require_once '../includes/footer.php'; ?>