<?php
  $page_title = "Edit Customer";
  require_once dirname(__FILE__, 2).'/includes/header.php';

  $url = $_SERVER['REQUEST_URI'];
  $url_parts = explode('/', $url);
  $Ord_Id = (int) end($url_parts);


  $order = retrieveOneRow(
    'SELECT CUS_ORDER.Cus_Id, CUS_ORDER.Ord_Id, CUS_ORDER.Ord_Date, CUS_ORDER.Ord_Tot_Val, SM.ShM_Name FROM CUS_ORDER 
         JOIN SHIPPING_METHOD SM on SM.ShM_Id = CUS_ORDER.ShM_Id
         LEFT JOIN ORDER_HISTORY OH on CUS_ORDER.Ord_Id = OH.Ord_Id
         LEFT JOIN ORDER_STATUS OS ON OH.OrS_Id = OS.OrS_Id
         LEFT JOIN CUS_ORDER CO on CO.Ord_Id = OH.Ord_Id
         WHERE CUS_ORDER.Ord_Id = ?
         GROUP BY CUS_ORDER.Cus_Id, CUS_ORDER.Ord_Id, CUS_ORDER.Ord_Date, CUS_ORDER.Ord_Tot_Val, SM.ShM_Name', [$Ord_Id]
  );

  if (!$order) {
    http_response_code(404);
    include_once dirname(__FILE__, 3).'/pages/404.php';
    die(404);
  }

  $lines = get_order_lines($order['Ord_Id']);

//  echo "<pre>";
//print_r($books);
//  echo '</pre>';
?>
    <div class='row'>
        <div class='col'>
            <h1 class='display-5 m-3'><?= 'Viewing Order Id - '.$order['Ord_Id']; ?></h1>
            <hr>
        </div>
    </div>

    <div class="row pb-4">
        <div class="col-4">
          <?php
//            echo '<pre>';
//            print_r($order);
//            echo '</pre><hr>';
//              echo "<pre>";
//            print_r($lines);
//              echo '</pre>';
          ?>

    </div>

<?php require_once dirname(__FILE__, 2).'/includes/footer.php'; ?>