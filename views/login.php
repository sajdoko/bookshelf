<?php
  $page_title = "Login";
  require_once 'header.php';
  $self_url = strtok($_SERVER['REQUEST_URI'], '?');
?>

<div class='form-signin w-100 m-auto'>
    <!-- Display error message if there is one -->
  <?php if ($error_msg) {
    echo '<div class="alert alert-danger">'.$error_msg.'</div>';
  } ?>
    <form action="<?= $self_url; ?>" method="post">
        <h1 class='h3 mb-3 fw-normal'>Please sign in</h1>

        <div class='form-floating'>
            <input type='email' name='email' class='form-control' id='floatingInput' placeholder='name@example.com'>
            <label for='floatingInput'>Email address</label>
        </div>
        <div class='form-floating'>
            <input type='password' name='password' class='form-control' id='floatingPassword' placeholder='Password'>
            <label for='floatingPassword'>Password</label>
        </div>

        <button class='w-100 btn btn-lg btn-primary' type='submit'>Sign in</button>
        <p class='text-center mt-5 text-muted'>Don't have an account? <a href="../pages/register">Register</a></p>
    </form>
</div>

<?php require_once 'footer.php'; ?>
