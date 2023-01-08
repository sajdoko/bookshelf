<?php

$page_title = "Register";
require_once 'includes/header.php';

if (login_check()) {
  header("Location: /");
  exit;
}

$error_msg = "";

if (isset($_POST['email'], $_POST['password'], $_POST['first_name'], $_POST['last_name'], $_POST['address'], $_POST['city'], $_POST['country'], $_POST['zipcode'])) {
  // Sanitize and validate the data passed in
  $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
  $email = filter_var($email, FILTER_VALIDATE_EMAIL);
  if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    // Not a valid email
    $error_msg .= '<p class="text-danger">The email address you entered is not valid</p>';
  } else {

    $password = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_STRING);
    $password = password_hash($password, PASSWORD_DEFAULT);
    if (strlen($password) != 128) {
      // The hashed pwd should be 128 characters long.
      // If it's not, something really odd has happened
      $error_msg .= '<p class="text-danger">Invalid password configuration.</p>';
    } else {

      $first_name = filter_input(INPUT_POST, 'first_name', FILTER_SANITIZE_STRING);
      $last_name = filter_input(INPUT_POST, 'last_name', FILTER_SANITIZE_STRING);
      $address = filter_input(INPUT_POST, 'address', FILTER_SANITIZE_STRING);
      $city = filter_input(INPUT_POST, 'city', FILTER_SANITIZE_STRING);
      $country = filter_input(INPUT_POST, 'country', FILTER_SANITIZE_STRING);
      $zipcode = filter_input(INPUT_POST, 'zipcode', FILTER_SANITIZE_STRING);

      // Check if email already exists
      if ($stmt = $mysqli->prepare("SELECT user_id FROM users WHERE email = ? LIMIT 1")) {
        $stmt->bind_param('s', $email);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows == 1) {
          // A user with this email address already exists
          $error_msg .= '<p class="text-danger">A user with this email address already exists.</p>';
          $stmt->close();
        } else {
          // Email doesn't exist. Insert a new user into the database
          if ($stmt = $mysqli->prepare("INSERT INTO users (email, password, first_name, last_name, address, city, country, zipcode, is_admin) VALUES (?, ?, ?, ?, ?, ?, ?, ?, 1)")) {
            $stmt->bind_param('ssssssss', $email, $password, $first_name, $last_name, $address, $city, $country, $zipcode);
            // Execute the prepared query.
            if (!$stmt->execute()) {
              $error_msg .= '<p class="text-danger">Registration failure: INSERT</p>';
            }
            $stmt->close();
            header('Location: login');
            exit();
          }
        }
      }
    }
  }
} else {
  // echo "<pre>";
  // print_r($_POST);
  // echo "</pre>";
}
?>

<div class="container mt-5">
  <h2 class="text-center mb-5">Register</h2>
  
  <?php if ($error_msg != "") : ?>
    <div class="row">
      <div class="col-md-6 offset-md-3"><?php echo $error_msg; ?></div>
    </div>
  <?php endif; ?>
  <div class="row">
    <div class="col-md-6 offset-md-3">
      <form id="register-form" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" role="form" style="display: block;">
        <div class="form-group">
          <input type="email" name="email" id="email" tabindex="1" class="form-control" placeholder="Email" value="">
        </div>
        <div class="form-group">
          <input type="password" name="password" id="password" tabindex="2" class="form-control" placeholder="Password">
        </div>
        <div class="form-group">
          <input type="password" name="confirm-password" id="confirm-password" tabindex="3" class="form-control" placeholder="Confirm Password">
        </div>
        <div class="form-group">
          <input type="text" name="first_name" id="first-name" tabindex="4" class="form-control" placeholder="First Name" value="">
        </div>
        <div class="form-group">
          <input type="text" name="last_name" id="last-name" tabindex="5" class="form-control" placeholder="Last Name" value="">
        </div>
        <div class="form-group">
          <input type="text" name="address" id="address" tabindex="6" class="form-control" placeholder="Address" value="">
        </div>
        <div class="form-group">
          <input type="text" name="city" id="city" tabindex="7" class="form-control" placeholder="City" value="">
        </div>
        <div class="form-group">
          <input type="text" name="country" id="country" tabindex="8" class="form-control" placeholder="Country" value="">
        </div>
        <div class="form-group">
          <input type="text" name="zipcode" id="zipcode" tabindex="9" class="form-control" placeholder="Zip Code" value="">
        </div>
        <div class="form-group">
          <div class="row">
            <div class="col-sm-6 col-sm-offset-3">
              <input type="submit" name="register-submit" id="register-submit" tabindex="10" class="form-control btn btn-primary" value="Register Now">
            </div>
          </div>
        </div>
      </form>
    </div>
  </div>
</div>

<?php require_once 'includes/footer.php'; ?>