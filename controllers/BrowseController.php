<?php

class BrowseController {
    public function index() {
        $errors = [];
        $books = [];

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $title = sanitizeInput($_POST["title"]);
            $author = sanitizeInput($_POST["author"] ?? '');
            $language = sanitizeInput($_POST["language"] ?? '');
            $publisher = sanitizeInput($_POST["publisher"] ?? '');

            if (empty($title) && empty($author) && empty($language) && empty($publisher)) {
                $errors[] = "At least one search field is required.";
            }

            if (count($errors) == 0) {
                $books = BookModel::searchBooks($title, $author, $language, $publisher);
            }
        } else {
            $books = BookModel::getTopBooks(100);
        }

        require_once dirname(__DIR__) . '/views/browse.php';
    }
}
