<?php

class CartController {

  private $products_in_cart = [];

  public function __construct() {
    $this->products_in_cart = $_SESSION['cart'] ?? [];
  }

  public function cart() {
    $self_url = strtok($_SERVER['REQUEST_URI'], '?');

    // Process form data when form is submitted
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
      if (isset($_POST['Boo_ISBN'], $_POST['quantity'])) {

        $Boo_ISBN = $_POST['Boo_ISBN'];
        $quantity = (int) $_POST['quantity'];

        $book = BookModel::getBookByIsbn($Boo_ISBN);
        if ($book && $quantity > 0) {
          if (isset($_SESSION['cart']) && is_array($_SESSION['cart'])) {
            if (array_key_exists($Boo_ISBN, $_SESSION['cart'])) {
              $_SESSION['cart'][$Boo_ISBN] += $quantity;
            } else {
              $_SESSION['cart'][$Boo_ISBN] = $quantity;
            }
          } else {
            $_SESSION['cart'] = [$Boo_ISBN => $quantity];
          }
        }
      } else {
        if (isset($_POST['update']) && isset($_SESSION['cart'])) {
          foreach ($_POST as $k => $v) {
            if (str_contains($k, 'quantity') && is_numeric($v)) {
              $id       = str_replace('quantity-', '', $k);
              $quantity = (int) $v;
              // Always do checks and validation
              if (isset($_SESSION['cart'][$id]) && $quantity > 0) {
                // Update new quantity
                $_SESSION['cart'][$id] = $quantity;
              }
            }
          }
        }
      }
      header('Location: ' . $self_url);
      exit;
    } else {
      if (isset($_GET['remove']) && isset($_SESSION['cart']) && isset($_SESSION['cart'][$_GET['remove']])) {
        // Remove the product from the shopping cart
        unset($_SESSION['cart'][$_GET['remove']]);
        header('Location: ' . $self_url);
        exit;
      }
    }

    $cart_books       = [];
    $subtotal         = 0.00;
    $products_in_cart = $this->products_in_cart;

    if ($products_in_cart) {
      // $array_to_question_marks = implode(',', array_fill(0, count($this->products_in_cart), '?'));
      // $query = 'SELECT * FROM BOOK WHERE Boo_ISBN IN ('.$array_to_question_marks.')';
      // $cart_books = retrieveAllRows($query, array_map('strval', array_keys($this->products_in_cart)));
      $cart_books = BookModel::getBooksByIsbns(array_map('strval', array_keys($products_in_cart)));
      foreach ($cart_books as $book) {
        $subtotal += (float) $book['Boo_Price'] * (int) $products_in_cart[$book['Boo_ISBN']];
      }
    }

