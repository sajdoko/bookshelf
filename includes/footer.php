</main>

<footer class="text-muted py-5">
    <div class="container">
        <p class="float-end mb-1">
            <a href="#">Back to top</a>
        </p>
        <p class="mb-1">Copyright The Bookshelf!</p>
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

<!--    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>-->
<!--    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.3/dist/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>-->
<script src="/assets/bootstrap/js/bootstrap.min.js"></script>
<script src="/assets/js/script.js"></script>
<link rel='stylesheet' href='https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.3/font/bootstrap-icons.css'>
</body>
</html>
<?php

  /** @var $conn $conn */
  if ($conn) {
    sqlsrv_close($conn);
  }
?>