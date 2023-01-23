<?php
  $page_title = "Book";
  require_once '../includes/header.php';

  $url = $_SERVER['REQUEST_URI'];
  $url_parts = explode('/', $url);
  $book_url_string = end($url_parts);
//  echo $book_url_string;
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

  $book = retrieveOneRow($query, [$book_url_string]);
  if (!$book) {
    http_response_code(404);
    include_once '404.php';
    die(404);
  }
//  echo "<pre>";
//print_r($book);
//  echo '</pre>';
?>

    <div class="container mt-5">
        <div class="row">
            <div class='col-sm-12 col-md-4'>
                <div class='card shadow'>
                    <img src="<?php echo $book['Boo_Img_url']; ?>" class='bd-placeholder-img card-img-top' alt='<?php echo $book['Boo_Title']; ?>'>
                    <div class='card-body'>
                        <p class='card-text'>ISBN: <?php echo $book['Boo_ISBN']; ?></p>
                    </div>
                </div>
            </div>
            <div class='col-sm-12 col-md-8'>
                <div class='card shadow'>
                    <div class='card-body'>
                        <h5 class='card-title' style='min-height: 50px;'>Title: <?php echo $book['Boo_Title']; ?></h5>
                        <p class="m-0">Author: <?php echo $book['Aut_Name']; ?></p>
                        <p class="m-0">Language: <?php echo $book['BoL_Name']; ?></p>
                        <p class='p-0'>Genre: <?php echo $book['Gen_Name']; ?></p>
                        <p class="card-text">Description: <?php echo $book['Boo_Description']; ?></p>
                        <p class='card-text'><small class='text-muted'>Published: <?php echo $book['Boo_Pub_Date']->format('Y-m-d'); ?>
                                by <?php echo $book['Pub_Name']; ?></small></p>
                        <p class="card-text">Price: <?php echo $book['Boo_Price']; ?></p>
                        <a href="#" class="btn btn-primary">Add to Cart</a>
                    </div>
                </div>
                <div class='card shadow mt-4'>
                    <div class='card-body'>
                        <p class="card-text">About <?php echo $book['Aut_Name']; ?></p>
                        <p class="card-text"><?php echo $book['Aut_Bio']; ?></p>
                    </div>
                </div>
            </div>
        </div>
    </div>

<?php require_once '../includes/footer.php'; ?>