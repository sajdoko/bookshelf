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

    if (isset($data['form_action']) && in_array($data['form_action'], ['insert_book', 'update_book', 'delete_book'])) {

      $form_action = $data['form_action'];
      $Aut_Id = (int) $data['Aut_Id'];
      $Gen_Id = (int) $data['Gen_Id'];
      $BoL_Id = (int) $data['BoL_Id'];
      $Boo_QOH = (int) $data['Boo_QOH'];
      $Pub_Id = (int) $data['Pub_Id'];
      $Boo_Price = (float) $data['Boo_Price'];
      $Boo_Title = filter_var($data['Boo_Title'], FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH);
      $Boo_ISBN = $data['Boo_ISBN'];
      $Boo_Description = filter_var($data['Boo_Description'], FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH);
      $Boo_Pub_Date = $data['Boo_Pub_Date'];
      $Boo_Img_url = $data['Boo_Img_url'];
      $Boo_Featured = isset($data['Boo_Featured']) ? 1 : 0;

      if (!$Boo_ISBN) {
        $resp['status'] = 'danger';
        $resp['message'] = 'Please fill all the required fields!';
        $resp['post'] = $data;
        exit(json_encode($resp));
      }
      $exec_query = false;

      if ($form_action == 'update_book') {
        $query = 'UPDATE BOOK SET Pub_Id = ?, BoL_Id = ?, Boo_Title = ?, Boo_Description = ?, Boo_Price = ?, Boo_Pub_Date = ?, Boo_Img_url = ?, Boo_Featured = ?, Boo_QOH = ? WHERE Boo_ISBN = ?';
        $exec_query = executeQuery($query,
          [$Pub_Id, $BoL_Id, $Boo_Title, $Boo_Description, $Boo_Price, $Boo_Pub_Date, $Boo_Img_url, $Boo_Featured, $Boo_QOH, $Boo_ISBN]);
      }
      else {
        if ($form_action == 'insert_book') {
          $query = 'IF NOT EXISTS (SELECT 1 FROM BOOK WHERE Boo_ISBN = ?) INSERT INTO BOOK VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)';
          $exec_query = executeQuery($query,
            [$Boo_ISBN, $Boo_ISBN, $Pub_Id, $BoL_Id, $Boo_Title, $Boo_Description, $Boo_Price, $Boo_Pub_Date, $Boo_Img_url, $Boo_Featured, $Boo_QOH]);
        }
        else {
          if ($form_action == 'delete_book') {
            if (executeQuery('DELETE FROM BOOK WHERE Boo_ISBN = ?', [$Boo_ISBN])) {
              $resp['status'] = 'success';
              $resp['message'] = 'Book deleted!';
              exit(json_encode($resp));
            }
          }
          else {
            $resp['status'] = 'danger';
            $resp['message'] = 'Action not permitted!';
            $resp['post'] = $data;
            exit(json_encode($resp));
          }
        }
      }

      if ($exec_query) {
        if (
          !insertQuery('IF NOT EXISTS (SELECT 1 FROM BOOK_AUTHOR WHERE Boo_ISBN = ? AND Aut_Id = ?) INSERT INTO BOOK_AUTHOR OUTPUT INSERTED.* VALUES (?, ?)',
            [$Boo_ISBN, $Aut_Id, $Boo_ISBN, $Aut_Id])
        ) {
          $resp['message'] = "Book $form_action but the author could not be saved!";
        }
        else {
          if (
            !insertQuery('IF NOT EXISTS (SELECT 1 FROM BOOK_GENRE WHERE Boo_ISBN = ? AND Gen_Id = ?) INSERT INTO BOOK_GENRE OUTPUT INSERTED.* VALUES (?, ?)',
              [$Boo_ISBN, $Gen_Id, $Boo_ISBN, $Gen_Id])
          ) {
            $resp['message'] = "Book $form_action but the genre could not be saved!";
          }
        }
        $resp['message'] = "Book $form_action successfully!";
        $resp['status'] = 'success';
      }
      else {
        $resp['status'] = 'danger';
        $resp['message'] = "Book could not be $form_action!";
      }
      $resp['post'] = $data;
      exit(json_encode($resp));
    }

  }
  http_response_code(405);
  exit(json_encode(['error' => 'Invalid request method']));