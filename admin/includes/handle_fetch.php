<?php
  header('Content-Type: multipart/form-data');
  $json = file_get_contents('php://input');
  $data = json_decode($json, true);


  if ($_SERVER['REQUEST_METHOD'] === 'POST' && $data) {
    // Include database connection
    require_once dirname(__FILE__, 3).'/includes/db_conn.php';
    require_once dirname(__FILE__, 3).'/includes/functions.php';
    require_once dirname(__FILE__, 1).'/admin_functions.php';
    sec_session_start();
    if (!login_check_employee()) {
      http_response_code(403);
      exit(json_encode(['error' => 'Unauthorized']));
    }

    if (isset($data['edit_book'])) {

//      $Boo_ISBN = $data['Boo_ISBN'];
//      $quantity = (int) $data['quantity'];


      $resp['status'] = 'success';
      $resp['message'] = 'Book added to cart successfully!';
      $resp['post'] = $data;
      exit(json_encode($resp));
    }

  }
  http_response_code(405);
  exit(json_encode(['error' => 'Invalid request method']));