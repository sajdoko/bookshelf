<?php
  if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    require_once dirname(__DIR__) . '/includes/db_conn.php';
    require_once dirname(__DIR__) . '/includes/functions.php';

    $ordered_books = [];
    $user_id = $_SESSION['Cus_Id'] ?? 0;
    if (isset($_SESSION['cart']) && !empty($_SESSION['cart'])) {
      $ordered_books = $_SESSION['cart'];
      $_SESSION['cart'] = [];
    } else {
      $_SESSION['checkout_errors'][] = '<p class="text-danger">Your cart is empty!</p>';
      header('Location: /pages/checkout');
      exit;
    }

    $sh_m_id = filter_input(INPUT_POST, 'shippingMethod', FILTER_SANITIZE_NUMBER_INT);
    $payment_method = filter_input(INPUT_POST, 'paymentMethod', FILTER_SANITIZE_STRING);

    if (empty($ordered_books) || !$sh_m_id || !$payment_method) {
      $_SESSION['checkout_errors'][] = '<p class="text-danger">There seems to be an error!</p>';
      header('Location: /pages/checkout');
      exit;
    }

    $order_tot_val = 0.00;

    $array_to_question_marks = implode(',', array_fill(0, count($ordered_books), '?'));
    $query = 'SELECT * FROM BOOK WHERE Boo_ISBN IN ('.$array_to_question_marks.')';
    $cart_books = retrieveAllRows($query, array_map('strval', array_keys($ordered_books)));

    foreach ($cart_books as $book) {
      $order_tot_val += (float) $book['Boo_Price'] * (int) $ordered_books[$book['Boo_ISBN']];
    }

    $paypal_email = 'sajdoko-facilitator@gmail.com';
    $paypal_url = 'https://www.sandbox.paypal.com/cgi-bin/webscr';
    $return_url = 'https://bookshelf.test/pages/thank-you';
    $cancel_url = 'https://bookshelf.test/pages/checkout';
    $notify_url = 'https://bookshelf.test/includes/paypal_ipn.php';

    if (!$user_id) {
      // REGISTER Customer
      // Sanitize and validate the data passed in
      $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
      $email = filter_var($email, FILTER_VALIDATE_EMAIL);
      if (!$email) {
        // Not a valid email
        $_SESSION['checkout_errors'][] = '<p class="text-danger">The email address you entered is not valid</p>';
      }
      else {
        $password_str = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_STRING);
        $password = password_hash($password_str, PASSWORD_DEFAULT);

        if (!$password) {
          $_SESSION['checkout_errors'][] = '<p class="text-danger">Invalid password configuration.</p>';
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
            $_SESSION['checkout_errors'][] = '<p class="text-danger">You are already registered with this email: '.$email.'</p>';
          }
          else {
            $query = 'INSERT INTO CUSTOMER OUTPUT INSERTED.* VALUES (NEXT VALUE FOR SEQ_CUS_ID, ?, ?, ?, ?, ?, ?)';
            $customer = insertQuery($query, [$first_name, $last_name, $email, $password, $phone, date('Y-m-d H:i:s')]);
            if (!isset($customer['Cus_Id'])) {
              $_SESSION['checkout_errors'][] = '<p class="text-danger">Registration failure: INSERT CUSTOMER</p>';
            }
            else {
              if (
                executeQuery(
                  'INSERT INTO ADDRESS VALUES (?, NEXT VALUE FOR SEQ_ADD_ID, ?, ?, ?, ?)',
                  [$customer['Cus_Id'], $street, $zip, $city, $country_id]
                )
              ) {
                if (login_customer($email, $password_str)) {
                  $user_id = $customer['Cus_Id'];
                }
                else {
                  header('Location: /pages/login');
                  exit();
                }
              }
              else {
                $_SESSION['checkout_errors'][] = '<p class="text-danger">Your address could not be saved!</p>';
              }
            }
          }
        }
      }
    }

    $query = 'INSERT INTO CUS_ORDER OUTPUT INSERTED.* VALUES (NEXT VALUE FOR SEQ_ORD_ID, ?, ?, ?, ?)';
    $cus_order = insertQuery($query, [$user_id, $sh_m_id, date('Y-m-d H:i:s'), $order_tot_val]);
    if (!isset($cus_order['Ord_Id'])) {
      $_SESSION['checkout_errors'][] = '<p class="text-danger">Order creation failure: INSERT ORDER</p>';
    } else {
      foreach ($ordered_books as $Boo_ISBN => $quantity) {
        $Boo_Price = get_book_price($Boo_ISBN);
        executeQuery('INSERT INTO ORDER_LINE VALUES (?, ?, ?, ?, ?)',
          [$Boo_ISBN, $cus_order['Ord_Id'], $quantity, $Boo_Price * $quantity, $Boo_Price]);
      }

      if ($payment_method == 'paypal') {
        echo '<form action="'.$paypal_url.'" method="post" id="paypalForm">
                <input type="hidden" name="business" value="'.$paypal_email.'">
                <input type="hidden" name="cmd" value="_cart">
                <input type="hidden" name="upload" value="1">
                <input type="hidden" name="currency_code" value="USD">';
        $i = 1;
        foreach ($ordered_books as $Boo_ISBN => $quantity) {
          $Boo_Price = get_book_price($Boo_ISBN);
          echo '<input type="hidden" name="item_name_'.$i.'" value="'.$Boo_ISBN.'">
                <input type="hidden" name="amount_'.$i.'" value="'.$Boo_Price.'">
                <input type="hidden" name="quantity_'.$i.'" value="'.$quantity.'">';
          $i++;
        }
        echo '<input type="hidden" name="return" value="'.$return_url.'">
              <input type="hidden" name="cancel_return" value="'.$cancel_url.'">
              <input type="hidden" name="notify_url" value="'.$notify_url.'">
              <input type="hidden" name="custom" value="'.$cus_order['Ord_Id'].'">
              <input type="submit" value="Pay with PayPal">
              </form>';
        echo '<script>document.getElementById("paypalForm").submit();</script>';
        exit;
      } else {
        $query = 'INSERT INTO ORDER_HISTORY VALUES (?, ?, ?, ?)';
        executeQuery($query, [1, $cus_order['Ord_Id'], 'Order placed', date('Y-m-d H:i:s')]);
        $self_url = strtok($_SERVER['REQUEST_URI'], '?');
        header('Location: '.$self_url);
        exit;
      }
    }

    if (count($_SESSION['checkout_errors']) > 0) {
      header('Location: /pages/checkout');
      exit;
    }
  }

  $page_title = 'Thank You';
  require_once dirname(__DIR__) . '/views/header.php';
?>

    <div class="container mt-5">
        <div class="row">
            <div class="col-md-6 offset-md-3">
                <h1 class='text-success-emphasis'>Your Order Has Been Placed</h1>
                <p>Thank you for ordering with us, we'll contact you by email with your order details.</p>
                <p><a href="/">Return to the homepage</a></p>
            </div>
        </div>
    </div>

<?php require_once dirname(__DIR__) . '/views/footer.php'; ?>