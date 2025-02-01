<?php
// Include database connection
  require_once 'db_conn.php';

  /**
   * Get all the rows from the database for the given query.
   *
   * @param  string  $query
   * @param  array  $params  An array of params
   *
   * @return array
   */
  function retrieveAllRows(string $query, array $params = []): array
  {
    global $conn;
    $results = [];

    try {
      $stmt = $conn->prepare($query);
      $stmt->execute($params);
      $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
      FormatErrors([['SQLSTATE' => $e->getCode(), 'code' => $e->getCode(), 'message' => $e->getMessage()]]);
    }

    return $results;
  }

  /**
   * Get one row from the database for the given query.
   *
   * @param  string  $query
   * @param  array  $params  An array of params
   *
   * @return array
   */
  function retrieveOneRow(string $query, array $params = []): array
  {
    global $conn;
    $row = [];

    try {
      $stmt = $conn->prepare($query);
      $stmt->execute($params);
      $row = $stmt->fetch(PDO::FETCH_ASSOC) ?: [];
    } catch (PDOException $e) {
      FormatErrors([['SQLSTATE' => $e->getCode(), 'code' => $e->getCode(), 'message' => $e->getMessage()]]);
    }

    return $row;
  }

  /**
   * Insert or Update rows on the database for the given query.
   *
   * @param  string  $query
   * @param  array  $params  An array of params
   *
   * @return bool
   */
  function executeQuery(string $query, array $params = []): bool
  {
    global $conn;

    try {
      $stmt = $conn->prepare($query);
      return $stmt->execute($params);
    } catch (PDOException $e) {
      FormatErrors([['SQLSTATE' => $e->getCode(), 'code' => $e->getCode(), 'message' => $e->getMessage()]]);
      return false;
    }
  }

  /**
   * Insert one row on the database for the given query and return inserted row if successful.
   *
   * @param  string  $query
   * @param  array  $params  An array of params
   *
   * @return bool|array
   */
  function insertQuery(string $query, array $params = []): bool|array
  {
    global $conn;

    try {
      $stmt = $conn->prepare($query);
      if ($stmt->execute($params)) {
        return $stmt->fetch(PDO::FETCH_ASSOC) ?: [];
      }
    } catch (PDOException $e) {
      FormatErrors([['SQLSTATE' => $e->getCode(), 'code' => $e->getCode(), 'message' => $e->getMessage()]]);
    }

    return false;
  }


  /**
   * Get a list of the featured books.
   *
   * @param  int  $quantity
   *
   * @return array An array of books.
   */
  function get_featured_books(int $quantity = 3): array
  {
    // Select featured books
    $query = "
              SELECT TOP $quantity *
                FROM BOOK
                JOIN BOOK_LANGUAGE BL on BL.BoL_Id = BOOK.BoL_Id
                JOIN PUBLISHER P on P.Pub_Id = BOOK.Pub_Id
                LEFT JOIN BOOK_AUTHOR BA on BOOK.Boo_ISBN = BA.Boo_ISBN
                LEFT JOIN AUTHOR A on A.Aut_Id = BA.Aut_Id
                LEFT JOIN BOOK_GENRE BG on BOOK.Boo_ISBN = BG.Boo_ISBN
                LEFT JOIN GENRE G on G.Gen_Id = BG.Gen_Id
                WHERE Boo_Featured = 1;
            ";

    return retrieveAllRows($query);
  }


  /**
   * Get a list of the most sold books.
   *
   * @param  int  $quantity
   *
   * @return array An array of books.
   */
  function get_best_sellers(int $quantity = 3): array
  {
    // Select most sold books
    $query = "SELECT TOP $quantity *
FROM BOOK
         JOIN BOOK_LANGUAGE BL on BL.BoL_Id = BOOK.BoL_Id
         JOIN PUBLISHER P on P.Pub_Id = BOOK.Pub_Id
         LEFT JOIN BOOK_AUTHOR BA on BOOK.Boo_ISBN = BA.Boo_ISBN
         LEFT JOIN AUTHOR A on A.Aut_Id = BA.Aut_Id
         LEFT JOIN BOOK_GENRE BG on BOOK.Boo_ISBN = BG.Boo_ISBN
         LEFT JOIN GENRE G on G.Gen_Id = BG.Gen_Id
WHERE BOOK.Boo_ISBN IN (SELECT TOP $quantity BOOK.Boo_ISBN
                        FROM BOOK
                                 INNER JOIN ORDER_LINE ON BOOK.Boo_ISBN = ORDER_LINE.Boo_ISBN
                        GROUP BY BOOK.Boo_ISBN
                        ORDER BY SUM(ORDER_LINE.OrL_Quantity) DESC)";

    return retrieveAllRows($query);
  }

  /**
   * Get a list of top genre names.
   *
   * @param  int  $quantity
   *
   * @return array An array of genre names and books counts.
   */
  function get_top_genres_list(int $quantity = 5): array
  {
    // Select featured books
    $query = "
              SELECT TOP $quantity COUNT(B.Boo_ISBN) AS NrBooks, GENRE.Gen_Name FROM GENRE
                  LEFT JOIN BOOK_GENRE BG on GENRE.Gen_Id = BG.Gen_Id
                  LEFT JOIN BOOK B on B.Boo_ISBN = BG.Boo_ISBN
                  GROUP BY GENRE.Gen_Name
              ORDER BY NrBooks
              DESC;
             ";

    return retrieveAllRows($query);
  }

  /**
   * Get a books by its isbn.
   *
   * @param  string  $isbn  The isbn of the books.
   *
   * @return array An array containing the books's data.
   */
  function get_book_by_isbn(string $isbn): array
  {
    // Select books by isbn
    $query = "SELECT * FROM BOOK WHERE Boo_ISBN = ?";

    return retrieveOneRow($query, [$isbn]);
  }

  function sec_session_start(): void
  {
    $session_name = 'sec_session_id';

    if (ini_set('session.use_only_cookies', 1) === false) {
      header("Location: error.php?err=Could not initiate a safe session (ini_set)");
      exit();
    }

    $cookieParams = session_get_cookie_params();
    session_set_cookie_params($cookieParams["lifetime"], $cookieParams["path"], $cookieParams["domain"], false, true);
    session_name($session_name);
    session_start();
    session_regenerate_id(true);
  }

  /**
   * Check of the customer is logged in by controlling the session.
   *
   * @return array|bool Returns array if customer is logged in, false if not.
   */
  function login_check_customer(): array|bool
  {
    // Check if all session variables are set
    if (isset($_SESSION['Cus_Id'], $_SESSION['Cus_Email'], $_SESSION['login_string'])) {
      $Cus_Id = $_SESSION['Cus_Id'];
      $login_string = $_SESSION['login_string'];

      // Get the user-agent string of the user
      $user_browser = $_SERVER['HTTP_USER_AGENT'];

      $query = 'SELECT * FROM CUSTOMER 
                  LEFT JOIN ADDRESS ON CUSTOMER.Cus_Id = ADDRESS.Cus_Id 
                  LEFT JOIN COUNTRY on COUNTRY.Cou_Alpha2Code = ADDRESS.Cou_Alpha2Code 
                    WHERE CUSTOMER.Cus_Id = ?';
      $user = retrieveOneRow($query, [$Cus_Id]);

      if ($user) {
        $login_check = hash('sha512', $user['Cus_Pass'].$user_browser);
        if ($login_check == $login_string) {
          // Logged In!!!!
          return $user;
        }
        else {
          // Not logged in
          return false;
        }
      }
      else {
        // Not logged in
        return false;
      }
    }
    else {
      // Not logged in
      return false;
    }
  }

  /**
   * Perform the login operation.
   *
   * @param  string  $Cus_Email  The email of the user.
   * @param  string  $Cus_Pass  The password of the user.
   *
   * @return bool True if the login was successfully, false otherwise.
   */
  function login_customer(string $Cus_Email, string $Cus_Pass): bool
  {
    // Check if email and password are not empty
    if (empty($Cus_Email) || empty($Cus_Pass)) {
      return false;
    }

    $query = 'SELECT Cus_Id, Cus_Email, Cus_Pass FROM CUSTOMER WHERE Cus_Email = ?';
    $user = retrieveOneRow($query, [$Cus_Email]);

    // Check if user exists in the database
    if ($user) {

      // Check if the password is correct
      if (password_verify($Cus_Pass, $user['Cus_Pass'])) {
        // Start a new session
        session_start();

        // Store the user_id and email in the session
        $_SESSION['Cus_Id'] = $user['Cus_Id'];
        $_SESSION['Cus_Email'] = $Cus_Email;
        $_SESSION['login_string'] = hash('sha512', $user['Cus_Pass'].$_SERVER['HTTP_USER_AGENT']);

        // Return true to indicate successful login
        return true;
      }
    }
    // Return false if login fails
    return false;
  }

  /**
   * Get a customer's info from the database
   *
   * @param $user_id
   *
   * @return array
   */
  function get_customer_info($user_id): array
  {
    $query = 'SELECT * FROM CUSTOMER LEFT JOIN ADDRESS ON CUSTOMER.Cus_Id = ADDRESS.Cus_Id LEFT JOIN COUNTRY on COUNTRY.Cou_Alpha2Code = ADDRESS.Cou_Alpha2Code 
         WHERE CUSTOMER.Cus_Id = ?';
    return retrieveOneRow($query, [$user_id]);
  }

  /**
   * Update a user's info in the database
   *
   * @param $user_id
   * @param $first_name
   * @param $last_name
   * @param $phone
   * @param $street
   * @param $zip
   * @param $city
   * @param $country_id
   *
   * @return bool
   */
  function update_customer_info($user_id, $first_name, $last_name, $phone, $street, $zip, $city, $country_id): bool
  {
    $query = "UPDATE CUSTOMER SET Cus_FirstName = ?, Cus_LastName = ?, Cus_Phone = ? WHERE Cus_Id = ?";
    executeQuery($query, [$first_name, $last_name, $phone, $user_id]);

    $query2 = 'UPDATE ADDRESS SET Add_Street_Name = ?, Add_Zip = ?, Add_City = ?, Cou_Alpha2Code = ? WHERE Cus_Id = ?';
    return executeQuery($query2, [$street, $zip, $city, $country_id, $user_id]);
  }

  /**
   * This function returns an alphanumeric string separated by - that can be used as a URL .
   *
   * @param $title
   *
   * @return string
   */
  function create_url_string($title): string
  {
    $string = preg_replace('/[^a-zA-Z0-9-&\s]/', '', $title); // remove all non-alphanumeric characters
    $string = preg_replace('/\s/', '-', $string); // replace spaces with dashes
    // convert to lowercase
    return strtolower($string);
  }

  /**
   * This function returns an alphanumeric string separated by _ that can be used as a html class or id.
   *
   * @param $string
   *
   * @return string
   */
  function create_html_id($string): string
  {
    $string = preg_replace('/[^a-zA-Z0-9\s]/', '', $string); // remove all non-alphanumeric characters
    $string = preg_replace('/\s/', '_', $string); // replace spaces with dashes
    // convert to lowercase
    return strtolower($string);
  }

  /**
   * Get the order lines of the order.
   *
   * @param $Ord_Id
   *
   * @return array
   */
  function get_order_lines($Ord_Id): array
  {
    $query = 'SELECT ORDER_LINE.*, B.Boo_Title FROM ORDER_LINE
         INNER JOIN BOOK B on B.Boo_ISBN = ORDER_LINE.Boo_ISBN
         WHERE ORDER_LINE.Ord_Id = ?';

    return retrieveAllRows($query, [$Ord_Id]);
  }

  /**
   * Get the books price.
   *
   * @param $Boo_ISBN
   *
   * @return float
   */
  function get_book_price($Boo_ISBN): float
  {
    $book = get_book_by_isbn($Boo_ISBN);
    if (!$book) {
      return 0;
    }

    return $book['Boo_Price'];
  }