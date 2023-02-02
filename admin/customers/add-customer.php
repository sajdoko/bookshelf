<?php
  $page_title = "Add Customer";
  require_once dirname(__FILE__, 2).'/includes/header.php';

?>
    <div class='row'>
        <div class='col'>
            <h1 class='display-5 m-3'>Add Customer</h1>
            <hr>
        </div>
    </div>

    <div class="row pb-4">
        <div class="col-6">
            <form class='row g-3 recordForm'>
                <div class='col-md-6'>
                    <label for='Cus_FirstName' class='form-label'>First Name</label>
                    <input type='text' name="Cus_FirstName" class='form-control' id='Cus_FirstName' required>
                </div>
                <div class='col-md-6'>
                    <label for='Cus_LastName' class='form-label'>Last Name</label>
                    <input type='text' name='Cus_LastName' class='form-control' id='Cus_LastName' required>
                </div>
                <div class='col-md-4'>
                    <label for='Cus_Email' class='form-label'>Email</label>
                    <input type='email' name='Cus_Email' class='form-control' id='Cus_Email' required>
                </div>
                <div class='col-md-4'>
                    <label for='Cus_Pass' class='form-label'>Password</label>
                    <input type='password' name='Cus_Pass' class='form-control' id='Cus_Pass' required>
                </div>
                <div class='col-md-4'>
                    <label for='Cus_Phone' class='form-label'>Phone</label>
                    <input type='text' name='Cus_Phone' class='form-control' id='Cus_Phone' required>
                </div>
                <div class='col-12 mt-5'>
                    <input type="hidden" name="form_action" value="insert">
                    <input type='hidden' name='model' value='customer'>
                    <button type='submit' class='btn btn-primary w-50'>Add Customer</button>
                </div>
            </form>
        </div>
    </div>

<?php require_once dirname(__FILE__, 2).'/includes/footer.php'; ?>