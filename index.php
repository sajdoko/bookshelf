<?php
  // Include common functions
  require_once 'includes/functions.php';

  // Get list of featured books
  $featured_books = get_featured_books();
?>
<!DOCTYPE html>
<html>
  <head>
    <title>The Bookshelf</title>
    <!-- Include Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">
  </head>
  <body>
    <header>
      <!-- Use Bootstrap navbar component -->
      <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <a class="navbar-brand" href="#">The Bookshelf</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
          <ul class="navbar-nav">
            <li class="nav-item active">
              <a class="nav-link" href="#">Browse Books</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="#">My Account</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="#">Cart</a>
            </li>
          </ul>
        </div>
      </nav>
    </header>
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
    <footer>
      <p>Copyright The Bookshelf</p>
    </footer>
  </body>
</html>