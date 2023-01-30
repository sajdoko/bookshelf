<?php
  $page_title = "Dashboard";
  require_once 'includes/header.php';
?>
        <div class="row">
            <div class="col-12">
                <h1 class='h2'><?= $page_title; ?></h1>

                <pre><?php print_r($_SESSION); ?></pre>
            </div>
        </div>

<?php require_once 'includes/footer.php'; ?>