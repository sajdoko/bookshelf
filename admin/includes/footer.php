</div>
</main>

<!-- Toast container -->
<div class='toast-container position-fixed bottom-0 end-0 p-3'>
    <div id='liveToast' class='toast' role='alert' aria-live='assertive' aria-atomic='true' data-bs-autohide='false'>
        <div class='toast-header'>
            <strong class='me-auto' data-toast-title></strong>
            <button type='button' class='btn-close' data-bs-dismiss='toast' aria-label='Close'></button>
        </div>
        <div class='toast-body' data-toast-body></div>
    </div>
</div>

<script src="/assets/bootstrap/js/bootstrap.bundle.min.js"></script>
<!--<script src='/assets/js/libs/feather.min.js'></script>-->
<script src='/assets/js/libs/Chart.min.js'></script>
<script src='/assets/js/script.js'></script>
<script src="/assets/js/dashboard.js"></script>
</body>
</html>

<?php

  /** @var $conn $conn */
  if ($conn) {
    $conn = null; // Close the PDO connection
  }
?>