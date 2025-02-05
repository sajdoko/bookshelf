<?php
require_once dirname(__DIR__) . '/models/BookModel.php';

class AuthController {
  public function login() {

    $error_msg = "";

    if (isset($_POST['email'], $_POST['password'])) {
      $Cus_Email    = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
      $Cus_Pass = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_STRING);

      // Check if email and password are not empty
      if (!empty($Cus_Email) || !empty($Cus_Pass)) {

        $query = 'SELECT Cus_Id, Cus_Email, Cus_Pass FROM CUSTOMER WHERE Cus_Email = ?';
        $user = retrieveOneRow($query, [$Cus_Email]);

        // Check if user exists in the database
        if ($user) {

          // Check if the password is correct
          if (password_verify($Cus_Pass, $user['Cus_Pass'])) {
            // die(var_dump($_SESSION));

            // Store the user_id and email in the session
            $_SESSION['Cus_Id'] = $user['Cus_Id'];
            $_SESSION['Cus_Email'] = $Cus_Email;
            $_SESSION['login_string'] = hash('sha512', $user['Cus_Pass'].$_SERVER['HTTP_USER_AGENT']);

            header("Location: /");
            exit();
          }
        } else {
          $error_msg .= '<p class="text-danger">Please enter correct username and password</p>';
        }

      } else {
        $error_msg .= '<p class="text-danger">Please enter username and password</p>';
      }
    }

    require_once dirname(__DIR__) . '/views/login.php';
  }

  public function register() {
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
            $query = 'INSERT INTO CUSTOMER OUTPUT INSERTED.* VALUES (NEXT VALUE FOR SEQ_CUS_ID, ?, ?, ?, ?, ?, ?)';
            $customer = insertQuery($query, [$first_name, $last_name, $email, $password, $phone, date('Y-m-d H:i:s')]);
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
    require_once dirname(__DIR__) . '/views/register.php';
  }
}