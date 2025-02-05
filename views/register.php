<?php
  $page_title = "Register";
  require_once 'header.php';
?>


<div class='form-signin w-100 m-auto'>
    <!-- Display error message if there is one -->
  <?php
    if ($error_msg) {
      echo '<div class="alert alert-danger">'.$error_msg.'</div>';
    }
  ?>
    <form action="<?= htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post">
        <h1 class='h3 mb-3 fw-normal'>Register</h1>
        <hr class='my-3'>
        <div class='row'>
            <div class='col-md-6'>
                <label for='first_name'>First Name</label>
                <input type='text' name='first_name' class='form-control' id='first_name' placeholder='First Name' required>
            </div>
            <div class='col-md-6'>
                <label for='last_name'>Last Name</label>
                <input type='text' name='last_name' class='form-control' id='last_name' placeholder='Last Name' required>
            </div>
            <div class='col-md-6'>
                <label for='email'>Email address</label>
                <input type='email' name='email' class='form-control' id='email' placeholder='name@example.com' required>
            </div>
            <div class='col-md-6'>
                <label for='password'>Password</label>
                <input type='password' name='password' class='form-control' id='password' placeholder='Password' required>
            </div>
            <div class='col-12'>
                <label for='phone'>Phone</label>
                <input type='text' name='phone' class='form-control' id='phone' placeholder='Phone' required>
            </div>
            <div class='col-md-9'>
                <label for='street' class='form-label'>Street</label>
                <input type='text' name='street' class='form-control' id='street' placeholder='1234 Main St' required>
            </div>
            <div class='col-md-3'>
                <label for='zip' class='form-label'>Zip</label>
                <input type='number' name="zip" class='form-control w-75' id='zip' placeholder='00000' required>
            </div>
            <div class='col-md-6'>
                <label for='city' class='form-label'>City</label>
                <input type='text' name='city' class='form-control' id='city' placeholder='Tirane' required>
            </div>
            <div class='col-md-6'>
                <label for='country' class='form-label'>Country</label>
                <select name="country" class='form-select' id='country' required>
                    <option value=''>Choose...</option>
                  <?php foreach ($countries as $country) : ?>
                      <option value="<?= $country['Cou_Alpha2Code']; ?>"><?= $country['Cou_Name']; ?></option>
                  <?php endforeach; ?>
                </select>
            </div>
            <div class='col-12 mt-4'>
                <input type='submit' name="submitRegister" value="Register" class='w-100 btn btn-lg btn-primary'>
                <p class='text-center mt-5 text-muted'>Do you have an account? <a href='../login'>Log In</a></p>
            </div>
        </div>
    </form>
</div>

<?php require_once 'footer.php'; ?>
