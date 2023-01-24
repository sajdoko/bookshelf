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

  $genres = retrieveAllRows($query, [$book['Gen_Id'], $book['Boo_ISBN']]);
//  echo "<pre>";
//print_r($book);
//  echo '</pre>';
?>

    <div class="container mt-5">
        <div class="row">
            <div class="col-sm-12 col-md-9">
                <div class='row'>
                    <div class='col-sm-12 col-md-4'>
                        <div class='card shadow'>
                            <img src="<?php echo $book['Boo_Img_url']; ?>" class='bd-placeholder-img card-img-top'
                                 alt='<?php echo $book['Boo_Title']; ?>'>
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

                                <form action='../pages/cart' method='post' class="add-book-to-cart">
                                    <input type='hidden' name='Boo_ISBN' value="<?= $book['Boo_ISBN'] ?>">
                                    <div class='input-group mb-3'>
                                        <label>
                                            <input type='number' name='quantity' class='form-control' value='1' min='1' max="<?= $book['Boo_QOH'] ?>"
                                                   placeholder='0'
                                                   required>
                                        </label>
                                        <input type='submit' class='btn btn-success' value='Add To Cart'>
                                    </div>
                                </form>
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
            <div class='col-sm-12 col-md-3'>
                <div class='position-sticky' style='top: 2rem;'>
                    <div class='p-4 mb-3 bg-light rounded'>
                        <h5 class='fst-italic'>Other Books in this Genre</h5>
                      <?php if (count($genres) > 0) : ?>
                          <ol class='list-unstyled mb-0'>
                            <?php foreach ($genres as $genre) : ?>
                                <li><a href='/book/<?php echo create_url_string($genre['Boo_Title']); ?>'
                                       title="<?php echo $genre['Boo_Title']; ?>"><?php echo $genre['Boo_Title']; ?></a></li>
                            <?php endforeach; ?>
                          </ol>
                      <?php else : ?>
                          <p class='mb-0'>There are no other books in this genre</p>
                      <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

<?php require_once '../includes/footer.php'; ?>