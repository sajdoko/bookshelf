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

    if (isset($data['form_action']) && in_array($data['form_action'], ['insert', 'update', 'delete']) && isset($data['model'])) {
      if ($data['model'] == 'book') {

        $form_action = $data['form_action'];
        $Boo_ISBN = $data['Boo_ISBN'] ?? false;
        if (!$Boo_ISBN) {
          $resp['status'] = 'danger';
          $resp['message'] = 'Please fill all the required fields!';
          $resp['post'] = $data;
          exit(json_encode($resp));
        }
        if ($form_action == 'delete') {
          if (executeQuery('DELETE FROM BOOK WHERE Boo_ISBN = ?', [$Boo_ISBN])) {
            $resp['status'] = 'success';
            $resp['message'] = 'Book deleted!';
          }
          else {
            $resp['status'] = 'danger';
            $resp['message'] = 'The Book could not be deleted!';
          }
          exit(json_encode($resp));
        }
        $Aut_Id = (int) $data['Aut_Id'] ?? 0;
        $Gen_Id = (int) $data['Gen_Id'] ?? 0;
        $BoL_Id = (int) $data['BoL_Id'] ?? 0;
        $Boo_QOH = (int) $data['Boo_QOH'] ?? 0;
        $Pub_Id = (int) $data['Pub_Id'] ?? 0;
        $Boo_Price = (float) $data['Boo_Price'] ?? 0;
        $Boo_Title = filter_var($data['Boo_Title'] ?? false, FILTER_SANITIZE_FULL_SPECIAL_CHARS, FILTER_FLAG_STRIP_HIGH);
        $Boo_Description = filter_var($data['Boo_Description'] ?? false, FILTER_SANITIZE_FULL_SPECIAL_CHARS, FILTER_FLAG_STRIP_HIGH);
        $Boo_Pub_Date = $data['Boo_Pub_Date'] ?? false;
        $Boo_Img_url = $data['Boo_Img_url'] ?? false;
        $Boo_Featured = isset($data['Boo_Featured']) ? 1 : 0;

        $exec_query = false;

        if ($form_action == 'update') {
          $query = 'UPDATE BOOK SET Pub_Id = ?, BoL_Id = ?, Boo_Title = ?, Boo_Description = ?, Boo_Price = ?, Boo_Pub_Date = ?, Boo_Img_url = ?, Boo_Featured = ?, Boo_QOH = ? WHERE Boo_ISBN = ?';
          $exec_query = executeQuery($query,
            [$Pub_Id, $BoL_Id, $Boo_Title, $Boo_Description, $Boo_Price, $Boo_Pub_Date, $Boo_Img_url, $Boo_Featured, $Boo_QOH, $Boo_ISBN]);
        }
        else {
          if ($form_action == 'insert') {
            $query = 'IF NOT EXISTS (SELECT 1 FROM BOOK WHERE Boo_ISBN = ?) INSERT INTO BOOK VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)';
            $exec_query = executeQuery($query,
              [
                $Boo_ISBN, $Boo_ISBN, $Pub_Id, $BoL_Id, $Boo_Title, $Boo_Description, $Boo_Price, $Boo_Pub_Date, $Boo_Img_url, $Boo_Featured, $Boo_QOH
              ]);
          }
          else {
            $resp['status'] = 'danger';
            $resp['message'] = 'Action not permitted!';
            $resp['post'] = $data;
            exit(json_encode($resp));
          }
        }

        if ($exec_query) {
          if (
            !insertQuery('IF NOT EXISTS (SELECT 1 FROM BOOK_AUTHOR WHERE Boo_ISBN = ? AND Aut_Id = ?) INSERT INTO BOOK_AUTHOR OUTPUT INSERTED.* VALUES (?, ?)',
              [$Boo_ISBN, $Aut_Id, $Boo_ISBN, $Aut_Id])
          ) {
            $resp['message'] = "Book $form_action ed but the author could not be saved!";
          }
          else {
            if (
              !insertQuery('IF NOT EXISTS (SELECT 1 FROM BOOK_GENRE WHERE Boo_ISBN = ? AND Gen_Id = ?) INSERT INTO BOOK_GENRE OUTPUT INSERTED.* VALUES (?, ?)',
                [$Boo_ISBN, $Gen_Id, $Boo_ISBN, $Gen_Id])
            ) {
              $resp['message'] = "Book $form_action ed but the genre could not be saved!";
            }
          }
          $resp['message'] = "Book $form_action ed successfully!";
          $resp['status'] = 'success';
        }
        else {
          $resp['status'] = 'danger';
          $resp['message'] = "Book could not be $form_action ed!";
        }
        $resp['post'] = $data;
        exit(json_encode($resp));
      }
      else if ($data['model'] == 'customer') {

        $form_action = $data['form_action'];
        $Cus_Id = $data['Cus_Id'] ?? false;

        if (!$Cus_Id && in_array($data['form_action'], ['update', 'delete'])) {
          $resp['status'] = 'danger';
          $resp['message'] = 'Please fill all the required fields!';
          $resp['post'] = $data;
          exit(json_encode($resp));
        }
        if ($form_action == 'delete') {
          if (executeQuery('DELETE FROM CUSTOMER WHERE Cus_Id = ?', [$Cus_Id])) {
            $resp['status'] = 'success';
            $resp['message'] = 'Customer deleted!';
          }
          else {
            $resp['status'] = 'danger';
            $resp['message'] = 'The Customer could not be deleted!';
          }
          exit(json_encode($resp));
        }

        $Cus_FirstName = filter_var($data['Cus_FirstName'] ?? false, FILTER_SANITIZE_FULL_SPECIAL_CHARS, FILTER_FLAG_STRIP_HIGH);
        $Cus_LastName = filter_var($data['Cus_LastName'] ?? false, FILTER_SANITIZE_FULL_SPECIAL_CHARS, FILTER_FLAG_STRIP_HIGH);
        $Cus_Email = filter_var($data['Cus_Email'] ?? false, FILTER_SANITIZE_EMAIL, FILTER_FLAG_STRIP_HIGH);
        $Cus_Pass = filter_var($data['Cus_Pass'] ?? false, FILTER_SANITIZE_FULL_SPECIAL_CHARS, FILTER_FLAG_STRIP_HIGH);
        $Cus_Phone = filter_var($data['Cus_Phone'] ?? false, FILTER_SANITIZE_FULL_SPECIAL_CHARS, FILTER_FLAG_STRIP_HIGH);

        // TODO
        // Add check to control before with the old password.
        $Cus_Pass = password_hash($Cus_Pass, PASSWORD_DEFAULT);

        $exec_query = false;

        if ($form_action == 'update') {
          $query = 'UPDATE CUSTOMER SET Cus_FirstName = ?, Cus_LastName = ?, Cus_Email = ?, Cus_Pass = ?, Cus_Phone = ? WHERE Cus_Id = ?';
          $exec_query = executeQuery($query,
            [$Cus_FirstName, $Cus_LastName, $Cus_Email, $Cus_Pass, $Cus_Phone, $Cus_Id]);
        }
        else {
          if ($form_action == 'insert') {
            $query = 'IF NOT EXISTS (SELECT 1 FROM CUSTOMER WHERE Cus_Email = ?) INSERT INTO CUSTOMER VALUES (NEXT VALUE FOR SEQ_CUS_ID, ?, ?, ?, ?, ?, ?)';
            $exec_query = executeQuery($query,
              [ $Cus_Email, $Cus_FirstName, $Cus_LastName, $Cus_Email, $Cus_Pass, $Cus_Phone, date('Y-m-d H:i:s') ]);
          }
          else {
            $resp['status'] = 'danger';
            $resp['message'] = 'Action not permitted!';
            $resp['post'] = $data;
            exit(json_encode($resp));
          }
        }

        if ($exec_query) {
          $resp['message'] = "Customer $form_action ed successfully!";
          $resp['status'] = 'success';
        }
        else {
          $resp['status'] = 'danger';
          $resp['message'] = "Customer could not be $form_action ed!";
        }
        $resp['post'] = $data;
        exit(json_encode($resp));
      }
    }

  }
  http_response_code(405);
  exit(json_encode(['error' => 'Invalid request method']));