<?php
  // Database connection constants
  define('DB_HOST', 'localhost');
  define('DB_USER', 'root');
  define('DB_PASSWORD', '');
  define('DB_NAME', 'bookshelf');

  // Connect to database
  $mysqli = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);

  // Check connection
  if (!$mysqli) {
    die('Connection failed: ' . mysqli_connect_error());
  }
?>