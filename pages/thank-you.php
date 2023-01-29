<?php
  if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    require_once '../includes/db_conn.php';
    require_once '../includes/functions.php';
    sec_session_start();
    $ordered_books = [];
    $user_id = $_SESSION['Cus_Id'] ?? 0;
    if (isset($_SESSION['cart'])) {
      $ordered_books = $_SESSION['cart'];
      $_SESSION['cart'] = [];
    }

    $sh_m_id = filter_input(INPUT_POST, 'shippingMethod', FILTER_SANITIZE_NUMBER_INT);

    if (empty($ordered_books) || !$user_id || !$sh_m_id) {
      $_SESSION['checkout_errors'][] = '<p class="text-danger">There seems to be an error!</p>';
      header('Location: /pages/checkout');
      exit;
    }

    $order_tot_val = 0.00;

    $array_to_question_marks = implode(',', array_fill(0, count($ordered_books), '?'));
    $query = 'SELECT * FROM BOOK WHERE Boo_ISBN IN ('.$array_to_question_marks.')';
    $cart_books = retrieveAllRows($query, array_keys($ordered_books));

    foreach ($cart_books as $book) {
      $order_tot_val += (float) $book['Boo_Price'] * (int) $ordered_books[$book['Boo_ISBN']];
    }


    $query = 'INSERT INTO CUS_ORDER OUTPUT INSERTED.* VALUES (NEXT VALUE FOR SEQ_ORD_ID, ?, ?, ?, ?)';
    $cus_order = insertQuery($query, [$user_id, $sh_m_id, date('Y-m-d H:i:s'), $order_tot_val]);
    if (!isset($cus_order['Ord_Id'])) {
      $_SESSION['checkout_errors'][] = '<p class="text-danger">Registration failure: INSERT CUSTOMER</p>';
    }

    foreach ($ordered_books as $Boo_ISBN => $quantity) {
      executeQuery('INSERT INTO ORDER_LINE VALUES (?, ?, ?, ?)',
        [$Boo_ISBN, $cus_order['Ord_Id'], $quantity, calc_tot_book_price($Boo_ISBN, $quantity)]);
    }

    $self_url = strtok($_SERVER['REQUEST_URI'], '?');
    header('Location: '.$self_url);
    exit;
  }

  $page_title = 'Thank You';
  require_once '../includes/header.php';
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

<?php require_once '../includes/footer.php'; ?>