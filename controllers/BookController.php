<?php
require_once dirname(__DIR__) . '/models/BookModel.php';

class BookController {
    public function show($book_url_string) {
        $book = BookModel::getBookByUrlString($book_url_string);

        if (!$book) {
            http_response_code(404);
            include_once dirname(__DIR__) . '/views/404.php';
            die(404);
        }

        $genres = BookModel::getBooksByGenre($book['Gen_Id'], $book['Boo_ISBN']);
        require_once dirname(__DIR__) . '/views/book.php';
    }
}
