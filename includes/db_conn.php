<?php
function FormatErrors($errors): void {
  /* Display errors. */
  echo 'Error information: <br/>';

  foreach ($errors as $error) {
    echo 'SQLSTATE: ' . $error['SQLSTATE'] . '<br/>';
    echo 'Code: ' . $error['code'] . '<br/>';
    echo 'Message: ' . $error['message'] . '<br/>';
  }
}

$serverName        = '';
$connectionOptions = [
  'Database' => '',
  'Uid'      => '',
  'PWD'      => '',
];

$env = file(dirname(__FILE__, 2) . '/.env', FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
foreach ($env as $line) {
  $line = trim($line);
  if (str_starts_with($line, '#')) {
    continue;
  }
  $variable = explode('=', $line);
  if ($variable[0] == 'DB_HOST') {
    $serverName = $variable[1];
  } elseif ($variable[0] == 'DB_USER') {
    $connectionOptions['Uid'] = $variable[1];
  } elseif ($variable[0] == 'DB_PASSWORD') {
    $connectionOptions['PWD'] = $variable[1];
  } elseif ($variable[0] == 'DB_NAME') {
    $connectionOptions['Database'] = $variable[1];
  }
}

// Establishes the connection using PDO for SQL Server
try {
  $dsn  = "sqlsrv:server=$serverName;Database=" . $connectionOptions['Database'];
  $conn = new PDO($dsn, $connectionOptions['Uid'], $connectionOptions['PWD']);
  $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  // Set the connection as a global variable
  $GLOBALS['conn'] = $conn;

  session_start();
} catch (PDOException $e) {
  die(FormatErrors([['SQLSTATE' => $e->getCode(), 'code' => $e->getCode(), 'message' => $e->getMessage()]]));
}