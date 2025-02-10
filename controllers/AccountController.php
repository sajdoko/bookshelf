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
      $new_first_name = filter_input(INPUT_POST, 'first_name', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
      $new_last_name  = filter_input(INPUT_POST, 'last_name', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
      $new_phone      = filter_input(INPUT_POST, 'phone', FILTER_SANITIZE_FULL_SPECIAL_CHARS);

      $new_street     = filter_input(INPUT_POST, 'street', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
      $new_zip        = filter_input(INPUT_POST, 'zip', FILTER_SANITIZE_NUMBER_INT);
      $new_city       = filter_input(INPUT_POST, 'city', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
      $new_country_id = filter_input(INPUT_POST, 'country', FILTER_SANITIZE_FULL_SPECIAL_CHARS);

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