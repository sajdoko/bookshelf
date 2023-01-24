<?php
  $page_title = 'Checkout';
  require_once '../includes/header.php';

  $user_id = $_SESSION['Cus_Id']??0;

  /** @var $logged_in_customer $logged_in_customer */

  $errors = [];

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
  } else {
      $errors[] = "You don't have any books added to your shopping cart!";
  }

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
      <div class='py-5 text-center'>
        <h2>Checkout form</h2>
        <p class='lead'>Below is an example form built entirely with Bootstrap’s form controls. Each required form group has a validation state that
          can be triggered by attempting to submit the form without completing it.</p>
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
          <h4 class='mb-3'>Billing address</h4>
          <form action="../pages/thank-you" method="POST">
            <div class='row g-3'>
              <div class='col-sm-6'>
                <label for='firstName' class='form-label'>First name</label>
                <input type='text' name="firstName" class='form-control' id='firstName' placeholder='' value='<?= $logged_in_customer['Cus_FirstName']??'';?>' required>
                <div class='invalid-feedback'>
                  Valid first name is required.
                </div>
              </div>

              <div class='col-sm-6'>
                <label for='lastName' class='form-label'>Last name</label>
                <input type='text' name="lastName" class='form-control' id='lastName' placeholder='' value='<?= $logged_in_customer['Cus_LastName']??'';?>' required>
                <div class='invalid-feedback'>
                  Valid last name is required.
                </div>
              </div>

              <div class='col-<?= $user_id?'12':'6'; ?>'>
                <label for='email' class='form-label'>Email</label>
                <input type='email' name="email" class='form-control' id='email' placeholder='you@example.com' value="<?= $logged_in_customer['Cus_Email']??'';?>">
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

              <div class='col-12'>
                <label for='address' class='form-label'>Address</label>
                <input type='text' name="address" class='form-control' id='address' placeholder='1234 Main St' required>
                <div class='invalid-feedback'>
                  Please enter your shipping address.
                </div>
              </div>

              <div class='col-12'>
                <label for='address2' class='form-label'>Address 2 <span class='text-muted'>(Optional)</span></label>
                <input type='text' name="address2" class='form-control' id='address2' placeholder='Apartment or suite'>
              </div>

              <div class='col-md-5'>
                <label for='country' class='form-label'>Country</label>
                <select class='form-select' name="country" id='country' required>
                  <option value=''>Choose...</option>
                  <option>United States</option>
                </select>
                <div class='invalid-feedback'>
                  Please select a valid country.
                </div>
              </div>

              <div class='col-md-4'>
                <label for='state' class='form-label'>State</label>
                <select class='form-select' name="state" id='state' required>
                  <option value=''>Choose...</option>
                  <option>California</option>
                </select>
                <div class='invalid-feedback'>
                  Please provide a valid state.
                </div>
              </div>

              <div class='col-md-3'>
                <label for='zip' class='form-label'>Zip</label>
                <input type='text' name="zip" class='form-control' id='zip' placeholder='' required>
                <div class='invalid-feedback'>
                  Zip code required.
                </div>
              </div>
            </div>

<!--            <hr class='my-4'>-->
<!---->
<!--            <div class='form-check'>-->
<!--              <input type='checkbox' class='form-check-input' id='same-address'>-->
<!--              <label class='form-check-label' for='same-address'>Shipping address is the same as my billing address</label>-->
<!--            </div>-->
<!---->
<!--            <div class='form-check'>-->
<!--              <input type='checkbox' class='form-check-input' id='save-info'>-->
<!--              <label class='form-check-label' for='save-info'>Save this information for next time</label>-->
<!--            </div>-->

<!--            <hr class='my-4'>-->
<!---->
<!--            <h4 class='mb-3'>Payment</h4>-->
<!---->
<!--            <div class='my-3'>-->
<!--              <div class='form-check'>-->
<!--                <input id='credit' name='paymentMethod' type='radio' class='form-check-input' checked required>-->
<!--                <label class='form-check-label' for='credit'>Credit card</label>-->
<!--              </div>-->
<!--              <div class='form-check'>-->
<!--                <input id='debit' name='paymentMethod' type='radio' class='form-check-input' required>-->
<!--                <label class='form-check-label' for='debit'>Debit card</label>-->
<!--              </div>-->
<!--              <div class='form-check'>-->
<!--                <input id='paypal' name='paymentMethod' type='radio' class='form-check-input' required>-->
<!--                <label class='form-check-label' for='paypal'>PayPal</label>-->
<!--              </div>-->
<!--            </div>-->

<!--            <div class='row gy-3'>-->
<!--              <div class='col-md-6'>-->
<!--                <label for='cc-name' class='form-label'>Name on card</label>-->
<!--                <input type='text' class='form-control' id='cc-name' placeholder='' required>-->
<!--                <small class='text-muted'>Full name as displayed on card</small>-->
<!--                <div class='invalid-feedback'>-->
<!--                  Name on card is required-->
<!--                </div>-->
<!--              </div>-->
<!---->
<!--              <div class='col-md-6'>-->
<!--                <label for='cc-number' class='form-label'>Credit card number</label>-->
<!--                <input type='text' class='form-control' id='cc-number' placeholder='' required>-->
<!--                <div class='invalid-feedback'>-->
<!--                  Credit card number is required-->
<!--                </div>-->
<!--              </div>-->
<!---->
<!--              <div class='col-md-3'>-->
<!--                <label for='cc-expiration' class='form-label'>Expiration</label>-->
<!--                <input type='text' class='form-control' id='cc-expiration' placeholder='' required>-->
<!--                <div class='invalid-feedback'>-->
<!--                  Expiration date required-->
<!--                </div>-->
<!--              </div>-->
<!---->
<!--              <div class='col-md-3'>-->
<!--                <label for='cc-cvv' class='form-label'>CVV</label>-->
<!--                <input type='text' class='form-control' id='cc-cvv' placeholder='' required>-->
<!--                <div class='invalid-feedback'>-->
<!--                  Security code required-->
<!--                </div>-->
<!--              </div>-->
<!--            </div>-->

            <hr class='my-4'>

            <button class='w-100 btn btn-primary btn-lg' type='submit'>Place Order</button>
          </form>
        </div>
      </div>
      </div>
<?php require_once '../includes/footer.php'; ?>