<?php
require_once dirname(__DIR__) . '/autoload.php';
require_once dirname(__DIR__) . '/controllers/BookController.php';

$url = $_SERVER['REQUEST_URI'];
$url_parts = explode('/', $url);
$book_url_string = end($url_parts);

$controller = new BookController();
$controller->show($book_url_string);
?>