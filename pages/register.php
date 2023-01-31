<?php

  $page_title = "Register";
  require_once '../includes/header.php';

  if (login_check_customer()) {
    header("Location: /");
    exit;
  }

  $error_msg = "";
  $countries = retrieveAllRows('SELECT * FROM COUNTRY ORDER BY Cou_Name');

  if (isset($_POST['submitRegister'])) {
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

      if (!$password) {
        $error_msg .= '<p class="text-danger">Invalid password configuration.</p>';
      }
      else {

        $first_name = filter_input(INPUT_POST, 'first_name', FILTER_SANITIZE_STRING);
        $last_name = filter_input(INPUT_POST, 'last_name', FILTER_SANITIZE_STRING);
        $phone = filter_input(INPUT_POST, 'phone', FILTER_SANITIZE_STRING);

        $street = filter_input(INPUT_POST, 'street', FILTER_SANITIZE_STRING);
        $zip = filter_input(INPUT_POST, 'zip', FILTER_SANITIZE_NUMBER_INT);
        $city = filter_input(INPUT_POST, 'city', FILTER_SANITIZE_STRING);
        $country_id = filter_input(INPUT_POST, 'country', FILTER_SANITIZE_STRING);

        $user = retrieveOneRow('SELECT TOP 1 * FROM CUSTOMER WHERE Cus_Email = ?', [$email]);
        // Check if email already exists
        if ($user) {
          $error_msg .= '<p class="text-danger">You are allready registered with this email: '.$email.'</p>';
        }
        else {
          $query = 'INSERT INTO CUSTOMER OUTPUT INSERTED.* VALUES (NEXT VALUE FOR SEQ_CUS_ID, ?, ?, ?, ?, ?, ?, ?)';
          $customer = insertQuery($query, [$first_name, $last_name, $email, $password, $phone, 3, date('Y-m-d H:i:s')]);
          if (!isset($customer['Cus_Id'])) {
            $error_msg .= '<p class="text-danger">Registration failure: INSERT CUSTOMER</p>';
          }
          else {
            if (
              executeQuery(
                'INSERT INTO ADDRESS VALUES (?, NEXT VALUE FOR SEQ_ADD_ID, ?, ?, ?, ?)',
                [$customer['Cus_Id'], $street, $zip, $city, $country_id]
              )
            ) {
              if (login_customer($email, $password_str)) {
                header('Location: /pages/account');
              }
              else {
                header('Location: /pages/login');
              }
              exit();
            }
            else {
              $error_msg .= '<p class="text-danger">Your address could not be saved!</p>';
            }
          }
        }
      }
    }
  }
?>

    <div class='form-signin w-100 m-auto'>
        <!-- Display error message if there is one -->
      <?php
        if ($error_msg) {
          echo '<div class="alert alert-danger">'.$error_msg.'</div>';
        }
      ?>
        <form action="<?= htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post">
            <h1 class='h3 mb-3 fw-normal'>Register</h1>
            <hr class='my-3'>
            <div class='row'>
                <div class='col-md-6'>
                    <label for='first_name'>First Name</label>
                    <input type='text' name='first_name' class='form-control' id='first_name' placeholder='First Name' required>
                </div>
                <div class='col-md-6'>
                    <label for='last_name'>Last Name</label>
                    <input type='text' name='last_name' class='form-control' id='last_name' placeholder='Last Name' required>
                </div>
                <div class='col-md-6'>
                    <label for='email'>Email address</label>
                    <input type='email' name='email' class='form-control' id='email' placeholder='name@example.com' required>
                </div>
                <div class='col-md-6'>
                    <label for='password'>Password</label>
                    <input type='password' name='password' class='form-control' id='password' placeholder='Password' required>
                </div>
                <div class='col-12'>
                    <label for='phone'>Phone</label>
                    <input type='text' name='phone' class='form-control' id='phone' placeholder='Phone' required>
                </div>
                <div class='col-md-9'>
                    <label for='street' class='form-label'>Street</label>
                    <input type='text' name='street' class='form-control' id='street' placeholder='1234 Main St' required>
                </div>
                <div class='col-md-3'>
                    <label for='zip' class='form-label'>Zip</label>
                    <input type='number' name="zip" class='form-control w-75' id='zip' placeholder='00000' required>
                </div>
                <div class='col-md-6'>
                    <label for='city' class='form-label'>City</label>
                    <input type='text' name='city' class='form-control' id='city' placeholder='Tirane' required>
                </div>
                <div class='col-md-6'>
                    <label for='country' class='form-label'>Country</label>
                    <select name="country" class='form-select' id='country' required>
                        <option value=''>Choose...</option>
                      <?php foreach ($countries as $country) : ?>
                          <option value="<?= $country['Cou_Alpha2Code']; ?>"><?= $country['Cou_Name']; ?></option>
                      <?php endforeach; ?>
                    </select>
                </div>
                <div class='col-12 mt-4'>
                    <input type='submit' name="submitRegister" value="Register" class='w-100 btn btn-lg btn-primary'>
                    <p class='text-center mt-5 text-muted'>Do you have an account? <a href='../pages/login'>Log In</a></p>
                </div>
            </div>
        </form>
    </div>

<?php require_once '../includes/footer.php'; ?>