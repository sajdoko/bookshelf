<?php
  $page_title = "My account";
  require_once '../includes/header.php';

  // Check if the user is logged in
  if (!login_check_customer()) {
    header("Location: /pages/login");
    exit;
  }

  $user_id = $_SESSION['Cus_Id'] ?? 0;
  $alerts = [];

  // Process form data when form is submitted
  if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validate form data
    $new_first_name = filter_input(INPUT_POST, 'first_name', FILTER_SANITIZE_STRING);
    $new_last_name = filter_input(INPUT_POST, 'last_name', FILTER_SANITIZE_STRING);
    $new_phone = filter_input(INPUT_POST, 'phone', FILTER_SANITIZE_STRING);

    $new_street = filter_input(INPUT_POST, 'street', FILTER_SANITIZE_STRING);
    $new_zip = filter_input(INPUT_POST, 'zip', FILTER_SANITIZE_NUMBER_INT);
    $new_city = filter_input(INPUT_POST, 'city', FILTER_SANITIZE_STRING);
    $new_country_id = filter_input(INPUT_POST, 'country', FILTER_SANITIZE_STRING);

    // Check for empty fields
    if (empty($new_first_name)) {
      $alerts[] = ["danger", "First name is required."];
    }
    if (empty($new_last_name)) {
      $alerts[] = ["danger", "Last name is required."];
    }

    // If no alerts, update the user's info in the database
    if (count($alerts) == 0) {
      if (update_user_info($user_id, $new_first_name, $new_last_name, $new_phone, $new_street, $new_zip, $new_city, $new_country_id)) {
        $alerts[] = ['success', 'Your profile was updated successfully!'];
      }
    }
  }

  // Get the user's info from the database
  $user = get_customer_info($user_id);

  if (empty($user)) {
    header("Location: /pages/login");
    exit;
  }

  $countries = retrieveAllRows('SELECT * FROM COUNTRY ORDER BY Cou_Name');
?>


    <div class='container'>
        <!-- Display error message if there is one -->
      <?php if (!empty($alerts)) : ?>
          <div class="row">
              <div class="col-md-6 offset-md-3">
                <?php foreach ($alerts as $alert): ?>
                  <?php echo '<div class="alert alert-'.$alert[0].'">'.$alert[1].'</div>'; ?>
                <?php endforeach; ?>
              </div>
          </div>
      <?php endif; ?>
        <form action="<?= htmlspecialchars($_SERVER['REQUEST_URI']); ?>" method='post' class='row g-2'>
            <div class='col-md me-4'>
                <h1 class='h3 mb-3 fw-normal'>My Details</h1>
                <hr class='mt-3'>
                <div class='row g-2'>
                    <div class='col-md'>
                        <div class='form-floating'>
                            <input type='email' name='email' class='form-control' id='email' value='<?= $user['Cus_Email']; ?>' disabled>
                            <label for='email'>Email address</label>
                        </div>
                    </div>
                    <div class='col-md'>
                        <div class='form-floating'>
                            <input type='password' name='password' class='form-control' id='password'>
                            <label for='password'>Password</label>
                        </div>
                    </div>
                </div>
                <div class='row g-2'>
                    <div class='col-md'>
                        <div class='form-floating'>
                            <input type='text' name='first_name' class='form-control' id='first_name' value='<?= $user['Cus_FirstName']; ?>' required>
                            <label for='first_name'>First Name</label>
                        </div>
                    </div>
                    <div class='col-md'>
                        <div class='form-floating'>
                            <input type='text' name='last_name' class='form-control' id='last_name' value='<?= $user['Cus_LastName']; ?>' required>
                            <label for='last_name'>Last Name</label>
                        </div>
                    </div>
                </div>

                <div class='form-floating'>
                    <input type='text' name='phone' class='form-control' id='phone' value='<?= $user['Cus_Phone']; ?>' required>
                    <label for='phone'>Phone</label>
                </div>
            </div>
            <div class='col-md border-start ps-4'>
                <h1 class='h3 mb-3 fw-normal'>My Address</h1>
                <hr class='my-3'>
                <div class='row'>
                    <div class='col-12'>
                        <div class='form-floating'>
                            <input type='text' name='street' class='form-control' id='street' value="<?= $user['Add_Street_Name']; ?>"
                                   placeholder='1234 Main St'
                                   required>
                            <label for='street' class='form-label'>Address</label>
                        </div>
                    </div>
                    <div class='col-md-4'>
                        <div class='form-floating'>
                            <input type='text' name='city' class='form-control' id='city' value="<?= $user['Add_City']; ?>" placeholder='Tirane'
                                   required>
                            <label for='city' class='form-label'>City</label>
                        </div>
                    </div>
                    <div class='col-md-5'>
                        <div class='form-floating'>
                            <select name='country' class='form-select' id='country' required>
                                <option value=''>Choose...</option>
                              <?php foreach ($countries as $country) : ?>
                                  <option value="<?= $country['Cou_Alpha2Code']; ?>" <?= $country['Cou_Alpha2Code'] == $user['Cou_Alpha2Code'] ? 'selected' : ''; ?>><?= $country['Cou_Name']; ?></option>
                              <?php endforeach; ?>
                            </select>
                            <label for='country' class='form-label'>Country</label>
                        </div>
                    </div>
                    <div class='col-md-3'>
                        <div class='form-floating'>
                            <input type='number' name='zip' class='form-control w-75' id='zip' value="<?= $user['Add_Zip']; ?>" placeholder='Zip'
                                   required>
                            <label for='zip' class='form-label'>Zip</label>
                        </div>
                    </div>
                </div>
            </div>
            <div class='col-12 text-center mt-4'>
                <button class='w-50 btn btn-lg btn-primary' type='submit'>Update</button>
            </div>
        </form>
    </div>

<?php require_once '../includes/footer.php'; ?>