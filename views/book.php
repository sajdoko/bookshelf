<?php
  $page_title = "Book";
  require_once 'header.php';
?>

<div class="container mt-5">
    <div class="row">
        <div class="col-sm-12 col-md-9">
            <div class='row'>
                <div class='col-sm-12 col-md-4'>
                    <div class='card shadow'>
                        <img src="<?= $book['Boo_Img_url']; ?>" class='bd-placeholder-img card-img-top'
                                alt='<?= $book['Boo_Title']; ?>'>
                        <div class='card-body'>
                            <p class='card-text'>ISBN: <?= $book['Boo_ISBN']; ?></p>
                        </div>
                    </div>
                </div>
                <div class='col-sm-12 col-md-8'>
                    <div class='card shadow'>
                        <div class='card-body'>
                            <h5 class='card-title' style='min-height: 50px;'>Title: <?= $book['Boo_Title']; ?></h5>
                            <p class="m-0">Author: <?= $book['Aut_Name']; ?></p>
                            <p class="m-0">Language: <?= $book['BoL_Name']; ?></p>
                            <p class='p-0'>Genre: <?= $book['Gen_Name']; ?></p>
                            <p class="card-text">Description: <?= $book['Boo_Description']; ?></p>
                            <p class='card-text'><small class='text-muted'>Published: <?= $book['Boo_Pub_Date']; ?>
                                    by <?= $book['Pub_Name']; ?></small></p>
                            <p class='card-text mb-auto'>Price: &euro;<?= number_format($book['Boo_Price'], 2); ?></p>
                            <p class='text-muted'>In Stock: <?= $book['Boo_QOH'] ?? 0; ?></p>

                            <form action='../cart' method='post' class="add-book-to-cart">
                                <input type='hidden' name='Boo_ISBN' value="<?= $book['Boo_ISBN'] ?>">
                                <div class='input-group mb-3'>
                                    <label>
                                        <input type='number' name='quantity' class='form-control' value='1' min='1'
                                                max="<?= $book['Boo_QOH'] ?? 0 ?>"
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
                            <p class="card-text">About <?= $book['Aut_Name']; ?></p>
                            <p class="card-text"><?= $book['Aut_Bio']; ?></p>
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
                        <ul class='mb-0'>
                        <?php foreach ($genres as $genre) : ?>
                            <li><a href='/book/<?= create_url_string($genre['Boo_Title']); ?>'
                                    title="<?= $genre['Boo_Title']; ?>"><?= $genre['Boo_Title']; ?></a></li>
                        <?php endforeach; ?>
                        </ul>
                    <?php else : ?>
                        <p class='mb-0'>There are no other books in this genre</p>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<?php require_once 'footer.php'; ?>
