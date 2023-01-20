<?php
// Include database connection
  require_once 'db_conn.php';

  /**
   * Get all the rows from the database for the given query.
   *
   * @param  string  $query
   * @param  array  $params An array of params
   *
   * @return array
   */
  function retrieveAllRows(string $query, array $params = []): array
  {
    global $conn;
    $results = [];

    $stmt = sqlsrv_query($conn, $query, $params);

    if (!$stmt) {
      FormatErrors(sqlsrv_errors());
    } else {
      // Fetch all orders as an array
      while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
        $results[] = $row;
      }
    }

    sqlsrv_free_stmt($stmt);

    return $results;
  }

  /**
   * Get one row from the database for the given query.
   *
   * @param  string  $query
   * @param  array  $params An array of params
   *
   * @return array
   */
  function retrieveOneRow(string $query, array $params = []): array
  {
    global $conn;
    $row = [];

    $stmt = sqlsrv_query($conn, $query, $params);

    if (!$stmt) {
      FormatErrors(sqlsrv_errors());
    } else {
      // Fetch one orders as an array
      $row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC);
    }

    sqlsrv_free_stmt($stmt);

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
  function insertOrUpdateRows(string $query, array $params = []): bool
  {
    global $conn;

    $stmt = sqlsrv_prepare($conn, $query, $params);
    if (!$stmt) {
      FormatErrors(sqlsrv_errors());
    } else {
      if( !sqlsrv_execute( $stmt ) ) {
        FormatErrors(sqlsrv_errors());
      }
    }

    sqlsrv_free_stmt($stmt);

    return !$stmt??true;
  }


  /**
   * Get a list of the featured books.
   *
   * @return array An array of books.
   */
  function get_featured_books(): array
  {
    // Select featured books
    $query = "SELECT TOP (10) * FROM Books";

    return retrieveAllRows($query);
  }

  /**
   * Get a book by its ID.
   *
   * @param  int  $id  The ID of the book.
   *
   * @return array An array containing the book's data.
   */
  function get_book_by_id(int $id): array
  {
    // Select book by ID
    $query = "SELECT * FROM books WHERE book_id = ?";

    return retrieveOneRow($query, [$id]);
  }

  /**
   * Get a user by their ID.
   *
   * @param  int  $id  The ID of the user.
   *
   * @return array An array containing the user's data.
   */
  function get_user_by_id(int $id): array
  {
    // Select user by ID
    $query = "SELECT * FROM users WHERE user_id = ?";

    return retrieveOneRow($query, [$id]);
  }

  /**
   * Get a user's orders by their ID.
   *
   * @param  int  $id  The ID of the user.
   *
   * @return array An array of orders.
   */
  function get_orders_by_user_id(int $id): array
  {
    // Select orders by user ID
    $query = "SELECT * FROM orders WHERE user_id = ?";

    return retrieveAllRows($query, [$id]);
  }

  /**
   * Add a new order to the database.
   *
   * @param  int  $user_id  The ID of the user.
   * @param  int  $book_id  The ID of the book.
   * @param  int  $quantity  The quantity of books being ordered.
   * @param  float  $total_price  The total price of the order.
   *
   * @return false|resource resource if the order was successfully added, false otherwise.
   */
  function add_order(int $user_id, int $book_id, int $quantity, float $total_price)
  {
    global $conn;

    // Insert order into database
    $query = "INSERT INTO orders (user_id, book_id, quantity, total_price) VALUES (?, ?, ?, ?)";
    $params = [$user_id, $book_id, $quantity, $total_price];
    return sqlsrv_query($conn, $query, $params);
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
   * Check of the user is logged in by controlling the session.
   *
   * @return bool
   */
  function login_check(): bool
  {
    // Check if all session variables are set
    if (isset($_SESSION['user_id'], $_SESSION['email'], $_SESSION['login_string'])) {
      $user_id = $_SESSION['user_id'];
      $login_string = $_SESSION['login_string'];
      $email = $_SESSION['email'];

      // Get the user-agent string of the user
      $user_browser = $_SERVER['HTTP_USER_AGENT'];

      $query = 'SELECT * FROM Users WHERE UserID = ?';
      $user = retrieveOneRow($query, [$user_id]);

      if ($user) {
        $login_check = hash('sha512', $user['Password'].$user_browser);
        if ($login_check == $login_string) {
          // Logged In!!!!
          return true;
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
   * @param  string  $email  The email of the user.
   * @param  string  $password  The password of the user.
   *
   * @return bool True if the login was successfully, false otherwise.
   */
  function login(string $email, string $password): bool
  {
    // Check if email and password are not empty
    if (empty($email) || empty($password)) {
      return false;
    }

    $query = 'SELECT TOP 1 * FROM Users WHERE Email = ?';
    $user = retrieveOneRow($query, [$email]);

    // Check if user exists in the database
    if ($user) {

      // Check if the password is correct
      if (password_verify($password, $user['Password'])) {
        // Start a new session
        session_start();

        // Store the user_id and email in the session
        $_SESSION['user_id'] = $user['UserID'];
        $_SESSION['email'] = $email;
        $_SESSION['login_string'] = hash('sha512', $user['Password'].$_SERVER['HTTP_USER_AGENT']);

        // Return true to indicate successful login
        return true;
      }
    }
    // Return false if login fails
    return false;
  }

  /**
   * Get a user's info from the database
   *
   * @param $user_id
   *
   * @return array
   */
  function get_user_info($user_id): array
  {
    $query = 'SELECT * FROM Users WHERE UserID = ?';
    return retrieveOneRow($query, [$user_id]);
  }

  /**
   * Check if an email is already in use
   *
   * @param $email
   *
   * @return bool
   */
  function email_exists($email): bool
  {
    $query = 'SELECT * FROM Users WHERE Email = ?';
    $user = retrieveOneRow($query, [$email]);

    if ($user) {
      return true;
    }
    return false;
  }

  /**
   * Update a user's info in the database
   *
   * @param $user_id
   * @param $first_name
   * @param $last_name
   *
   * @return bool
   */
  function update_user_info($user_id, $first_name, $last_name): bool
  {
    $query = "UPDATE users SET FirstName = ?, LastName = ? WHERE UserID = ?";
    return insertOrUpdateRows($query, [$user_id, $first_name, $last_name]);
  }

  function insertInvoice($orderID, $customerID, $invoiceDate, $totalAmount, $paid)
  {
    global $conn;
    $query = 'INSERT INTO Invoices (OrderID, CustomerID, InvoiceDate, TotalAmount, Paid)
              VALUES (?, ?, ?, ?, ?)';
    $stmt = sqlsrv_query($conn, $query, [$orderID, $customerID, $invoiceDate, $totalAmount, $paid]);
    if ($stmt === false) {
      die(print_r(sqlsrv_errors(), true));
    }
    return $stmt;
  }

  /**
   * @param $invoiceID
   * @param $orderID
   * @param $customerID
   * @param $invoiceDate
   * @param $totalAmount
   * @param $paid
   *
   * @return bool
   */
  function updateInvoice($invoiceID, $orderID, $customerID, $invoiceDate, $totalAmount, $paid): bool
  {
    global $conn;
    $query = 'UPDATE Invoices SET OrderID = ?, CustomerID = ?, InvoiceDate = ?, TotalAmount = ?, Paid = ?
              WHERE InvoiceID = ?';

    return insertOrUpdateRows($query, [$orderID, $customerID, $invoiceDate, $totalAmount, $paid, $invoiceID]);
  }