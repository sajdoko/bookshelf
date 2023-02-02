<?php
  $page_title = "Add Book";
  require_once dirname(__FILE__, 2).'/includes/header.php';

  $genres = retrieveAllRows('SELECT * FROM GENRE');
  $authors = retrieveAllRows('SELECT * FROM AUTHOR');
  $publishers = retrieveAllRows('SELECT * FROM PUBLISHER');
  $book_languages = retrieveAllRows('SELECT * FROM BOOK_LANGUAGE');
//  echo "<pre>";
//print_r($books);
//  echo '</pre>';
?>
    <div class='row'>
        <div class='col'>
            <h1 class='display-5 m-3'>Add a Book</h1>
            <hr>
        </div>
    </div>

    <div class="row pb-4">
        <div class="col-6">
            <form class='row g-3 recordForm'>
                <div class='col-12'>
                    <label for='Boo_Title' class='form-label'>Book Title</label>
                    <input type='text' name='Boo_Title' class='form-control' id='Boo_Title' required>
                </div>
                <div class='col-md-6'>
                    <label for='Boo_ISBN' class='form-label'>Book ISBN</label>
                    <input type='text' name='Boo_ISBN' class='form-control' id='Boo_ISBN' required>
                </div>
                <div class='col-md-4'>
                    <label for='Aut_Id' class='form-label'>Author</label>
                    <select name="Aut_Id" id='Aut_Id' class='form-select' required>
                        <option value=''>Choose...</option>
                      <?php foreach ($authors as $author) : ?>
                          <option value="<?= $author['Aut_Id']; ?>"><?= $author['Aut_Name']; ?></option>
                      <?php endforeach; ?>
                    </select>
                </div>
                <div class='col-md-2'>
                    <label for='Boo_Price' class='form-label'>Book Price</label>
                    <div class='input-group'>
                        <span class='input-group-text'>&euro;</span>
                        <input type="text" pattern="[0-9]+([.][0-9]+)?" name="Boo_Price" class='form-control' id='Boo_Price' required>
                    </div>
                </div>
                <div class='col-12'>
                    <label for='Boo_Description' class='form-label'>Book Description</label>
                    <textarea name="Boo_Description" id="Boo_Description" class='form-control' rows="3" required></textarea>
                </div>
                <div class='col-md-4'>
                    <label for='Pub_Id' class='form-label'>Publisher</label>
                    <select name='Pub_Id' id='Pub_Id' class='form-select' required>
                        <option value=''>Choose...</option>
                      <?php foreach ($publishers as $publisher) : ?>
                          <option value="<?= $publisher['Pub_Id']; ?>"><?= $publisher['Pub_Name']; ?></option>
                      <?php endforeach; ?>
                    </select>
                </div>
                <div class='col-md-3'>
                    <label for='Boo_Pub_Date' class='form-label'>Publishing Date</label>
                    <input type='date' name="Boo_Pub_Date" class='form-control' id='Boo_Pub_Date' value="" required>
                </div>
                <div class='col-md-3'>
                    <label for='BoL_Id' class='form-label'>Language</label>
                    <select name='BoL_Id' id='BoL_Id' class='form-select' required>
                        <option value=''>Choose...</option>
                      <?php foreach ($book_languages as $book_language) : ?>
                          <option value="<?= $book_language['BoL_Id']; ?>"><?= $book_language['BoL_Name']; ?></option>
                      <?php endforeach; ?>
                    </select>
                </div>
                <div class='col-md-2'>
                    <label for='Boo_QOH' class='form-label'>Book QOH</label>
                    <input type="number" name='Boo_QOH' class='form-control' id='Boo_QOH' required>
                </div>
                <div class='col-md-3'>
                    <label for='Gen_Id' class='form-label'>Genre</label>
                    <select name='Gen_Id' id='Gen_Id' class='form-select' required>
                        <option value=''>Choose...</option>
                      <?php foreach ($genres as $genre) : ?>
                          <option value="<?= $genre['Gen_Id']; ?>"><?= $genre['Gen_Name']; ?></option>
                      <?php endforeach; ?>
                    </select>
                </div>
                <div class='col-md-7'>
                    <label for='Boo_Img_url' class='form-label'>Book Image Url</label>
                    <input type='url' name='Boo_Img_url' class='form-control' id='Boo_Img_url' required>
                </div>
                <div class='col-md-2'>
                    <div class='form-check mt-4 pt-3'>
                        <input name="Boo_Featured" class='form-check-input' type='checkbox' id='Boo_Featured'>
                        <label class='form-check-label' for='Boo_Featured'>Is Featured?</label>
                    </div>
                </div>
                <div class='col-12 mt-5'>
                    <input type='hidden' name='form_action' value='insert'>
                    <input type='hidden' name='model' value='book'>
                    <button type='submit' class='btn btn-primary w-50'>Add Book</button>
                </div>
            </form>
        </div>
        <div class="col-6">
            <div class='text-center'>
                <img id="BookImgUrl" src="https://via.placeholder.com/300x450?text=Book" class='rounded' width="300" height="450" alt='Book Image'>
            </div>
        </div>
    </div>

    <script>
        document.querySelector("input[name='Boo_Img_url']").addEventListener('change', function () {
            document.querySelector('#BookImgUrl').src = this.value;
        });
    </script>

<?php require_once dirname(__FILE__, 2).'/includes/footer.php'; ?>