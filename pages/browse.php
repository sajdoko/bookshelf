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
      array_push($errors, "At least one search field is required.");
    }

    // If no errors, search for books in the database
    if (count($errors) == 0) {
      $query = "SELECT * FROM books WHERE title LIKE ? AND author LIKE ? AND language LIKE ? AND publisher LIKE ?";
      if ($stmt = $mysqli->prepare($query)) {
        $title = '%' . $title . '%';
        $author = '%' . $author . '%';
        $language = '%' . $language . '%';
        $publisher = '%' . $publisher . '%';
        $stmt->bind_param('ssss', $title, $author, $language, $publisher);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows > 0) {
          // Books found
          $books = $result->fetch_all(MYSQLI_ASSOC);
        } else {
          // No books found
          array_push($errors, "No books found.");
        }
      }
    }
  }

?>

  <section class="container text-center search-hero-browse">
    <div class="row">
      <div class="col-12">

        <h2>Browse Books</h2>
        <p>Search for books by title, author, language, publisher, or price range:</p>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <div class="form-group">
                <label for="title">Title:</label>
                <input type="text" class="form-control" id="title" name="title" value="<?php echo $_POST["title"]??''; ?>">
            </div>
            <div class="form-group">
                <label for="author">Author:</label>
                <input type="text" class="form-control" id="author" name="author" value="<?php echo $_POST["author"]??''; ?>">
            </div>
            <div class="form-group">
                <label for="language">Language:</label>
                <input type="text" class="form-control" id="language" name="language" value="<?php echo $_POST["language"]??''; ?>">
            </div>
            <div class="form-group">
                <label for="publisher">Publisher:</label>
                <input type="text" class="form-control" id="publisher" name="publisher" value="<?php echo $_POST["publisher"]??''; ?>">
            </div>

            <div class="form-group">
                <button type="submit" class="btn btn-primary">Search</button>
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
        ?>
        <?php if (isset($books) && count($books) > 0) : ?>
          <table class="table">
            <thead>
              <tr>
                <th>Title</th>
                <th>Author</th>
                <th>Language</th>
                <th>Publisher</th>
                <th>Price</th>
                <th>Add to Cart</th>
              </tr>
            </thead>
            <tbody>
              <?php foreach ($books as $book) : ?>
                <tr>
                  <td><?php echo $book['title']; ?></td>
                  <td><?php echo $book['author']; ?></td>
                  <td><?php echo $book['language']; ?></td>
                  <td><?php echo $book['publisher']; ?></td>
                  <td>$<?php echo number_format($book['price'], 2); ?></td>
                  <td>
                    <form action="add_to_cart.php" method="post">
                      <input type="hidden" name="book_id" value="<?php echo $book['book_id']; ?>">
                      <input type="hidden" name="quantity" value="1">
                      <button type="submit" class="btn btn-primary"><i class="fa fa-shopping-cart"></i></button>
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