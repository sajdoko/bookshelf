<?php
  function FormatErrors($errors): void
  {
    /* Display errors. */
    echo 'Error information: <br/>';

    foreach ($errors as $error) {
      echo 'SQLSTATE: '.$error['SQLSTATE'].'<br/>';
      echo 'Code: '.$error['code'].'<br/>';
      echo 'Message: '.$error['message'].'<br/>';
    }
  }

  $serverName = 'SAJDOKO-PC-PUNA\SQLEXPRESS';
  $connectionOptions = [
    'Database' => 'bookshelf',
    'Uid' => 'bookshelf',
    'PWD' => '061191'
  ];

  //Establishes the connection
  $conn = sqlsrv_connect($serverName, $connectionOptions);
  if ($conn === false) {
    die(FormatErrors(sqlsrv_errors()));
  }