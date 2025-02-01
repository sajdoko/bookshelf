<?php
  $page_title = "Orders List";
  require_once dirname(__FILE__, 2).'/includes/header.php';

  $cus_orders = retrieveAllRows('SELECT CUS_ORDER.Cus_Id, CUS_ORDER.Ord_Id, CUS_ORDER.Ord_Date, CUS_ORDER.Ord_Tot_Val, SM.ShM_Name, OS.OrS_Name 
        FROM CUS_ORDER
             JOIN SHIPPING_METHOD SM ON CUS_ORDER.ShM_Id = SM.ShM_Id
             LEFT JOIN
                (SELECT Ord_Id, MAX(OrH_Date) AS OrH_Date FROM ORDER_HISTORY GROUP BY Ord_Id) AS Order_History_Max
                ON CUS_ORDER.Ord_Id = Order_History_Max.Ord_Id
             LEFT JOIN ORDER_HISTORY OH ON CUS_ORDER.Ord_Id = OH.Ord_Id AND Order_History_Max.OrH_Date = OH.OrH_Date
             LEFT JOIN ORDER_STATUS OS ON OH.OrS_Id = OS.OrS_Id
             ');
?>
    <div class='row'>
        <div class='col-12'>
            <h1 class='display-5 m-3'><?= $page_title; ?></h1>
            <hr>
        </div>
    </div>

    <div class='row'>
        <div class='col-12'>
          <?php if (!empty($cus_orders)) : ?>
              <table class='table table-striped'>
                  <thead>
                  <tr>
                      <th scope='col'>Order Id</th>
                      <th scope='col'>Order Date</th>
                      <th scope='col'>Shipping Method</th>
                      <th scope='col'>Order Status</th>
                      <th scope='col'>Order Total</th>
                      <th scope='col'>Action</th>
                  </tr>
                  </thead>
                  <tbody class='table-group-divider'>
                  <?php foreach ($cus_orders as $cus_order) : ?>
                      <tr>
                          <th scope='row'><?= $cus_order['Ord_Id']; ?></th>
                          <td><?= $cus_order['Ord_Date']; ?></td>
                          <td><?= $cus_order['ShM_Name']; ?></td>
                          <td><?= $cus_order['OrS_Name']; ?></td>
                          <td>&euro;<?= number_format($cus_order['Ord_Tot_Val'], 2); ?></td>
                          <td>
                              <a href="/admin/orders/view/<?= create_url_string($cus_order['Ord_Id']); ?>" class='btn btn-sm btn-info p-1'>
                                  <i class='bi bi-eye mx-2'></i>
                              </a>
                              <form class='recordForm d-inline'>
                                  <input type='hidden' name='form_action' value='delete'>
                                  <input type='hidden' name='Ord_Id' value="<?= $cus_order['Ord_Id']; ?>">
                                  <input type='hidden' name='model' value='order'>
                                  <button type='submit' class='btn btn-sm btn-outline-danger p-1'>
                                      <i class='bi bi-trash mx-2' data-bs-toggle='tooltip' data-bs-placement='left'
                                         data-bs-title='Delete the order?'></i>
                                  </button>
                              </form>
                          </td>
                      </tr>
                  <?php endforeach; ?>
                  </tbody>
              </table>
          <?php endif; ?>
        </div>
    </div>
<?php require_once dirname(__FILE__, 2).'/includes/footer.php'; ?>