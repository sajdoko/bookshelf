<?php
  $page_title = "Books";
  require_once 'includes/header.php';

  $books = retrieveAllRows(
    'SELECT *
            FROM BOOK
            JOIN BOOK_LANGUAGE BL on BL.BoL_Id = BOOK.BoL_Id
            JOIN PUBLISHER P on P.Pub_Id = BOOK.Pub_Id
            LEFT JOIN BOOK_AUTHOR BA on BOOK.Boo_ISBN = BA.Boo_ISBN
            LEFT JOIN AUTHOR A on A.Aut_Id = BA.Aut_Id
            LEFT JOIN BOOK_GENRE BG on BOOK.Boo_ISBN = BG.Boo_ISBN
            LEFT JOIN GENRE G on G.Gen_Id = BG.Gen_Id'
  );
?>
    <div class='row'>
        <div class='col'>
            <h1 class='display-5 m-3'><?= $page_title; ?></h1>
            <hr>
        </div>
    </div>

    <div class='row'>
        <div class='col'>
              <?php if (count($books) > 0) : ?>
                  <table class="table">
                      <thead>
                      <tr>
                          <th>Title</th>
                          <th>Author</th>
                          <th>Genre</th>
                          <th>Language</th>
                          <th>Publisher</th>
                          <th>Price</th>
                          <th>Action</th>
                      </tr>
                      </thead>
                      <tbody>
                      <?php foreach ($books as $book) : ?>
                          <tr>
                              <td><a href='/book/<?= create_url_string($book['Boo_Title']); ?>' target="_blank"
                                     title="<?= $book['Boo_Title']; ?>"><?= $book['Boo_Title']; ?></a></td>
                              <td><?= $book['Aut_Name']; ?></td>
                              <td><?= $book['Gen_Name']; ?></td>
                              <td><?= $book['BoL_Name']; ?></td>
                              <td><?= $book['Pub_Name']; ?></td>
                              <td>&euro;<?= number_format($book['Boo_Price'], 2); ?></td>
                              <td>
                                  <a href="/admin/book/<?= create_url_string($book['Boo_Title']); ?>" class="btn btn-sm btn-primary"><i class='bi bi-pencil-square mx-2'></i></a>
                                  <a class='btn btn-sm btn-outline-danger'><i class='bi bi-trash mx-2' data-bs-toggle='tooltip' data-bs-placement='left' data-bs-title='Delete the book?'></i></a>
                              </td>
                          </tr>
                      <?php endforeach; ?>
                      </tbody>
                  </table>
              <?php endif; ?>
        </div>
    </div>
<?php require_once 'includes/footer.php'; ?>