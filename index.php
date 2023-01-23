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
        <a href='/genre/<?php echo create_url_string($genre['Gen_Name']); ?>' title="<?php echo $genre['Gen_Name']; ?>" class='text-decoration-none'>
            <img src="/assets/images/genres/<?php echo lcfirst($genre['Gen_Name']); ?> book.png" width="150" alt="Image" class="rounded mx-auto d-block">
          <h4 class='display-6'><?php echo $genre['Gen_Name']; ?>(<?php echo $genre['NrBooks']; ?>)</h4>
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
                    <strong class='d-inline-block text-primary'><?php echo $book['Gen_Name']; ?></strong>
                    <h3 class='card-title mb-0' style='min-height: 50px;'><a href='/book/<?php echo create_url_string($book['Boo_Title']); ?>' title="<?php echo $book['Boo_Title']; ?>"><?php echo $book['Boo_Title']; ?></a></h3>
                    <p class="m-0">Author: <?php echo $book['Aut_Name']; ?></p>
                    <p class="p-0">Language: <?php echo $book['BoL_Name']; ?></p>
                    <p class="card-text mb-auto">Description: <?php echo substr($book['Boo_Description'], 0, 100); ?> ...</p>
                    <p class='card-text'><small class='text-muted'>Published: <?php echo $book['Boo_Pub_Date']->format('Y-m-d'); ?>
                            by <?php echo $book['Pub_Name']; ?></small></p>
                    <p class="card-text">Price: <?php echo $book['Boo_Price']; ?></p>
                    <a href="#" class="btn btn-primary">Add to Cart</a>
                </div>
                <div class='col-auto px-0'>
                    <a href='/book/<?php echo create_url_string($book['Boo_Title']); ?>' title="<?php echo $book['Boo_Title']; ?>"><img src="<?php echo $book['Boo_Img_url']; ?>" height="350" class='bd-placeholder-img card-img-top' alt='Book cover'></a>
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
              <a href='/book/<?php echo create_url_string($book['Boo_Title']); ?>' title="<?php echo $book['Boo_Title']; ?>"><img src="<?php echo $book['Boo_Img_url']; ?>" class="bd-placeholder-img card-img-top" alt="Book cover"></a>
              <div class="card-body">
                  <h5 class="card-title" style="min-height: 50px;">Title: <?php echo $book['Boo_Title']; ?></h5>
                  <p class="card-text">Author: <?php echo $book['Aut_Name']; ?></p>
                  <p class="card-text">Language: <?php echo $book['BoL_Name']; ?></p>
                  <p class="card-text">Description: <?php echo substr($book['Boo_Description'],0 , 100); ?> ...</p>
                  <p class='card-text'><small class='text-muted'>Published: <?php echo $book['Boo_Pub_Date']->format('Y-m-d'); ?> by  <?php echo $book['Pub_Name']; ?></small></p>
                  <p class="card-text">Price: <?php echo $book['Boo_Price']; ?></p>
                  <a href="#" class="btn btn-primary">Add to Cart</a>
              </div>
          </div>
      </div>
    <?php endforeach; ?>
  </div>
</div>


<?php require_once 'includes/footer.php'; ?>