<?php
  $page_title = "Orders List";
  require_once dirname(__FILE__, 2).'/includes/header.php';

  $cus_orders = retrieveAllRows('SELECT CUS_ORDER.Cus_Id, CUS_ORDER.Ord_Id, CUS_ORDER.Ord_Date, CUS_ORDER.Ord_Tot_Val, SM.ShM_Name, OS.OrS_Name FROM CUS_ORDER 
         JOIN SHIPPING_METHOD SM ON SM.ShM_Id = CUS_ORDER.ShM_Id
         LEFT JOIN ORDER_HISTORY OH on CUS_ORDER.Ord_Id = OH.Ord_Id
         LEFT JOIN ORDER_STATUS OS ON OH.OrS_Id = OS.OrS_Id
         LEFT JOIN CUS_ORDER CO on CO.Ord_Id = OH.Ord_Id
         GROUP BY CUS_ORDER.Cus_Id, CUS_ORDER.Ord_Id, CUS_ORDER.Ord_Date, CUS_ORDER.Ord_Tot_Val, SM.ShM_Name, OS.OrS_Name
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
                          <td><?= $cus_order['Ord_Date']->format('Y-m-d H:i:s'); ?></td>
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