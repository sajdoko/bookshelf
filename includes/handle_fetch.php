<?php
  header('Content-Type: application/json');
  $json = file_get_contents('php://input');
  $data = json_decode($json, true);

  if ($_SERVER['REQUEST_METHOD'] === 'POST' && $data) {
    // Include database connection
    require_once dirname(__DIR__) . '/includes/db_conn.php';
    require_once dirname(__DIR__) . '/includes/functions.php';

    if (isset($data['add_to_cart'])) {

      $Boo_ISBN = $data['Boo_ISBN'];
      $quantity = (int) $data['quantity'];

      $book = get_book_by_isbn($Boo_ISBN);
      if ($book && ($book['Boo_QOH'] > 0 && $book['Boo_QOH'] >= $quantity)) {
        if (isset($_SESSION['cart']) && is_array($_SESSION['cart'])) {
          if (array_key_exists($Boo_ISBN, $_SESSION['cart'])) {
            $_SESSION['cart'][$Boo_ISBN] += $quantity;
          }
          else {
            $_SESSION['cart'][$Boo_ISBN] = $quantity;
          }
        }
        else {
          $_SESSION['cart'] = [$Boo_ISBN => $quantity];
        }
        http_response_code(200);
        $resp['status'] = 'success';
        $resp['message'] = 'Book added to cart successfully!';
      }
      else {
        $resp['status'] = 'danger';
        $resp['message'] = 'Book cannot be added to cart!';
      }
      exit(json_encode($resp));
    }

  }
  http_response_code(405);
  exit(json_encode(['error' => 'Invalid request method']));