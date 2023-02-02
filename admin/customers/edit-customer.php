<?php
  $page_title = "Edit Customer";
  require_once dirname(__FILE__, 2).'/includes/header.php';

  $url = $_SERVER['REQUEST_URI'];
  $url_parts = explode('/', $url);
  $customer_id = (int) end($url_parts);
//  echo $book_url_string;
  $customer = retrieveOneRow(
    'SELECT * FROM CUSTOMER WHERE Cus_Id = ?', [$customer_id]
  );

  if (!$customer) {
    http_response_code(404);
    include_once dirname(__FILE__, 3).'/pages/404.php';
    die(404);
  }

//  echo "<pre>";
//print_r($books);
//  echo '</pre>';
?>
    <div class='row'>
        <div class='col'>
            <h1 class='display-5 m-3'><?= 'Editing - '.$customer['Cus_FirstName']; ?></h1>
            <hr>
        </div>
    </div>

    <div class="row pb-4">
        <div class="col-6">
            <form class='row g-3 recordForm'>
                <div class='col-md-6'>
                    <label for='Cus_FirstName' class='form-label'>First Name</label>
                    <input type='text' name="Cus_FirstName" class='form-control' id='Cus_FirstName' value="<?= $customer['Cus_FirstName']; ?>" required>
                </div>
                <div class='col-md-6'>
                    <label for='Cus_LastName' class='form-label'>Last Name</label>
                    <input type='text' name='Cus_LastName' class='form-control' id='Cus_LastName' value="<?= $customer['Cus_LastName']; ?>" required>
                </div>
                <div class='col-md-4'>
                    <label for='Cus_Email' class='form-label'>Email</label>
                    <input type='email' name='Cus_Email' class='form-control' id='Cus_Email' value="<?= $customer['Cus_Email']; ?>" required>
                </div>
                <div class='col-md-4'>
                    <label for='Cus_Phone' class='form-label'>Phone</label>
                    <input type='text' name='Cus_Phone' class='form-control' id='Cus_Phone' value="<?= $customer['Cus_Phone']; ?>" required>
                </div>
                <div class='col-md-4'>
                    <label for='Cus_Reg_Date' class='form-label'>Registration Date</label>
                    <input type='date' name="Cus_Reg_Date" class='form-control' id='Cus_Reg_Date' value="<?= $customer['Cus_Reg_Date']->format('Y-m-d'); ?>" required>
                </div>
                <div class='col-12 mt-5'>
                    <input type="hidden" name="form_action" value="update">
                    <input type='hidden' name='model' value='customer'>
                    <input type='hidden' name='Cus_Id' value="<?= $customer['Cus_Id']; ?>">
                    <button type='submit' class='btn btn-primary w-50'>Update Customer</button>
                </div>
            </form>
        </div>
    </div>

<?php require_once dirname(__FILE__, 2).'/includes/footer.php'; ?>