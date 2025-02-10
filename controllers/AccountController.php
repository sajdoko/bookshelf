<?php
class AccountController {

  private $user_id;
  private $user;

  public function __construct() {
    if (! login_check_customer()) {
      header("Location: /login");
      exit;
    }
    $this->user_id = $_SESSION['Cus_Id'] ?? 0;

    // Get the user's info from the database
    $this->user = get_customer_info($this->user_id);

    if (empty($this->user)) {
      header("Location: /login");
      exit;
    }
  }

  public function account() {
    $alerts = [];

    // Process form data when form is submitted
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
      // Validate form data
      $new_first_name = sanitizeInput($_POST['first_name']);
      $new_last_name  = sanitizeInput($_POST['last_name']);
      $new_phone      = sanitizeInput($_POST['phone']);

      $new_street     = sanitizeInput($_POST['street']);
      $new_zip        = sanitizeInput($_POST['zip']);
      $new_city       = sanitizeInput($_POST['city']);
      $new_country_id = sanitizeInput($_POST['country_id']);

      // Check for empty fields
      if (empty($new_first_name)) {
        $alerts[] = ["danger", "First name is required."];
      }
      if (empty($new_last_name)) {
        $alerts[] = ["danger", "Last name is required."];
      }

      // If no alerts, update the user's info in the database
      if (count($alerts) == 0) {
        if (update_customer_info($this->user_id, $new_first_name, $new_last_name, $new_phone, $new_street, $new_zip, $new_city, $new_country_id)) {
          $alerts[] = ['success', 'Your profile was updated successfully!'];
        }
      }
    }

    // Get the user's info from the database
    $user      = $this->user;
    $countries = CountryModel::getAllCountries();

    require_once dirname(__DIR__) . '/views/account.php';
  }

  public function customer_orders() {
    $alerts     = [];
    $cus_orders = CusOrderModel::getCustomerOrders($this->user_id);

    require_once dirname(__DIR__) . '/views/orders.php';
  }
}