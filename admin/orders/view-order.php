<?php
  $page_title = "Edit Customer";
  require_once dirname(__FILE__, 2).'/includes/header.php';

  $url = $_SERVER['REQUEST_URI'];
  $url_parts = explode('/', $url);
  $Ord_Id = (int) end($url_parts);


  $order = retrieveOneRow(
    'SELECT CUS_ORDER.Cus_Id, CUS_ORDER.Ord_Id, CUS_ORDER.Ord_Date, CUS_ORDER.Ord_Tot_Val, SM.ShM_Name, C.Cus_Id, OS.OrS_Id, OS.OrS_Name
        FROM CUS_ORDER
             JOIN SHIPPING_METHOD SM ON CUS_ORDER.ShM_Id = SM.ShM_Id
             LEFT JOIN
                (SELECT Ord_Id, MAX(OrH_Date) AS OrH_Date FROM ORDER_HISTORY GROUP BY Ord_Id) AS Order_History_Max
                ON CUS_ORDER.Ord_Id = Order_History_Max.Ord_Id
             LEFT JOIN ORDER_HISTORY OH ON CUS_ORDER.Ord_Id = OH.Ord_Id AND Order_History_Max.OrH_Date = OH.OrH_Date
             LEFT JOIN ORDER_STATUS OS ON OH.OrS_Id = OS.OrS_Id
            LEFT JOIN CUSTOMER C on CUS_ORDER.Cus_Id = C.Cus_Id
         WHERE CUS_ORDER.Ord_Id = ?', [$Ord_Id]
  );

  if (!$order) {
    http_response_code(404);
    include_once dirname(__FILE__, 3).'/pages/404.php';
    die(404);
  }

  $lines = get_order_lines($order['Ord_Id']);

  $order_statuses = retrieveAllRows('SELECT * FROM ORDER_STATUS');
  $order_history = retrieveAllRows('SELECT * FROM ORDER_HISTORY OH JOIN ORDER_STATUS OS ON OH.OrS_Id = OS.OrS_Id WHERE Ord_Id = ?', [$Ord_Id]);

//  echo "<pre>";
//print_r($order);
//  echo '</pre>';
//  echo '<pre>';
//  print_r($lines);
//  echo '</pre>';
?>
    <div class='row'>
        <div class='col'>
            <h1 class='display-5 m-3'><?= 'Viewing Order Id - <span>#'.$order['Ord_Id']; ?></span></h1>
            <hr>
        </div>
    </div>

    <div class='mb-9'>
        <div class='d-flex flex-wrap flex-between-center mb-1'>
            <p class='text-800 lh-sm mb-0'>Customer ID : <span>#<?= $order['Cus_Id']; ?></span></p>
        </div>
        <div class='row g-5 gy-7'>
            <div class='col-md-10'>
                    <div class='table-responsive'>
                        <table class='table fs--1 mb-0 border-top border-200'>
                            <thead>
                                <tr>
                                  <th scope='col'>Book</th>
                                  <th scope='col'>Price</th>
                                  <th scope='col'>Quantity</th>
                                  <th scope='col'>Total Price</th>
                                </tr>
                            </thead>
                            <tbody class='list' id='order-table-body'>
                                <?php foreach ($lines as $line) : ?>
                                    <tr>
                                      <th scope='row'><a href='/book/<?= create_url_string($line['Boo_Title']); ?>'
                                                         title="<?= $line['Boo_Title']; ?>"><?= $line['Boo_Title']; ?></a></th>
                                      <td>&euro;<?= number_format($line['OrL_Price'], 2); ?></td>
                                      <td><?= $line['OrL_Quantity']; ?></td>
                                      <td>&euro;<?= number_format($line['OrL_Tot_Price'], 2); ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                <div class='text-end'>
                    <h4 class='pb-3'>Items subtotal: &euro;<?= number_format($order['Ord_Tot_Val'], 2); ?></h4>
                </div>
            </div>
            <div class='col-md-2'>
                <div class='row'>
                    <div class='col-12'>
                        <div class='card'>
                            <div class='card-body'>
                                <h3 class='card-title mb-4'>Order Status</h3>
                                <select name="OrS_Id" class='form-select mb-4'>
                                  <?php foreach ($order_statuses as $order_status) : ?>
                                      <option value="<?= $order_status['OrS_Id']; ?>" <?= ($order_status['OrS_Id'] == $order['OrS_Id']) ? 'selected' : ''; ?>><?= $order_status['OrS_Name']; ?></option>
                                  <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12">
                <div class='timeline-vertical'>
                  <h3 class="fs-3">Order History</h3>
                    <?php foreach ($order_history as $history) : ?>
                    <div class='timeline-item'>
                        <div class='row g-md-3 align-items-center mb-8 mb-lg-10'>
                            <div class='col-12 col-md-auto d-flex'>
                                <div class='text-end'>
                                    <p class='fs--2 fw-semi-bold text-700 mb-0'><?= $history['OrH_Date']->format('Y-m-d H:i:s'); ?></p>
                                </div>
                                <div class='timeline-item-bar position-relative me-3 me-md-0 border-400'>
                                    <span class='timeline-bar border-end border-success'></span>
                                </div>
                            </div>
                            <div class='col'>
                                <div class='timeline-item-content ps-6 ps-md-3'>
                                    <h4><?= $history['OrS_Name']; ?></h4>
                                    <p class='fs--1 text-800 mb-0'><?= $history['OrH_Description']; ?></p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </div>

<?php require_once dirname(__FILE__, 2).'/includes/footer.php'; ?>