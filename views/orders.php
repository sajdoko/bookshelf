<?php

$page_title = "Orders";
require_once 'header.php';
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

<?php require_once 'footer.php'; ?>