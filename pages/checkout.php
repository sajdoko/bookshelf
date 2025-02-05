<?php
  $page_title = 'Checkout';
  require_once dirname(__DIR__) . '/views/header.php';

  $user_id = $_SESSION['Cus_Id'] ?? 0;

  /** @var $logged_in_customer $logged_in_customer */

  $errors = [];
  if (isset($_SESSION['checkout_errors'])) {
    $errors = $_SESSION['checkout_errors'];
    unset($_SESSION['checkout_errors']);
  }

  // Check the session variable for products in cart
  $products_in_cart = $_SESSION['cart'] ?? [];
  $cart_books = [];
  $subtotal = 0.00;

  if ($products_in_cart) {
    $array_to_question_marks = implode(',', array_fill(0, count($products_in_cart), '?'));
    $query = 'SELECT * FROM BOOK WHERE Boo_ISBN IN ('.$array_to_question_marks.')';
    $cart_books = retrieveAllRows($query, array_map('strval', array_keys($products_in_cart)));

    foreach ($cart_books as $book) {
      $subtotal += (float) $book['Boo_Price'] * (int) $products_in_cart[$book['Boo_ISBN']];
    }
  }
  else {
    $errors[] = "You don't have any books added to your shopping cart!";
  }
  $countries = retrieveAllRows('SELECT * FROM COUNTRY ORDER BY Cou_Name');
  $shipping_methods = retrieveAllRows('SELECT * FROM SHIPPING_METHOD');

?>
    <!-- Display error message if there is one -->
<?php if (!empty($errors)) : ?>
    <div class="row">
        <div class="col-md-6 offset-md-3">
          <?php foreach ($errors as $error): ?>
            <?= '<div class="alert alert-danger">'.$error.'</div>'; ?>
          <?php endforeach; ?>
        </div>
    </div>
