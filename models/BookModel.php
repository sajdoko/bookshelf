<?php
require_once dirname(__DIR__) . '/includes/functions.php';

class BookModel {
  public static function searchBooks($title, $author, $language, $publisher) {
    $query = 'SELECT *
            FROM BOOK
            JOIN BOOK_LANGUAGE BL on BL.BoL_Id = BOOK.BoL_Id
            JOIN PUBLISHER P on P.Pub_Id = BOOK.Pub_Id
            LEFT JOIN BOOK_AUTHOR BA on BOOK.Boo_ISBN = BA.Boo_ISBN
            LEFT JOIN AUTHOR A on A.Aut_Id = BA.Aut_Id
            LEFT JOIN BOOK_GENRE BG on BOOK.Boo_ISBN = BG.Boo_ISBN
            LEFT JOIN GENRE G on G.Gen_Id = BG.Gen_Id
            WHERE
                Boo_Title LIKE ? AND
                A.Aut_Name LIKE ? AND
                BL.BoL_Name LIKE ? AND
                P.Pub_Name LIKE ?;
        ';
    return retrieveAllRows($query, ["%$title%", "%$author%", "%$language%", "%$publisher%"]);
  }

  public static function getTopBooks($limit) {
    $query = "SELECT TOP ($limit) *
            FROM BOOK
            JOIN BOOK_LANGUAGE BL on BL.BoL_Id = BOOK.BoL_Id
            JOIN PUBLISHER P on P.Pub_Id = BOOK.Pub_Id
            LEFT JOIN BOOK_AUTHOR BA on BOOK.Boo_ISBN = BA.Boo_ISBN
            LEFT JOIN AUTHOR A on A.Aut_Id = BA.Aut_Id
            LEFT JOIN BOOK_GENRE BG on BOOK.Boo_ISBN = BG.Boo_ISBN
            LEFT JOIN GENRE G on G.Gen_Id = BG.Gen_Id;
        ";
    return retrieveAllRows($query);
  }

  public static function getBookByUrlString($book_url_string) {
    $query = "SELECT *
            FROM BOOK
            JOIN BOOK_LANGUAGE BL on BL.BoL_Id = BOOK.BoL_Id
            JOIN PUBLISHER P on P.Pub_Id = BOOK.Pub_Id
            LEFT JOIN BOOK_AUTHOR BA on BOOK.Boo_ISBN = BA.Boo_ISBN
            LEFT JOIN AUTHOR A on A.Aut_Id = BA.Aut_Id
            LEFT JOIN BOOK_GENRE BG on BOOK.Boo_ISBN = BG.Boo_ISBN
            LEFT JOIN GENRE G on G.Gen_Id = BG.Gen_Id
            WHERE
                LOWER(
                    REPLACE( REPLACE( REPLACE( Boo_Title, '''', '' ), ' ', '-' ), '.', '')
                ) = ?;
        ";
    return retrieveOneRow($query, [$book_url_string]);
  }

  public static function getGenreByUrlString($genre_url_string) {
    $query = "SELECT *
                FROM BOOK
                JOIN BOOK_LANGUAGE BL on BL.BoL_Id = BOOK.BoL_Id
                JOIN PUBLISHER P on P.Pub_Id = BOOK.Pub_Id
                LEFT JOIN BOOK_AUTHOR BA on BOOK.Boo_ISBN = BA.Boo_ISBN
                LEFT JOIN AUTHOR A on A.Aut_Id = BA.Aut_Id
                LEFT JOIN BOOK_GENRE BG on BOOK.Boo_ISBN = BG.Boo_ISBN
                LEFT JOIN GENRE G on G.Gen_Id = BG.Gen_Id
                WHERE
                    LOWER(
                        REPLACE( REPLACE( REPLACE( Gen_Name, '''', '' ), ' ', '-' ), '.', '')
                        ) = ?;
        ";
    return retrieveAllRows($query, [$genre_url_string]);
  }

  public static function getBooksByGenre($genre_id, $exclude_isbn) {
    $query = "SELECT *
            FROM BOOK
            JOIN BOOK_LANGUAGE BL on BL.BoL_Id = BOOK.BoL_Id
            JOIN PUBLISHER P on P.Pub_Id = BOOK.Pub_Id
            LEFT JOIN BOOK_AUTHOR BA on BOOK.Boo_ISBN = BA.Boo_ISBN
            LEFT JOIN AUTHOR A on A.Aut_Id = BA.Aut_Id
            LEFT JOIN BOOK_GENRE BG on BOOK.Boo_ISBN = BG.Boo_ISBN
            LEFT JOIN GENRE G on G.Gen_Id = BG.Gen_Id
            WHERE G.Gen_Id = ? AND
                  BOOK.Boo_ISBN != ?;
        ";
    return retrieveAllRows($query, [$genre_id, $exclude_isbn]);
  }

  public static function getTopGenresList(int $quantity = 5) {
    $query = "SELECT TOP $quantity COUNT(B.Boo_ISBN) AS NrBooks, GENRE.Gen_Name FROM GENRE
                    LEFT JOIN BOOK_GENRE BG on GENRE.Gen_Id = BG.Gen_Id
                    LEFT JOIN BOOK B on B.Boo_ISBN = BG.Boo_ISBN
                    GROUP BY GENRE.Gen_Name
                ORDER BY NrBooks
                DESC;
               ";
    return retrieveAllRows($query);
  }

  public static function getBestSellers(int $quantity = 3) {
    $query = "SELECT TOP $quantity *
          FROM BOOK
                  JOIN BOOK_LANGUAGE BL on BL.BoL_Id = BOOK.BoL_Id
                  JOIN PUBLISHER P on P.Pub_Id = BOOK.Pub_Id
                  LEFT JOIN BOOK_AUTHOR BA on BOOK.Boo_ISBN = BA.Boo_ISBN
                  LEFT JOIN AUTHOR A on A.Aut_Id = BA.Aut_Id
                  LEFT JOIN BOOK_GENRE BG on BOOK.Boo_ISBN = BG.Boo_ISBN
                  LEFT JOIN GENRE G on G.Gen_Id = BG.Gen_Id
          WHERE BOOK.Boo_ISBN IN (SELECT TOP $quantity BOOK.Boo_ISBN
                                  FROM BOOK
                                          INNER JOIN ORDER_LINE ON BOOK.Boo_ISBN = ORDER_LINE.Boo_ISBN
                                  GROUP BY BOOK.Boo_ISBN
                                  ORDER BY SUM(ORDER_LINE.OrL_Quantity) DESC)";

    return retrieveAllRows($query);
  }

  public static function getFeaturedBooks(int $quantity = 3) {
    $query = "SELECT TOP $quantity *
                FROM BOOK
                JOIN BOOK_LANGUAGE BL on BL.BoL_Id = BOOK.BoL_Id
                JOIN PUBLISHER P on P.Pub_Id = BOOK.Pub_Id
                LEFT JOIN BOOK_AUTHOR BA on BOOK.Boo_ISBN = BA.Boo_ISBN
                LEFT JOIN AUTHOR A on A.Aut_Id = BA.Aut_Id
                LEFT JOIN BOOK_GENRE BG on BOOK.Boo_ISBN = BG.Boo_ISBN
                LEFT JOIN GENRE G on G.Gen_Id = BG.Gen_Id
                WHERE Boo_Featured = 1;
            ";

    return retrieveAllRows($query);
  }

}
