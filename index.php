<?php
  $page_title = "Home";
  require_once 'includes/header.php';
?>

<?php
// echo "<pre>";
// print_r($_SESSION);
// var_dump(login_check());
// echo "</pre>";
?>

<main>
  <!-- Use Bootstrap grid system to display featured books in a grid -->
  <div class="container mt-5">
    <h2 class="text-center mb-5">Featured Books</h2>
    <div class="row">
      <!-- Display a list of featured books here -->
      <?php
        $featured_books = get_featured_books();
        foreach ($featured_books as $book) {
          // Display book information and a "Buy Now" button
          echo '<div class="col-4 mb-4">';
          echo '<div class="card">';
          echo '<img src="' . $book['image_url'] . '" class="card-img-top" alt="Book cover">';
          echo '<div class="card-body">';
          echo '<h5 class="card-title">' . $book['title'] . '</h5>';
          echo '<p class="card-text">' . $book['author'] . '</p>';
          echo '<p class="card-text">' . $book['price'] . '</p>';
          echo '<a href="#" class="btn btn-primary">Buy Now</a>';
          echo '</div>';
          echo '</div>';
          echo '</div>';
        }
      ?>
    </div>
  </div>
</main>

<?php require_once 'includes/footer.php'; ?>