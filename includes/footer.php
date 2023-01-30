</main>

<footer class="text-muted py-5">
    <div class="container">
        <p class="float-end mb-1">
            <a href="#">Back to top</a>
        </p>
        <p class="mb-1">Copyright The Bookshelf! <a href="/admin/login" title="Login Admin">Log in as Admin</a> </p>
    </div>
</footer>

<!-- Toast container -->
<div class='toast-container position-fixed top-0 end-0 p-3'>
    <div id='liveToast' class='toast' role='alert' aria-live='assertive' aria-atomic='true' data-bs-autohide='true'>
        <div class='toast-header'>
            <strong class='me-auto' data-toast-title></strong>
            <button type='button' class='btn-close' data-bs-dismiss='toast' aria-label='Close'></button>
        </div>
        <div class='toast-body' data-toast-body></div>
    </div>
</div>

<script src="/assets/bootstrap/js/bootstrap.min.js"></script>
<script src="/assets/js/script.js"></script>
</body>
</html>
<?php

  /** @var $conn $conn */
  if ($conn) {
    sqlsrv_close($conn);
  }
?>