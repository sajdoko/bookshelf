<?php
  $page_title = 'Cart';
  require_once '../includes/header.php';
  $self_url = strtok($_SERVER['REQUEST_URI'], '?');

  $errors = [];
  // Process form data when form is submitted
  if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['Boo_ISBN'], $_POST['quantity']) && is_numeric($_POST['quantity'])) {

      $Boo_ISBN = $_POST['Boo_ISBN'];
      $quantity = (int) $_POST['quantity'];

      $book = get_book_by_isbn($Boo_ISBN);
      if ($book && $quantity > 0) {
        if (isset($_SESSION['cart']) && is_array($_SESSION['cart'])) {
          if (array_key_exists($Boo_ISBN, $_SESSION['cart'])) {
            $_SESSION['cart'][$Boo_ISBN] += $quantity;
          }
          else {
            $_SESSION['cart'][$Boo_ISBN] = $quantity;
          }
        }
        else {
          $_SESSION['cart'] = [$Boo_ISBN => $quantity];
        }
      }

    }
    else {
      if (isset($_POST['update']) && isset($_SESSION['cart'])) {
        foreach ($_POST as $k => $v) {
          if (str_contains($k, 'quantity') && is_numeric($v)) {
            $id = str_replace('quantity-', '', $k);
            $quantity = (int) $v;
            // Always do checks and validation
            if (isset($_SESSION['cart'][$id]) && $quantity > 0) {
              // Update new quantity
              $_SESSION['cart'][$id] = $quantity;
            }
          }
        }
      }
    }
    header('Location: '.$self_url);
    exit;
  }
  else {
    if (isset($_GET['remove']) && isset($_SESSION['cart']) && isset($_SESSION['cart'][$_GET['remove']])) {
      // Remove the product from the shopping cart
      unset($_SESSION['cart'][$_GET['remove']]);
      header('Location: '.$self_url);
      exit;
    }
  }

  // Check the session variable for products in cart
  $products_in_cart = $_SESSION['cart'] ?? [];
  $cart_books = [];
  $subtotal = 0.00;

  if ($products_in_cart) {
    $array_to_question_marks = implode(',', array_fill(0, count($products_in_cart), '?'));
    $query = 'SELECT * FROM BOOK WHERE Boo_ISBN IN ('.$array_to_question_marks.')';
    $cart_books = retrieveAllRows($query, array_keys($products_in_cart));

    foreach ($cart_books as $book) {
      $subtotal += (float) $book['Boo_Price'] * (int) $products_in_cart[$book['Boo_ISBN']];
    }
  }

?>
<div class='container cart'>
    <div class='row'>
        <div class='col-12'>
            <h1 class="display-5 mb-4">Shopping Cart</h1>
            <form action='<?= $self_url; ?>' method='POST'>
                <table class='table'>
                    <thead>
                    <tr>
                        <th scope='col' colspan='2'>Book</th>
                        <th scope='col'>Price</th>
                        <th scope='col'>Quantity</th>
                        <th scope='col'>Total</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php if (!empty($cart_books)): ?>
                      <?php foreach ($cart_books as $book): ?>
                            <tr>
                                <th scope='row' colspan='2'>
                                    <a href='/book/<?= create_url_string($book['Boo_Title']); ?>'
                                       title="<?= $book['Boo_Title']; ?>"><?= $book['Boo_Title']; ?></a>
                                    <a href="<?= $self_url; ?>?remove=<?= $book['Boo_ISBN'] ?>" type='button' class='btn btn-sm btn-close'
                                       aria-label='Remove'></a>

                                </th>
                                <td>&euro;<?= $book['Boo_Price']; ?></td>
                                <td class="quantity">
                                    <label>
                                        <input type="number" class='form-control form-control-sm' name="quantity-<?= $book['Boo_ISBN'] ?>"
                                               value="<?= $products_in_cart[$book['Boo_ISBN']] ?>" min="1"
                                               max="<?= $book['Boo_QOH'] ?>" placeholder="Quantity" required>
                                    </label>
                                </td>
                                <td class="price">&euro;<?= $book['Boo_Price'] * $products_in_cart[$book['Boo_ISBN']] ?></td>
                            </tr>
                      <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan='5' class="text-center">You don't have books added in your Shopping Cart!</td>
                        </tr>
                    <?php endif; ?>
                    </tbody>
                </table>
                <div class="text-end">
                    <h4 class="pb-3">Subtotal: &euro;<?= $subtotal ?></h4>
                    <input type="submit" class='btn btn-outline-secondary' value="Update Cart" name="update">
                    <a href="../pages/checkout" class="btn btn-success" title="">Go to Checkout</a>
                </div>
            </form>
        </div>
    </div>
</div>

<?php require_once '../includes/footer.php'; ?>
