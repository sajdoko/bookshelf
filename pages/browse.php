<?php
  $page_title = "Browse Books";
  require_once '../includes/header.php';

  $errors = array();
  // Process form data when form is submitted
  if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validate form data
    $title = trim($_POST["title"]);
    $author = trim($_POST["author"]??'');
    $language = trim($_POST["language"]??'');
    $publisher = trim($_POST["publisher"]??'');

    // Check for empty fields
    if (empty($title) && empty($author) && empty($language) && empty($publisher)) {
      $errors[] = "At least one search field is required.";
    }

    // If no errors, search for books in the database
    if (count($errors) == 0) {
      $query = '
              SELECT *
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
                    P.Pub_Name LIKE ? 
                    ;
            ';
      $books = retrieveAllRows($query, ["%$title%", "%$author%", "%$language%", "%$publisher%"]);
    }
  }

?>

  <section class="container text-center search-hero-browse">
    <div class="row">
      <div class="col-12">

        <h2>Browse Books</h2>
        <p>Search books by title, author, language or publisher.</p>
      <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method='post' class='row gx-3 gy-2 align-items-center'>
          <div class='col-sm-3'>
              <label class='visually-hidden' for='searchTitle'>Title</label>
              <input type='text' name='title' value="<?php echo $_POST["title"] ?? ''; ?>" class='form-control' id='searchTitle' placeholder='Title'>
          </div>
          <div class='col-sm-3'>
              <label class='visually-hidden' for='searchAuthor'>author</label>
              <input type='text' name='author' value="<?php echo $_POST["author"] ?? ''; ?>" class='form-control' id='searchAuthor' placeholder='Author'>
          </div>
          <div class='col-sm-2'>
              <label class='visually-hidden' for='searchLanguage'>Language</label>
              <input type='text' name='language' value="<?php echo $_POST["language"] ?? ''; ?>" class='form-control' id='searchLanguage' placeholder='Language'>
          </div>
          <div class='col-sm-2'>
              <label class='visually-hidden' for='searchPublisher'>Publisher</label>
              <input type='text' name='publisher' value="<?php echo $_POST["publisher"] ?? ''; ?>" class='form-control' id='searchPublisher' placeholder='Publisher'>
          </div>
          <div class='col-auto'>
              <button type='submit' class='btn btn-primary'>Search</button>
          </div>
      </form>
        <br>
        <?php
        // Display errors if any
        if (count($errors) > 0) {
            echo '<div class="alert alert-danger">';
            foreach ($errors as $error) {
                echo '<p>' . $error . '</p>';
            }
            echo '</div>';
        }
//        print_r($books);
        ?>
        <?php if (isset($books) && count($books) > 0) : ?>
          <table class="table">
            <thead>
              <tr>
                <th>Title</th>
                <th>Author</th>
                <th>Genre</th>
                <th>Language</th>
                <th>Publisher</th>
                <th>Price</th>
                <th>Add to Cart</th>
              </tr>
            </thead>
            <tbody>
              <?php foreach ($books as $book) : ?>
                <tr>
                  <td><?php echo $book['Boo_Title']; ?></td>
                  <td><?php echo $book['Aut_Name']; ?></td>
                  <td><?php echo $book['Gen_Name']; ?></td>
                  <td><?php echo $book['BoL_Name']; ?></td>
                  <td><?php echo $book['Pub_Name']; ?></td>
                  <td>$<?php echo number_format($book['Boo_Price'], 2); ?></td>
                  <td>
                    <form action="add_to_cart.php" method="post">
                      <input type="hidden" name="book_id" value="<?php echo $book['Boo_ISBN']; ?>">
                      <input type="hidden" name="quantity" value="1">
                      <button type="submit" class="btn btn-primary"><i class="fa fa-shopping-cart"></i> Add To Cart</button>
                    </form>
                  </td>
                </tr>
              <?php endforeach; ?>
            </tbody>
          </table>
        <?php endif; ?>
    </div>
      </div>
    </div>
  </section>

<?php require_once '../includes/footer.php'; ?>