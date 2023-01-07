<?php

include_once 'includes/db_conn.php';
include_once 'includes/functions.php';

session_start();

if (login_check($mysqli) == true) {
    header("Location: index.php");
    exit;
}

$error_msg = "";

if (isset($_POST['email'], $_POST['password'], $_POST['first_name'], $_POST['last_name'], $_POST['address'], $_POST['city'], $_POST['country'], $_POST['zipcode'])) {
    // Sanitize and validate the data passed in
    $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
    $email = filter_var($email, FILTER_VALIDATE_EMAIL);
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        // Not a valid email
        $error_msg .= '<p class="error">The email address you entered is not valid</p>';
    }
    
    $password = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_STRING);
    if (strlen($password) != 128) {
        // The hashed pwd should be 128 characters long.
        // If it's not, something really odd has happened
        $error_msg .= '<p class="error">Invalid password configuration.</p>';
    }
    
    $first_name = filter_input(INPUT_POST, 'first_name', FILTER_SANITIZE_STRING);
    $last_name = filter_input(INPUT_POST, 'last_name', FILTER_SANITIZE_STRING);
    $address = filter_input(INPUT_POST, 'address', FILTER_SANITIZE_STRING);
    $city = filter_input(INPUT_POST, 'city', FILTER_SANITIZE_STRING);
    $country = filter_input(INPUT_POST, 'country', FILTER_SANITIZE_STRING);
    $zipcode = filter_input(INPUT_POST, 'zipcode', FILTER_SANITIZE_STRING);
    
    // Check if email already exists
    if ($stmt = $mysqli->prepare("SELECT user_id FROM users WHERE email = ? LIMIT 1")) {
        $stmt->bind_param('s', $email);
        $stmt->execute();
        $stmt->store_result();
        
        if ($stmt->num_rows == 1) {
            // A user with this email address already exists
            $error_msg .= '<p class="error">A user with this email address already exists.</p>';
            $stmt->close();
        } else {
            // Email doesn't exist. Insert a new user into the database
            if ($stmt = $mysqli->prepare("INSERT INTO users (email, password, first_name, last_name, address, city, country, zipcode) VALUES (?, ?, ?, ?, ?, ?, ?, ?)")) {
              $stmt->bind_param('ssssssss', $email, $password, $first_name, $last_name, $address, $city, $country, $zipcode);
              // Execute the prepared query.
              if (! $stmt->execute()) {
                  header('Location: error.php?err=Registration failure: INSERT');
                  exit();
              }
              $stmt->close();
              header('Location: login.php');
              exit();
          }
        }
      }
    }