    require_once dirname(__DIR__) . '/views/cart.php';
  }

  public function checkout() {

    $user_id = $_SESSION['Cus_Id'] ?? 0;
    $errors  = [];
    if (isset($_SESSION['checkout_errors'])) {
      $errors = $_SESSION['checkout_errors'];
      unset($_SESSION['checkout_errors']);
    }

    $cart_books       = [];
    $subtotal         = 0.00;
    $products_in_cart = $this->products_in_cart;

    if ($products_in_cart) {
      // $array_to_question_marks = implode(',', array_fill(0, count($this->products_in_cart), '?'));
      // $query = 'SELECT * FROM BOOK WHERE Boo_ISBN IN ('.$array_to_question_marks.')';
      // $cart_books = retrieveAllRows($query, array_map('strval', array_keys($this->products_in_cart)));
      $cart_books = BookModel::getBooksByIsbns(array_map('strval', array_keys($products_in_cart)));
      foreach ($cart_books as $book) {
        $subtotal += (float) $book['Boo_Price'] * (int) $products_in_cart[$book['Boo_ISBN']];
      }
    } else {
      $errors[] = "You don't have any books added to your shopping cart!";
    }

    $countries        = CountryModel::getAllCountries();
    $shipping_methods = retrieveAllRows('SELECT * FROM SHIPPING_METHOD');

    require_once dirname(__DIR__) . '/views/checkout.php';
  }

  public function thank_you() {

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {

      $ordered_books = $this->products_in_cart;
      $user_id       = $_SESSION['Cus_Id'] ?? 0;
      if (!empty($ordered_books)) {
        $_SESSION['cart'] = [];
      } else {
        $_SESSION['checkout_errors'][] = '<p class="text-danger">Your cart is empty!</p>';
        header('Location: /checkout');
        exit;
      }

      $sh_m_id        = filter_input(INPUT_POST, 'shippingMethod', FILTER_SANITIZE_NUMBER_INT);
      $payment_method = filter_input(INPUT_POST, 'paymentMethod', FILTER_SANITIZE_FULL_SPECIAL_CHARS);

      if (!$sh_m_id || !$payment_method) {
        $_SESSION['checkout_errors'][] = '<p class="text-danger">There seems to be an error!</p>';
        header('Location: /checkout');
        exit;
      }

      $order_tot_val = 0.00;
      $cart_books = BookModel::getBooksByIsbns(array_map('strval', array_keys($ordered_books)));

      foreach ($cart_books as $book) {
        $order_tot_val += (float) $book['Boo_Price'] * (int) $ordered_books[$book['Boo_ISBN']];
      }

      $paypal_email = 'sajdoko-facilitator@gmail.com';
      $paypal_url   = 'https://www.sandbox.paypal.com/cgi-bin/webscr';
      $return_url   = 'https://bookshelf.test/thank-you';
      $cancel_url   = 'https://bookshelf.test/checkout';
      $notify_url   = 'https://bookshelf.test/includes/paypal_ipn.php';

      if (! $user_id) {
        // REGISTER Customer
        // Sanitize and validate the data passed in
        $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
        $email = filter_var($email, FILTER_VALIDATE_EMAIL);
        if (! $email) {
          // Not a valid email
          $_SESSION['checkout_errors'][] = '<p class="text-danger">The email address you entered is not valid</p>';
        } else {
          $password_str = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
          $password     = password_hash($password_str, PASSWORD_DEFAULT);

          if (! $password) {
            $_SESSION['checkout_errors'][] = '<p class="text-danger">Invalid password configuration.</p>';
          } else {

            $first_name = filter_input(INPUT_POST, 'first_name', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $last_name  = filter_input(INPUT_POST, 'last_name', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $phone      = filter_input(INPUT_POST, 'phone', FILTER_SANITIZE_FULL_SPECIAL_CHARS);

            $street     = filter_input(INPUT_POST, 'street', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $zip        = filter_input(INPUT_POST, 'zip', FILTER_SANITIZE_NUMBER_INT);
            $city       = filter_input(INPUT_POST, 'city', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $country_id = filter_input(INPUT_POST, 'country', FILTER_SANITIZE_FULL_SPECIAL_CHARS);

            $user = CustomerModel::retrieveCustomerByEmail($email);
            // Check if email already exists
            if ($user) {
              $_SESSION['checkout_errors'][] = '<p class="text-danger">You are already registered with this email: ' . $email . '</p>';
            } else {
              $customer = CustomerModel::addOneCustomer($first_name, $last_name, $email, $password, $phone);
              if (! isset($customer['Cus_Id'])) {
                $_SESSION['checkout_errors'][] = '<p class="text-danger">Registration failure: INSERT CUSTOMER</p>';
              } else {
                if (CustomerModel::addCustomerAddress($customer['Cus_Id'], $street, $zip, $city, $country_id)) {
                  if (login_customer($email, $password_str)) {
                    $user_id = $customer['Cus_Id'];
                  } else {
                    header('Location: /login');
                    exit();
                  }
                } else {
                  $_SESSION['checkout_errors'][] = '<p class="text-danger">Your address could not be saved!</p>';
                }
              }
            }
          }
        }
      }

      $cus_order = CusOrderModel::addCustomerOrder($user_id, $sh_m_id, $order_tot_val);
      if (! isset($cus_order['Ord_Id'])) {
        $_SESSION['checkout_errors'][] = '<p class="text-danger">Order creation failure: INSERT ORDER</p>';
      } else {
        foreach ($ordered_books as $Boo_ISBN => $quantity) {
          $Boo_Price = BookModel::getBookPrice($Boo_ISBN);
          executeQuery('INSERT INTO ORDER_LINE VALUES (?, ?, ?, ?, ?)',
            [$Boo_ISBN, $cus_order['Ord_Id'], $quantity, $Boo_Price * $quantity, $Boo_Price]);
        }
        CusOrderModel::addOrderHistory(1, $cus_order['Ord_Id'], "Order Placed");
        if ($payment_method == 'paypal') {
          echo '<form action="' . $paypal_url . '" method="post" id="paypalForm">
                <input type="hidden" name="business" value="' . $paypal_email . '">
                <input type="hidden" name="cmd" value="_cart">
                <input type="hidden" name="upload" value="1">
                <input type="hidden" name="currency_code" value="USD">';
          $i = 1;
          foreach ($ordered_books as $Boo_ISBN => $quantity) {
            $Boo_Price = BookModel::getBookPrice($Boo_ISBN);
            echo '<input type="hidden" name="item_name_' . $i . '" value="' . $Boo_ISBN . '">
                <input type="hidden" name="amount_' . $i . '" value="' . $Boo_Price . '">
                <input type="hidden" name="quantity_' . $i . '" value="' . $quantity . '">';
            $i++;
          }
          echo '<input type="hidden" name="return" value="' . $return_url . '">
              <input type="hidden" name="cancel_return" value="' . $cancel_url . '">
              <input type="hidden" name="notify_url" value="' . $notify_url . '?custom=' . $cus_order['Ord_Id'] . '">
              <input type="hidden" name="custom" value="' . $cus_order['Ord_Id'] . '">
              <input type="submit" value="Pay with PayPal">
              </form>';
          echo '<script>document.getElementById("paypalForm").submit();</script>';
          exit;
        } else {
          $self_url = strtok($_SERVER['REQUEST_URI'], '?');
          header('Location: ' . $self_url);
          exit;
        }
      }

      if (count($_SESSION['checkout_errors']) > 0) {
        header('Location: /checkout');
        exit;
      }
    }

    require_once dirname(__DIR__) . '/views/thank-you.php';
  }

}