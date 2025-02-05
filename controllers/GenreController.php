<?php

class GenreController {
    public function show($genre_url_string) {
        $genres = BookModel::getGenreByUrlString($genre_url_string);

        if (!$genres) {
            http_response_code(404);
            include_once dirname(__DIR__) . '/views/404.php';
            die(404);
        }
        // die(var_dump($genres));
        require_once dirname(__DIR__) . '/views/genre.php';
    }
}
