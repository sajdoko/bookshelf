</div>
</main>


<script src="/assets/bootstrap/js/bootstrap.bundle.min.js"></script>
<!--<script src='/assets/js/libs/feather.min.js'></script>-->
<script src='/assets/js/libs/Chart.min.js'></script>
<script src="/assets/js/dashboard.js"></script>
</body>
</html>

<?php

  /** @var $conn $conn */
  if ($conn) {
    sqlsrv_close($conn);
  }
?>