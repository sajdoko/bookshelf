<?php
  $page_title = "My account";
  require_once '../includes/header.php';

  // Check if the user is logged in
  if (!login_check()) {
    header("Location: /login");
    exit;
  }

  // Get the user's information
  $user_id = $_SESSION['user_id'];
  $errors = array();

  // Process form data when form is submitted
  if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validate form data
    $new_first_name = trim($_POST["first_name"]);
    $new_last_name = trim($_POST["last_name"]);
    $new_address = trim($_POST["address"]);
    $new_city = trim($_POST["city"]);
    $new_country = trim($_POST["country"]);
    $new_zipcode = trim($_POST["zipcode"]);
    $new_phone = trim($_POST["phone"]);


    // Check for empty fields
    if (empty($new_first_name)) {
      array_push($errors, "First name is required.");
    }
    if (empty($new_last_name)) {
      array_push($errors, "Last name is required.");
    }

    // If no errors, update the user's info in the database
    if (count($errors) == 0) {
      update_user_info($user_id, $new_first_name, $new_last_name, $new_address, $new_city, $new_country, $new_zipcode, $new_phone);
    }
  }

  // Get the user's info from the database
  $user = get_user_info($user_id);

  if (empty($user)) {
    header("Location: /login");
    exit;
  }
?>

  <!-- Use Bootstrap grid system to display featured books in a grid -->
  <div class="container mt-5">
    <?php if (!empty($errors)) : ?>
      <div class="row">
        <div class="col-md-6 offset-md-3">
          <?php foreach ($errors as $error): ?>
            <?php  echo '<div class="alert alert-danger">' . $error . '</div>'; ?>
          <?php endforeach; ?>
        </div>
      </div>
    <?php endif; ?>

    <div class="row">
      <div class="col-md-6 offset-md-3">
        <form id="register-form" method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" role="form" style="display: block;">
          <div class="form-group">
            <input type="text" name="first_name" id="first-name" tabindex="4" class="form-control" placeholder="First Name" value="<?php echo $user['first_name']; ?>">
          </div>
          <div class="form-group">
            <input type="text" name="last_name" id="last-name" tabindex="5" class="form-control" placeholder="Last Name" value="<?php echo $user['last_name']; ?>">
          </div>
          <div class="form-group">
            <input type="text" name="address" id="address" tabindex="6" class="form-control" placeholder="Address" value="<?php echo $user['address']; ?>">
          </div>
          <div class="form-group">
            <input type="text" name="city" id="city" tabindex="7" class="form-control" placeholder="City" value="<?php echo $user['city']; ?>">
          </div>
          <div class="form-group">
            <input type="text" name="country" id="country" tabindex="8" class="form-control" placeholder="Country" value="<?php echo $user['country']; ?>">
          </div>
          <div class="form-group">
            <input type="text" name="zipcode" id="zipcode" tabindex="9" class="form-control" placeholder="Zip Code" value="<?php echo $user['zipcode']; ?>">
          </div>
          <div class="form-group">
            <input type="text" name="phone" id="phone" tabindex="9" class="form-control" placeholder="Phone" value="<?php echo $user['phone']; ?>">
          </div>
          <div class="form-group">
            <div class="row">
              <div class="col-sm-6 col-sm-offset-3">
                <input type="submit" name="register-submit" id="register-submit" tabindex="10" class="form-control btn btn-primary" value="Update Info">
              </div>
            </div>
          </div>
        </form>
      </div>
    </div>

  </div>


<?php require_once '../includes/footer.php'; ?>