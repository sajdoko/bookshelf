<?php
$page_title = "Browse Books";
require_once 'header.php';
?>
<section class="container search-hero-browse">
    <div class="row">
        <div class="col-12 text-center">

            <h2>Browse Books</h2>
            <p>Search books by title, author, language or publisher.</p>
            <form action="<?= htmlspecialchars($_SERVER["REQUEST_URI"]); ?>" method='post' class='row gx-3 gy-2 align-items-center'>
                <div class='col-sm-3'>
                    <label class='visually-hidden' for='searchTitle'>Title</label>
                    <input type='text' name='title' value="<?= $_POST["title"] ?? ''; ?>" class='form-control' id='searchTitle'
                            placeholder='Title'>
                </div>
                <div class='col-sm-3'>
                    <label class='visually-hidden' for='searchAuthor'>author</label>
                    <input type='text' name='author' value="<?= $_POST["author"] ?? ''; ?>" class='form-control' id='searchAuthor'
                            placeholder='Author'>
                </div>
                <div class='col-sm-2'>
                    <label class='visually-hidden' for='searchLanguage'>Language</label>
                    <input type='text' name='language' value="<?= $_POST["language"] ?? ''; ?>" class='form-control' id='searchLanguage'
                            placeholder='Language'>
                </div>
                <div class='col-sm-2'>
                    <label class='visually-hidden' for='searchPublisher'>Publisher</label>
                    <input type='text' name='publisher' value="<?= $_POST["publisher"] ?? ''; ?>" class='form-control' id='searchPublisher'
                            placeholder='Publisher'>
                </div>
                <div class='col-auto'>
                    <button type='submit' class='btn btn-primary'>Search</button>
                </div>
            </form>
        </div>
        <div class='col-12'>
          <?php
            // Display errors if any
            if (count($errors) > 0) {
              echo '<div class="alert alert-danger">';
              foreach ($errors as $error) {
                echo '<p>'.$error.'</p>';
              }
              echo '</div>';
            }
            //        print_r($books);
          ?>
          <?php if (isset($books) && count($books) > 0) : ?>
              <table class="table mt-5">
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
                          <td><a href='/book/<?= create_url_string($book['Boo_Title']); ?>'
                                  title="<?= $book['Boo_Title']; ?>"><?= $book['Boo_Title']; ?></a></td>
                          <td><?= $book['Aut_Name']; ?></td>
                          <td><?= $book['Gen_Name']; ?></td>
                          <td><?= $book['BoL_Name']; ?></td>
                          <td><?= $book['Pub_Name']; ?></td>
                          <td>&euro;<?= number_format($book['Boo_Price'], 2); ?></td>
                          <td>
                              <form action='../pages/cart' method='post' class='add-book-to-cart'>
                                  <input type='hidden' name='Boo_ISBN' value="<?= $book['Boo_ISBN'] ?>">
                                  <div class='input-group'>
                                      <label>
                                          <input type='number' name='quantity' class='form-control form-control-sm mb-0' value='1' min='1'
                                                  max="<?= $book['Boo_QOH'] ?? 0; ?>"
                                                  placeholder='0'
                                                  required>
                                      </label>
                                      <input type='submit' class='btn btn-sm btn-success mb-0' value='Add To Cart'>
                                  </div>
                              </form>
                          </td>
                      </tr>
                  <?php endforeach; ?>
                  </tbody>
              </table>
          <?php endif; ?>
        </div>
    </div>
</section>
<div class="container">
    <div class='row'>
        <div class='col-12'>
            <h4>TODO</h4>
            <ul>
                <li>Add Pagination</li>
            </ul>
        </div>
    </div>
</div>

<?php require_once 'footer.php'; ?>
