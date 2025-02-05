<?php
  $page_title = "My orders";
  require_once dirname(__DIR__) . '/views/header.php';

  // Check if the user is logged in
  if (!login_check_customer()) {
    header("Location: /pages/login");
    exit;
  }

  $user_id = $_SESSION['Cus_Id'] ?? 0;
  $alerts = [];

  // Get the user's info from the database
  $user = get_customer_info($user_id);

  if (empty($user)) {
    header("Location: /pages/login");
    exit;
  }

  $cus_orders = retrieveAllRows('SELECT CUS_ORDER.Cus_Id, CUS_ORDER.Ord_Id, CUS_ORDER.Ord_Date, CUS_ORDER.Ord_Tot_Val, SM.ShM_Name, OS.OrS_Name 
        FROM CUS_ORDER
             JOIN SHIPPING_METHOD SM ON CUS_ORDER.ShM_Id = SM.ShM_Id
             LEFT JOIN
                (SELECT Ord_Id, MAX(OrH_Date) AS OrH_Date FROM ORDER_HISTORY GROUP BY Ord_Id) AS Order_History_Max
                ON CUS_ORDER.Ord_Id = Order_History_Max.Ord_Id
             LEFT JOIN ORDER_HISTORY OH ON CUS_ORDER.Ord_Id = OH.Ord_Id AND Order_History_Max.OrH_Date = OH.OrH_Date
             LEFT JOIN ORDER_STATUS OS ON OH.OrS_Id = OS.OrS_Id
        WHERE CUS_ORDER.Cus_Id = ?', [$user_id]);
?>


    <div class='container'>
        <!-- Display error message if there is one -->
      <?php if (!empty($alerts)) : ?>
          <div class="row">
              <div class="col-md-6 offset-md-3">
                <?php foreach ($alerts as $alert): ?>
                  <?php echo '<div class="alert alert-'.$alert[0].'">'.$alert[1].'</div>'; ?>
                <?php endforeach; ?>
              </div>
          </div>
      <?php endif; ?>

        <div class="row">
            <div class="col-12">
                <h1 class='display-5 mb-4'>Your Orders</h1>
              <?php if (!empty($cus_orders)) : ?>
                  <table class='table table-striped'>
                      <thead>
                      <tr>
                          <th scope='col'>Order Id</th>
                          <th scope='col'>Order Date</th>
                          <th scope='col'>Order Status</th>
                          <th scope='col'>Shipping Method</th>
                          <th scope='col'>Order Total</th>
                      </tr>
                      </thead>
                      <tbody class='table-group-divider'>
                      <?php foreach ($cus_orders as $cus_order) : ?>
                          <tr>
                              <th scope='row'><?= $cus_order['Ord_Id']; ?></th>
                              <td><?= $cus_order['Ord_Date']; ?></td>
                              <td><?= $cus_order['OrS_Name']; ?></td>
                              <td><?= $cus_order['ShM_Name']; ?></td>
                              <td>&euro;<?= number_format($cus_order['Ord_Tot_Val'], 2); ?></td>
                          </tr>
                        <?php $lines = get_order_lines($cus_order['Ord_Id']); ?>
                        <?php if (!empty($lines)) : ?>
                              <tr>
                                  <td></td>
                                  <td colspan='4'>
                                      <table class='table mb-0'>
                                          <thead>
                                          <tr>
                                              <th scope='col'>Book</th>
                                              <th scope='col'>Quantity</th>
                                              <th scope='col'>Total Price</th>
                                          </tr>
                                          </thead>
                                          <tbody class='table-group-divider'>
                                          <?php foreach ($lines as $line) : ?>
                                              <tr>
                                                  <th scope='row'><a href='/book/<?= create_url_string($line['Boo_Title']); ?>'
                                                                     title="<?= $line['Boo_Title']; ?>"><?= $line['Boo_Title']; ?></a></th>
                                                  <td><?= $line['OrL_Quantity']; ?></td>
                                                  <td>&euro;<?= number_format($line['OrL_Tot_Price'], 2); ?></td>
                                              </tr>
                                          <?php endforeach; ?>
                                          </tbody>
                                      </table>
                                  </td>
                              </tr>
                        <?php endif; ?>
                      <?php endforeach; ?>
                      </tbody>
                  </table>
            <?php else : ?>
                <div class='alert alert-info'>You have no orders.</div>
              <?php endif; ?>
            </div>
        </div>

    </div>

<?php require_once dirname(__DIR__) . '/views/footer.php'; ?>