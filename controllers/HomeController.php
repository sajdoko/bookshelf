<?php
require_once dirname(__DIR__) . '/models/BookModel.php';

class HomeController {
  public function index() {
    $books           = BookModel::getTopBooks(100);
    $top_genres_list = BookModel::getTopGenresList(6);
    $best_sellers    = BookModel::getBestSellers(2);
    $featured_books  = BookModel::getFeaturedBooks(4);
    require_once dirname(__DIR__) . '/views/home.php';
  }
}