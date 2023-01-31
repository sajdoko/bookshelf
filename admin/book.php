<?php
  $page_title = "Book";
  require_once 'includes/header.php';

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
    include_once dirname(__FILE__, 2).'/pages/404.php';
    die(404);
  }

  $genres = retrieveAllRows('SELECT * FROM GENRE');
  $authors = retrieveAllRows('SELECT * FROM AUTHOR');
  $publishers = retrieveAllRows('SELECT * FROM PUBLISHER');
  $book_languages = retrieveAllRows('SELECT * FROM BOOK_LANGUAGE');
//  echo "<pre>";
//print_r($book);
//  echo '</pre>';
?>
    <div class='row'>
        <div class='col'>
            <h1 class='display-5 m-3'><?= 'Editing - '.$book['Boo_Title']; ?></h1>
            <hr>
        </div>
    </div>

    <div class="row pb-4">
        <div class="col-6">
            <form id="editBookForm" action="<?= htmlspecialchars($_SERVER['PHP_SELF']); ?>" method='post' class='row g-3'>
                <div class='col-md-6'>
                    <label for='Boo_Title' class='form-label'>Book Title</label>
                    <input type='text' name="Boo_Title" class='form-control' id='Boo_Title' value="<?= $book['Boo_Title']; ?>" required>
                </div>
                <div class='col-md-4'>
                    <label for='Aut_Id' class='form-label'>Author</label>
                    <select name="Aut_Id" id='Aut_Id' class='form-select' required>
                      <?php foreach ($authors as $author) : ?>
                          <option value="<?= $author['Aut_Id']; ?>" <?= ($author['Aut_Id'] == $book['Aut_Id']) ? 'selected' : ''; ?>><?= $author['Aut_Name']; ?></option>
                      <?php endforeach; ?>
                    </select>
                </div>
                <div class='col-md-2'>
                    <label for='Boo_Price' class='form-label'>Book Price</label>
                    <div class='input-group'>
                        <span class='input-group-text'>&euro;</span>
                        <input type='number' name="Boo_Price" class='form-control' id='Boo_Price' value="<?= $book['Boo_Price']; ?>" required>
                    </div>
                </div>
                <div class='col-12'>
                    <label for='Boo_Description' class='form-label'>Book Description</label>
                    <textarea name="Boo_Description" id="Boo_Description" class='form-control' rows="3" required><?= $book['Boo_Description']; ?></textarea>
                </div>
                <div class='col-md-4'>
                    <label for='Pub_Id' class='form-label'>Publisher</label>
                    <select name='Pub_Id' id='Pub_Id' class='form-select' required>
                      <?php foreach ($publishers as $publisher) : ?>
                          <option value="<?= $publisher['Pub_Id']; ?>" <?= ($publisher['Pub_Id'] == $book['Pub_Id']) ? 'selected' : ''; ?>><?= $publisher['Pub_Name']; ?></option>
                      <?php endforeach; ?>
                    </select>
                </div>
                <div class='col-md-3'>
                    <label for='Boo_Pub_Date' class='form-label'>Publishing Date</label>
                    <input type='date' name="Boo_Pub_Date" class='form-control' id='Boo_Pub_Date' value="<?= $book['Boo_Pub_Date']->format('Y-m-d'); ?>" required>
                </div>
                <div class='col-md-3'>
                    <label for='BoL_Id' class='form-label'>Language</label>
                    <select name='BoL_Id' id='BoL_Id' class='form-select' required>
                      <?php foreach ($book_languages as $book_language) : ?>
                          <option value="<?= $book_language['BoL_Id']; ?>" <?= ($book_language['BoL_Id'] == $book['BoL_Id']) ? 'selected' : ''; ?>><?= $book_language['BoL_Name']; ?></option>
                      <?php endforeach; ?>
                    </select>
                </div>
                <div class='col-md-2'>
                    <label for='Boo_QOH' class='form-label'>Book QOH</label>
                    <input type='number' name='Boo_QOH' class='form-control' id='Boo_QOH' value="<?= $book['Boo_QOH']; ?>" required>
                </div>
                <div class='col-md-10'>
                    <label for='Boo_Img_url' class='form-label'>Book Image Url</label>
                    <input type='url' name='Boo_Img_url' class='form-control' id='Boo_Img_url' value="<?= $book['Boo_Img_url']; ?>" required>
                </div>
                <div class='col-md-2'>
                    <div class='form-check mt-4 pt-3'>
                        <input name="Boo_Featured" class='form-check-input' type='checkbox' id='Boo_Featured' <?= $book['Boo_Featured'] ? 'checked' : ''; ?> required>
                        <label class='form-check-label' for='Boo_Featured'>Is Featured?</label>
                    </div>
                </div>
                <div class='col-12 mt-5'>
                    <input type="hidden" name="edit_book">
                    <button type='submit' class='btn btn-primary w-50'>Update Book</button>
                </div>
            </form>
        </div>
        <div class="col-6">
            <div class='text-center'>
                <img id="BookImgUrl" src='<?= $book['Boo_Img_url']; ?>' class='rounded' alt='<?= $book['Boo_Title']; ?>'>
            </div>
        </div>
    </div>

    <script>
        document.querySelector("input[name='Boo_Img_url']").addEventListener('change', function () {
            document.querySelector('#BookImgUrl').src = this.value;
        });
    </script>

<?php require_once 'includes/footer.php'; ?>