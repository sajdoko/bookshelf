<?php
// Include database connection
  require_once dirname(__FILE__, 3).'/includes/db_conn.php';

  /**
   * Perform the login operation.
   *
   * @param  string  $Emp_Email  The email of the user.
   * @param  string  $Emp_Pass  The password of the user.
   *
   * @return bool True if the login was successfully, false otherwise.
   */
  function login_employee(string $Emp_Email, string $Emp_Pass): bool
  {
    // Check if email and password are not empty
    if (empty($Emp_Email) || empty($Emp_Pass)) {
      return false;
    }

    $query = 'SELECT Emp_Id, Emp_Email, Emp_Pass FROM EMPLOYEE WHERE Emp_Email = ?';
    $user = retrieveOneRow($query, [$Emp_Email]);

    // Check if user exists in the database
    if ($user) {

      // Check if the password is correct
      if (password_verify($Emp_Pass, $user['Emp_Pass'])) {
        // Start a new session
        session_start();

        // Store the user_id and email in the session
        $_SESSION['Emp_Id'] = $user['Emp_Id'];
        $_SESSION['Emp_Email'] = $Emp_Email;
        $_SESSION['login_string'] = hash('sha512', $user['Emp_Pass'].$_SERVER['HTTP_USER_AGENT']);

        // Return true to indicate successful login
        return true;
      }
    }
    // Return false if login fails
    return false;
  }

  /**
   * Check of the employee is logged in by controlling the session.
   *
   * @return array|bool Returns array if employee is logged in, false if not.
   */
  function login_check_employee(): array|bool
  {
    // Check if all session variables are set
    if (isset($_SESSION['Emp_Id'], $_SESSION['Emp_Email'], $_SESSION['login_string'])) {
      $Emp_Id = $_SESSION['Emp_Id'];
      $login_string = $_SESSION['login_string'];

      // Get the user-agent string of the user
      $user_browser = $_SERVER['HTTP_USER_AGENT'];

      $query = 'SELECT * FROM EMPLOYEE WHERE EMPLOYEE.Emp_Id = ?';
      $user = retrieveOneRow($query, [$Emp_Id]);

      if ($user) {
        $login_check = hash('sha512', $user['Emp_Pass'].$user_browser);
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
   * Get either a Gravatar URL or complete image tag for a specified email address.
   *
   * @param  string  $email  The email address
   * @param  int|string  $s  Size in pixels, defaults to 80px [ 1 - 2048 ]
   * @param  string  $d  Default image set to use [ 404 | mp | identicon | monster id | wavatar ]
   * @param  string  $r  Maximum rating (inclusive) [ g | pg | r | x ]
   * @param  bool  $img  True to return a complete IMG tag False for just the URL
   * @param  array  $atts  Optional, additional key/value attributes to include in the IMG tag
   *
   * @return String containing either just a URL or a complete image tag
   * @source https://gravatar.com/site/implement/images/php/
   */
  function get_gravatar(string $email, int|string $s = 80, string $d = 'mp', string $r = 'g', bool $img = false, array $atts = []): string
  {
    $url = 'https://www.gravatar.com/avatar/';
    $url .= md5(strtolower(trim($email)));
    $url .= "?s=$s&d=$d&r=$r";
    if ($img) {
      $url = '<img src="'.$url.'"';
      foreach ($atts as $key => $val) {
        $url .= ' '.$key.'="'.$val.'"';
      }
      $url .= ' />';
    }
    return $url;
  }