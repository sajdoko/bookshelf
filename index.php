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
    <div class="col-md-2">
      <a href="#">
        <img src="https://via.placeholder.com/150x150?text=150x150" alt="Image" class="rounded-circle mx-auto d-block">
      </a>
      <h4 class="pt-2">Heading</h4>
    </div>
    <div class="col-md-2">
      <a href="#">
        <img src="https://via.placeholder.com/150x150?text=150x150" alt="Image" class="rounded-circle mx-auto d-block">
      </a>
      <h4 class="pt-2">Heading</h4>
    </div>
    <div class="col-md-2">
      <a href="#">
        <img src="https://via.placeholder.com/150x150?text=150x150" alt="Image" class="rounded-circle mx-auto d-block">
      </a>
      <h4 class="pt-2">Heading</h4>
    </div>
    <div class="col-md-2">
      <a href="#">
        <img src="https://via.placeholder.com/150x150?text=150x150" alt="Image" class="rounded-circle mx-auto d-block">
      </a>
      <h4 class="pt-2">Heading</h4>
    </div>
    <div class="col-md-2">
      <a href="#">
        <img src="https://via.placeholder.com/150x150?text=150x150" alt="Image" class="rounded-circle mx-auto d-block">
      </a>
      <h4 class="pt-2">Heading</h4>
    </div>
    <div class="col-md-2">
      <a href="#">
        <img src="https://via.placeholder.com/150x150?text=150x150" alt="Image" class="rounded-circle mx-auto d-block">
      </a>
      <h4 class="pt-2">Heading</h4>
    </div>
  </div>
</div>

<div class="container pt-5">
  <h2 class="text-center mb-5">Featured Books</h2>
  <div class="row">
    <!-- Display a list of featured books here -->
    <?php
    $featured_books = get_featured_books();
    foreach ($featured_books as $book) {
//        echo "<pre>";
//            print_r($book);
//          echo '</pre>';
      // Display book information and a "Buy Now" button
      echo '<div class="col-4">';
      echo '<div class="card shadow-sm">';
      echo '<img src="' . $book['Boo_Img_url'] . '" class="bd-placeholder-img card-img-top" alt="Book cover">';
      echo '<div class="card-body">';
      echo '<h5 class="card-title">Title: ' . $book['Boo_Title'] . '</h5>';
      echo '<p class="card-text">Author: ' . $book['Aut_Name'] . '</p>';
      echo '<p class="card-text">Language: ' . $book['BoL_Name'] . '</p>';
      echo '<p class="card-text">Description: ' . $book['Boo_Description'] . '</p>';
      echo '<p class="card-text">Price: ' . $book['Boo_Price'] . '</p>';
      echo '<a href="#" class="btn btn-primary">Buy Now</a>';
      echo '</div>';
      echo '</div>';
      echo '</div>';
    }
    ?>
  </div>
</div>


<?php require_once 'includes/footer.php'; ?>