<?php
$page_title = "Home";
require_once 'includes/header.php';
?>

<section class="search-hero text-center">
  <div class="container">
    <div class="row">
      <div class="col-md-6 offset-md-3">
        <form action="/pages/browse" method="post">
          <div class="input-group mb-3">
            <input type="text" name="title" class="form-control" placeholder="Which title are you looking for?" required aria-label="Which title are you looking for?" aria-describedby="button-addon2">
            <div class="input-group-append">
              <button type="submit" class="btn btn-primary" id="button-addon2">Search</button>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</section>


<div class="container featured-categories my-5">
  <div class="row">
    <?php foreach (get_top_genres_list(6) as $genre): ?>
        <div class="col-sm-6 col-md-2">
        <a href='/genre/<?= create_url_string($genre['Gen_Name']); ?>' title="<?= $genre['Gen_Name']; ?>" class='text-decoration-none'>
            <img src="/assets/images/genres/<?= lcfirst($genre['Gen_Name']); ?> book.png" width="150" alt="Image" class="rounded mx-auto d-block">
          <h4 class='display-6'><?= $genre['Gen_Name']; ?>(<?= $genre['NrBooks']; ?>)</h4>
          </a>

        </div>
    <?php endforeach; ?>
  </div>
</div>

<div class="container-fluid pt-1 px-5">
    <h2 class='display-3 text-center my-5'>Best Sellers</h2>
    <div class='row'>
    <?php foreach (get_featured_books(2) as $book): ?>
        <div class='col-sm-12 col-md-6'>
            <div class="container">
            <div class='row shadow'>
                <div class='col p-4'>
                    <strong class='d-inline-block text-primary'><?= $book['Gen_Name']; ?></strong>
                    <h3 class='card-title mb-0' style='min-height: 50px;'><a href='/book/<?= create_url_string($book['Boo_Title']); ?>' title="<?= $book['Boo_Title']; ?>"><?= $book['Boo_Title']; ?></a></h3>
                    <p class="m-0">Author: <?= $book['Aut_Name']; ?></p>
                    <p class="p-0 mb-auto">Language: <?= $book['BoL_Name']; ?></p>
                    <p class="card-text mb-auto">Description: <?= substr($book['Boo_Description'], 0, 100); ?> ...</p>
                    <p class='card-text mb-auto'><small class='text-muted'>Published: <?= $book['Boo_Pub_Date']->format('Y-m-d'); ?>
                            by <?= $book['Pub_Name']; ?></small></p>
                    <p class="card-text mb-auto">Price: <?= $book['Boo_Price']; ?></p>
                    <p class='text-muted'>In Stock: <?= $book['Boo_QOH']??0; ?></p>
                    <a href="#" class="btn btn-primary">Add to Cart</a>
                </div>
                <div class='col-auto px-0'>
                    <a href='/book/<?= create_url_string($book['Boo_Title']); ?>' title="<?= $book['Boo_Title']; ?>"><img src="<?= $book['Boo_Img_url']; ?>" height="350" class='bd-placeholder-img card-img-top' alt='Book cover'></a>
                </div>
            </div>
            </div>
        </div>
    <?php endforeach; ?>
    </div>
</div>

<div class="container pt-5">
  <h2 class="display-3 my-5">Featured Books</h2>
  <div class="row">
    <!-- Display a list of featured books here -->
    <?php foreach (get_featured_books() as $book): ?>
        <?php //print_r($book); ?>
      <div class="col-sm-12 col-md-4">
          <div class="card shadow-sm">
              <a href='/book/<?= create_url_string($book['Boo_Title']); ?>' title="<?= $book['Boo_Title']; ?>"><img src="<?= $book['Boo_Img_url']; ?>" class="bd-placeholder-img card-img-top" alt="Book cover"></a>
              <div class="card-body">
                  <h5 class='card-title mb-0' style='min-height: 50px;'><a href='/book/<?= create_url_string($book['Boo_Title']); ?>' title="<?= $book['Boo_Title']; ?>"><?= $book['Boo_Title']; ?></a></h5>
                  <p class="card-text">Author: <?= $book['Aut_Name']; ?></p>
                  <p class="card-text">Language: <?= $book['BoL_Name']; ?></p>
                  <p class="card-text">Description: <?= substr($book['Boo_Description'],0 , 100); ?> ...</p>
                  <p class='card-text'><small class='text-muted'>Published: <?= $book['Boo_Pub_Date']->format('Y-m-d'); ?> by  <?= $book['Pub_Name']; ?></small></p>
                  <p class="card-text">Price: <?= $book['Boo_Price']; ?></p>
                  <a href="#" class="btn btn-success">Add to Cart</a>
              </div>
          </div>
      </div>
    <?php endforeach; ?>
  </div>
</div>


<?php require_once 'includes/footer.php'; ?>