<?php
  // Database connection constants
  define('DB_HOST', 'localhost');
  define('DB_USER', 'root');
  define('DB_PASSWORD', '');
  define('DB_NAME', 'bookshelf');

  // Connect to database
  $conn = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);

  // Check connection
  if (!$conn) {
    die('Connection failed: ' . mysqli_connect_error());
  }
?>