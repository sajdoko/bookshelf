<?php
require_once dirname(__DIR__) . '/autoload.php';
require_once dirname(__DIR__) . '/controllers/GenreController.php';

$url = $_SERVER['REQUEST_URI'];
$url_parts = explode('/', $url);
$genre_url_string = end($url_parts);
// die(var_dump($genre_url_string));

$controller = new GenreController();
$controller->show($genre_url_string);
?>