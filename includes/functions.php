<?php
// Include database connection
require_once 'db_conn.php';

/**
 * Get a list of the featured books.
 *
 * @return array An array of books.
 */
function get_featured_books() {
  global $mysqli;

  // Select featured books
  $query = "SELECT * FROM books WHERE featured = 1";
  $result = mysqli_query($mysqli, $query);

  // Fetch all books as an array
  $books = mysqli_fetch_all($result, MYSQLI_ASSOC);

  return $books;
}

/**
 * Get a book by its ID.
 *
 * @param int $id The ID of the book.
 * @return array An array containing the book's data.
 */
function get_book_by_id($id) {
  global $mysqli;

  // Select book by ID
  $query = "SELECT * FROM books WHERE book_id = $id";
  $result = mysqli_query($mysqli, $query);

  // Fetch book as an array
  $book = mysqli_fetch_array($result, MYSQLI_ASSOC);

  return $book;
}

/**
 * Get a user by their ID.
 *
 * @param int $id The ID of the user.
 * @return array An array containing the user's data.
 */
function get_user_by_id($id) {
  global $mysqli;

  // Select user by ID
  $query = "SELECT * FROM users WHERE user_id = $id";
  $result = mysqli_query($mysqli, $query);

  // Fetch user as an array
  $user = mysqli_fetch_array($result, MYSQLI_ASSOC);

  return $user;
}

/**
 * Get a user's orders by their ID.
 *
 * @param int $id The ID of the user.
 * @return array An array of orders.
 */
function get_orders_by_user_id($id) {
  global $mysqli;

  // Select orders by user ID
  $query = "SELECT * FROM orders WHERE user_id = $id";
  $result = mysqli_query($mysqli, $query);

  // Fetch all orders as an array
  $orders = mysqli_fetch_all($result, MYSQLI_ASSOC);

  return $orders;
}

/**
 * Add a new order to the database.
 *
 * @param int $user_id The ID of the user.
 * @param int $book_id The ID of the book.
 * @param int $quantity The quantity of books being ordered.
 * @param float $total_price The total price of the order.
 * @return bool True if the order was successfully added, false otherwise.
 */
function add_order($user_id, $book_id, $quantity, $total_price) {
  global $mysqli;

  // Insert order into database
  $query = "INSERT INTO orders (user_id, book_id, quantity, total_price) VALUES ($user_id, $book_id, $quantity, $total_price)";
  $result = mysqli_query($mysqli, $query);

  return $result;
}

function login_check() {
  global $mysqli;
  // Check if all session variables are set
  if (isset($_SESSION['user_id'], $_SESSION['username'], $_SESSION['login_string'])) {
    $user_id = $_SESSION['user_id'];
    $login_string = $_SESSION['login_string'];
    $username = $_SESSION['username'];

    // Get the user-agent string of the user
    $user_browser = $_SERVER['HTTP_USER_AGENT'];

    if ($stmt = $mysqli->prepare("SELECT password FROM users WHERE user_id = ? LIMIT 1")) {
      // Bind "$user_id" to parameter.
      $stmt->bind_param('i', $user_id);
      $stmt->execute();
      $stmt->store_result();

      if ($stmt->num_rows == 1) {
        // If the user exists get variables from result.
        $stmt->bind_result($password);
        $stmt->fetch();
        $login_check = hash('sha512', $password . $user_browser);

        if ($login_check == $login_string) {
          // Logged In!!!!
          return true;
        } else {
          // Not logged in
          return false;
        }
      } else {
        // Not logged in
        return false;
      }
    } else {
      // Not logged in
      return false;
    }
  } else {
    // Not logged in
    return false;
  }
}

function sec_session_start() {
  $session_name = 'sec_session_id';
  $secure = false;
  $httponly = true;

  if (ini_set('session.use_only_cookies', 1) === false) {
    header("Location: error.php?err=Could not initiate a safe session (ini_set)");
    exit();
  }

  $cookieParams = session_get_cookie_params();
  session_set_cookie_params($cookieParams["lifetime"], $cookieParams["path"], $cookieParams["domain"], $secure, $httponly);
  session_name($session_name);
  session_start();
  session_regenerate_id(true);
}

function login($email, $password) {
  global $mysqli;
  if ($stmt = $mysqli->prepare("SELECT user_id, password FROM users WHERE email = ? LIMIT 1")) {
    $stmt->bind_param('s', $email);
    $stmt->execute();
    $stmt->store_result();

    $stmt->bind_result($user_id, $db_password);
    $stmt->fetch();

    if ($stmt->num_rows == 1) {
      if (password_verify($password, $db_password)) {
        $user_browser = $_SERVER['HTTP_USER_AGENT'];
        $user_id = preg_replace("/[^0-9]+/", "", $user_id);
        $_SESSION['user_id'] = $user_id;
        $username = preg_replace("/[^a-zA-Z0-9_\-]+/", "", $email);
        $_SESSION['username'] = $username;
        $_SESSION['login_string'] = hash('sha512', $db_password . $user_browser);

        return true;
      } else {
        return false;
      }
    } else {
      return false;
    }
  } else {
    return false;
  }
}
