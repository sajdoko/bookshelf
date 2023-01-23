<?php
  $page_title = "My account";
  require_once '../includes/header.php';

  // Check if the user is logged in
  if (!login_check_customer()) {
    header("Location: /pages/login");
    exit;
  }

  // Get the user's information
  $user_id = $_SESSION['Cus_Id'];
  $errors = array();

  // Process form data when form is submitted
  if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validate form data
    $new_first_name = trim($_POST["first_name"]);
    $new_last_name = trim($_POST["last_name"]);
    $phone = trim($_POST['phone']);

    // Check for empty fields
    if (empty($new_first_name)) {
      $errors[] = "First name is required.";
    }
    if (empty($new_last_name)) {
      $errors[] = "Last name is required.";
    }

    // If no errors, update the user's info in the database
    if (count($errors) == 0) {
      update_user_info($user_id, $new_first_name, $new_last_name, $phone);
    }
  }

  // Get the user's info from the database
  $user = get_customer_info($user_id);

  if (empty($user)) {
    header("Location: /pages/login");
    exit;
  }
?>


<div class='form-signin w-100 m-auto'>
    <!-- Display error message if there is one -->
    <?php if (!empty($errors)) : ?>
      <div class="row">
        <div class="col-md-6 offset-md-3">
          <?php foreach ($errors as $error): ?>
            <?php  echo '<div class="alert alert-danger">' . $error . '</div>'; ?>
          <?php endforeach; ?>
        </div>
      </div>
    <?php endif; ?>
    <form action="<?php echo htmlspecialchars($_SERVER['REQUEST_URI']); ?>" method="post">
        <h1 class='h3 mb-3 fw-normal'>My Details</h1>

        <div class='form-floating'>
            <input type='email' name='email' class='form-control' id='email' value='<?php echo $user['Cus_Email']; ?>' required>
            <label for='email'>Email address</label>
        </div>
        <div class='form-floating'>
            <input type='password' name='password' class='form-control' id='password'>
            <label for='password'>Password</label>
        </div>

        <div class='form-floating'>
            <input type='text' name='first_name' class='form-control' id='first_name' value='<?php echo $user['Cus_FirstName']; ?>' required>
            <label for='first_name'>First Name</label>
        </div>
        <div class='form-floating'>
            <input type='text' name='last_name' class='form-control' id='last_name' value='<?php echo $user['Cus_LastName']; ?>' required>
            <label for='last_name'>Last Name</label>
        </div>

        <div class='form-floating'>
            <input type='text' name='phone' class='form-control' id='phone' value='<?php echo $user['Cus_Phone']; ?>' required>
            <label for='phone'>Phone</label>
        </div>

        <button class='w-100 btn btn-lg btn-primary' type='submit'>Update</button>
    </form>
</div>

<?php require_once '../includes/footer.php'; ?>