<?php endif; ?>
    <div class='container'>
        <div class='py-3 text-center'>
            <h2>Checkout form</h2>
            <p class='lead'>Please make sure that the details below are correct!</p>
        </div>

        <div class='row g-5'>
            <div class='col-md-5 col-lg-4 order-md-last'>
                <h4 class='d-flex justify-content-between align-items-center mb-3'>
                    <span class='text-primary'>Your cart</span>
                    <span class='badge bg-primary rounded-pill'><?= count($cart_books); ?></span>
                </h4>

              <?php if (!empty($cart_books)): ?>
                  <ul class='list-group mb-3'>
                    <?php foreach ($cart_books as $book): ?>
                        <li class='list-group-item d-flex justify-content-between lh-sm'>
                            <div>
                                <h6 class='my-0'><a href='/book/<?= create_url_string($book['Boo_Title']); ?>'
                                                    title="<?= $book['Boo_Title']; ?>"><?= $book['Boo_Title']; ?></a></h6>
                            </div>
                            <span class='text-muted'>&euro;<?= $book['Boo_Price'] * $products_in_cart[$book['Boo_ISBN']] ?></span>
                        </li>
                    <?php endforeach; ?>
                      <li class='list-group-item d-flex justify-content-between'>
                          <span>Total (EUR)</span>
                          <strong>&euro;<?= $subtotal; ?></strong>
                      </li>
                  </ul>
              <?php endif; ?>

            </div>
            <div class='col-md-7 col-lg-8'>
                <h4 class='mb-3'>Shipping Details</h4>
                <form action="/pages/thank-you" method="POST">
                    <div class='row g-3'>
                        <div class='col-sm-6'>
                            <label for='firstName' class='form-label'>First name</label>
                            <input type='text' name="first_name" class='form-control' id='firstName' placeholder=''
                                   value='<?= $logged_in_customer['Cus_FirstName'] ?? ''; ?>' required>
                            <div class='invalid-feedback'>
                                Valid first name is required.
                            </div>
                        </div>

                        <div class='col-sm-6'>
                            <label for='lastName' class='form-label'>Last name</label>
                            <input type='text' name="last_name" class='form-control' id='lastName' placeholder=''
                                   value='<?= $logged_in_customer['Cus_LastName'] ?? ''; ?>' required>
                            <div class='invalid-feedback'>
                                Valid last name is required.
                            </div>
                        </div>

                        <div class='col-<?= $user_id ? '12' : '6'; ?>'>
                            <label for='email' class='form-label'>Email</label>
                            <input type='email' name="email" class='form-control' id='email' placeholder='you@example.com'
                                   value="<?= $logged_in_customer['Cus_Email'] ?? ''; ?>">
                            <div class='invalid-feedback'>
                                Please enter a valid email address for shipping updates.
                            </div>
                        </div>
                      <?php if (!$user_id) : ?>
                          <div class='col-sm-6'>
                              <label for='password' class='form-label'>Password</label>
                              <input type='password' name="password" class='form-control' id='password' placeholder='' value='' required>
                              <div class='invalid-feedback'>
                                  Valid password is required.
                              </div>
                          </div>
                      <?php endif; ?>

                        <div class='col-6'>
                            <label for='phone' class='form-label'>Phone</label>
                            <input type='text' name='phone' class='form-control' id='phone' value="<?= $logged_in_customer['Cus_Phone'] ?? ''; ?>"
                                   placeholder='123456789'
                                   required>
                        </div>

                        <div class='col-6'>
                            <label for='street' class='form-label'>Address</label>
                            <input type='text' name='street' class='form-control' id='street'
                                   value="<?= $logged_in_customer['Add_Street_Name'] ?? ''; ?>"
                                   placeholder='1234 Main St'
                                   required>
                        </div>

                        <div class='col-md-4'>
                            <label for='city' class='form-label'>City</label>
                            <input type='text' name='city' class='form-control' id='city' value="<?= $logged_in_customer['Add_City'] ?? ''; ?>"
                                   placeholder='Tirane'
                                   required>
                        </div>

                        <div class='col-md-5'>
                            <label for='country' class='form-label'>Country</label>
                            <select name='country' class='form-select' id='country' required>
                                <option value=''>Choose...</option>
                              <?php foreach ($countries as $country) : ?>
                                  <option value="<?= $country['Cou_Alpha2Code']; ?>" <?= $country['Cou_Alpha2Code'] == ($logged_in_customer['Cou_Alpha2Code'] ?? '') ? 'selected' : ''; ?>><?= $country['Cou_Name']; ?></option>
                              <?php endforeach; ?>
                            </select>
                        </div>

                        <div class='col-md-3'>
                            <label for='zip' class='form-label'>Zip</label>
                            <input type='text' name="zip" class='form-control' id='zip' value="<?= $logged_in_customer['Add_Zip'] ?? ''; ?>"
                                   placeholder='1001' required>
                            <div class='invalid-feedback'>
                                Zip code required.
                            </div>
                        </div>

                        <h4 class='mb-3'>Shipping Method</h4>

                        <div class='my-3'>
                          <?php foreach ($shipping_methods as $sh_p) : ?>
                              <div class='form-check'>
                                  <input id="<?= create_html_id($sh_p['ShM_Name']); ?>" name='shippingMethod' type='radio'
                                         value="<?= $sh_p['ShM_Id']; ?>" class='form-check-input' required>
                                  <label class='form-check-label' for='<?= create_html_id($sh_p['ShM_Name']); ?>'><?= $sh_p['ShM_Name']; ?> -
                                      &euro;<?= number_format($sh_p['ShM_Price'], 2); ?></label>
                              </div>
                          <?php endforeach; ?>
                        </div>

                        <h4 class='mb-3'>Payment Method</h4>

                        <div class='my-3'>
                            <div class='form-check'>
                                <input id='cod' name='paymentMethod' type='radio' value='cod' class='form-check-input' required>
                                <label class='form-check-label' for='cod'>Cash on Delivery</label>
                            </div>
                            <div class='form-check'>
                                <input id='paypal' name='paymentMethod' type='radio' value='paypal' class='form-check-input' required>
                                <label class='form-check-label' for='paypal'>PayPal</label>
                                <small class='text-muted'>
                                    Username: <strong>sajdoko-buyer@gmail.com</strong> 
                                    Password: <strong>GDFiv_b3gP$xHSY</strong>
                                </small>
                            </div>
                        </div>
                    </div>

                    <hr class='my-4'>

                    <button class='w-100 btn btn-primary btn-lg' type='submit'>Place Order</button>
                </form>
            </div>
        </div>
    </div>
<?php require_once dirname(__DIR__) . '/views/footer.php'; ?>