<?php
  $page_title = "Genre";
  require_once 'header.php';
?>

<section class='py-5 text-center container'>
    <div class='row py-lg-5'>
        <div class='col-lg-6 col-md-8 mx-auto'>
            <h1 class='fw-light'>Books in <?= ucfirst($genre_url_string); ?></h1>
        </div>
    </div>
</section>

<div class='album py-5 bg-light'>
    <div class='container'>
        <div class='row'>
            <?php if (count($genres) > 0) : ?>
            <?php foreach ($genres as $genre) : ?>
                    <div class='col-sm-12 col-md-4'>
                        <div class='card shadow-sm'>
                            <a href='/book/<?= create_url_string($genre['Boo_Title']); ?>' title="<?= $genre['Boo_Title']; ?>"><img
                                        src="<?= $genre['Boo_Img_url']; ?>" class='bd-placeholder-img card-img-top' alt='Book cover'></a>
                            <div class='card-body'>
                                <h5 class='card-title' style='min-height: 50px;'>Title: <?= $genre['Boo_Title']; ?></h5>
                                <p class="card-text">Author: <?= $genre['Aut_Name']; ?></p>
                                <p class="card-text">Language: <?= $genre['BoL_Name']; ?></p>
                                <p class="card-text">Description: <?= substr($genre['Boo_Description'], 0, 100); ?> ...</p>
                                <p class='card-text'><small class='text-muted'>Published: <?= $genre['Boo_Pub_Date']; ?>
                                        by <?= $genre['Pub_Name']; ?></small></p>
                                <p class="card-text">Price: &euro;<?= number_format($genre['Boo_Price'], 2); ?></p>
                                <form action='../pages/cart' method='post' class='add-book-to-cart'>
                                    <input type='hidden' name='Boo_ISBN' value="<?= $genre['Boo_ISBN'] ?>">
                                    <div class='input-group'>
                                        <label>
                                            <input type='number' name='quantity' class='form-control form-control-sm' value='1' min='1'
                                                    max="<?= $genre['Boo_QOH'] ?? 0; ?>"
                                                    placeholder='0'
                                                    required>
                                        </label>
                                        <input type='submit' class='btn btn-sm btn-success' value='Add To Cart'>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
            <?php endforeach; ?>
            <?php else : ?>
                <div class='col-12 text-center'>
                    <p class='card-text'>No books found in genre: <?= $genre_url_string; ?></p>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>
<?php require_once 'footer.php'; ?>
