<?php
  $page_title = "Customers";
  require_once dirname(__FILE__, 2).'/includes/header.php';

  $customers = retrieveAllRows(
    'SELECT * FROM CUSTOMER'
  );
?>
    <div class='d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center me-5'>
        <h1 class='display-5 m-2'><?= $page_title; ?></h1>
        <div class='btn-toolbar'>
            <a href="/admin/customers/add-customer" class='btn btn-sm btn-success'>Add Customer</a>
        </div>
    </div>
    <hr>

    <div class='row'>
        <div class='col'>
          <?php if (count($customers) > 0) : ?>
              <table class="table">
                  <thead>
                  <tr>
                      <th>First Name</th>
                      <th>Last Name</th>
                      <th>Email</th>
                      <th>Phone</th>
                      <th>Reg. Date</th>
                      <th>Action</th>
                  </tr>
                  </thead>
                  <tbody>
                  <?php foreach ($customers as $customer) : ?>
                      <tr>
                          <td><?= $customer['Cus_FirstName']; ?></td>
                          <td><?= $customer['Cus_LastName']; ?></td>
                          <td><?= $customer['Cus_Email']; ?></td>
                          <td><?= $customer['Cus_Phone']; ?></td>
                          <td><?= $customer['Cus_Reg_Date']->format('Y-m-d'); ?></td>
                          <td>
                              <a href="/admin/customers/edit/<?= create_url_string($customer['Cus_Id']); ?>" class="btn btn-sm btn-primary p-1">
                                  <i class='bi bi-pencil-square mx-2'></i>
                              </a>
                              <form class='recordForm d-inline'>
                                  <input type='hidden' name='form_action' value='delete'>
                                  <input type='hidden' name='Cus_Id' value="<?= $customer['Cus_Id']; ?>">
                                  <input type='hidden' name='model' value='customer'>
                                  <button type="submit" class='btn btn-sm btn-outline-danger p-1'>
                                      <i class='bi bi-trash mx-2' data-bs-toggle='tooltip' data-bs-placement='left'
                                         data-bs-title='Delete the customer?'></i>
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